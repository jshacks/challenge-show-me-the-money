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