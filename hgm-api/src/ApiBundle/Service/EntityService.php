<?php

namespace ApiBundle\Service;

use ApiBundle\Entity\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\RecursiveValidator as Validator;

class EntityService
{
    /**
     * @var EntityManager $em
     */
    private $em;

    /**
     * @var Validator $validator
     */
    private $validator;

    /**
     * @var EmailService $emailService
     */
    private $emailService;

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param Validator $validator
     */
    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param EmailService $emailService
     */
    public function setEmailService(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * @param array $data
     * @return array
     */
    public function authorize($data = array())
    {
        $email = @$data['email'];
        $entity = $this->em->getRepository('ApiBundle:Entity')
            ->findOneBy(array(
                'email' => $email,
            ));

        if ($entity instanceof Entity) {
            $password = @$data['password'];
            $salt = $entity->getPasswordSalt();

            $hereHashed = $this->hashPassword($password, $salt);
            if ($hereHashed == $entity->getPassword()) {
                $newToken = $this->generateAuthToken($entity->getEmail());
                $entity->setAuthToken($newToken);

                $this->em->flush();
                return array(
                    'token' => $entity->getAuthToken(),
                );
            }
        }

        return array();
    }

    /**
     * @param array $data
     * @return array|\Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public function register($data = array())
    {
        $entity = new Entity();

        $entity->setName(@$data['name']);
        $entity->setEmail(@$data['email']);
        $entity->setIdentifier(@$data['identifier']);
        $entity->setType(@$data['type']);

        $errors = $this->validator->validate($entity);
        if (count($errors) > 0) {
            $errors = UtilService::getViolationListAsArray($errors);
            return array('errors' => $errors);
        }

        $registerToken = $this->generateRegisterConfirmToken($entity->getEmail());
        $entity->setRegisterConfirmToken($registerToken);

        $this->em->persist($entity);
        $this->em->flush();

        $this->emailService->sendRegisterConfirmEmail(
            $entity->getEmail(),
            $entity->getName(),
            $entity->getRegisterConfirmToken()
        );

        return array(
            'results' => array(
                'id' => $entity->getId(),
            ),
        );
    }

    /**
     * @param array $data
     * @return array
     */
    public function registerConfirm($data = array())
    {
        $registerToken = @$data['registerConfirmToken'];
        $entity = $this->em->getRepository('ApiBundle:Entity')
            ->findOneBy(array(
                'registerConfirmToken' => $registerToken,
            ));

        if ($entity instanceof Entity) {
            if ($entity->getPassword()) {
                return array('registerConfirmToken' => 'This user has already confirmed register');
            }

            $password = @$data['password'] ?: 'a';
            $entity->setPassword($password);

            $errors = $this->validator->validate($entity);
            if (count($errors) > 0) {
                return UtilService::getViolationListAsArray($errors);
            }

            $salt = $this->getSaltSample();
            $password = $this->hashPassword($password, $salt);

            $entity->setPassword($password);
            $entity->setPasswordSalt($salt);

            $this->em->flush();
            return array();
        }

        return array('registerConfirmToken' => 'This value is invalid');
    }

    /**
     * @param $authToken
     * @param string $expectType
     * @param bool $confirmed
     * @return null
     */
    public function getAuthenticatedUser($authToken, $expectType = '', $confirmed = true)
    {
        if (empty($authToken)) {
            return null;
        }

        $criteria = array(
            'authToken' => $authToken,
        );

        if ($expectType) {
            $criteria['type'] = $expectType;
        }

        $entity = $this->em->getRepository('ApiBundle:Entity')
            ->findOneBy($criteria);

        if ($entity instanceof Entity) {
            if ($confirmed && !$entity->getPassword()) {
                return null;
            }
        }

        return $entity;
    }

    /**
     * @return string
     */
    private function getSaltSample()
    {
        return uniqid() . md5(microtime() . rand());
    }

    /**
     * @param $password
     * @param $salt
     * @return string
     */
    private function hashPassword($password, $salt)
    {
        $hash = '';
        $salt = $salt ? $salt : '';
        if (is_string($password) && strlen($password) > 0) {
            $hash = hash('sha256', $password . $salt);
        }

        return $hash;
    }

    /**
     * @param $key
     * @return string
     */
    private function generateAuthToken($key)
    {
        return rand() . '__' . md5(microtime()) . '___' . sha1(uniqid() . $key);
    }

    /**
     * @param $key
     * @return string
     */
    private function generateRegisterConfirmToken($key)
    {
        return rand() . sha1(microtime() . $key);
    }
}