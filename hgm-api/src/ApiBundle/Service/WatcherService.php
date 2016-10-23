<?php

namespace ApiBundle\Service;

use ApiBundle\Entity\Debt;
use ApiBundle\Entity\Debtor;
use ApiBundle\Entity\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\RecursiveValidator as Validator;

class WatcherService
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
     * @var array
     */
    private $saveExpectedKeys = array(
        'firstName',
        'lastName',
        'pin',
        'birthDate',
        'birthPlace',
    );

    private $saveDebtExpectedKeys = array(
        'externalId',
        'amount',
        'reason',
        'observations',
    );

    /**
     * @param array $data
     * @return array
     */
    public function save($data = array())
    {
        $debtor = new Debtor();
        foreach ($this->saveExpectedKeys as $expectedKey) {
            if (isset($data[$expectedKey])) {
                $setter = 'set' . ucfirst($expectedKey);
                $debtor->$setter($data[$expectedKey]);
            }
        }

        $errors = $this->validator->validate($debtor);
        if (count($errors) > 0) {
            $errors = UtilService::getViolationListAsArray($errors);
            return array('errors' => $errors);
        }

        $this->em->persist($debtor);
        $this->em->flush();

        return array(
            'results' => array(
                'id' => $debtor->getId(),
            ),
        );
    }

    /**
     * @param array $data
     * @param Entity $watcher
     * @return array
     */
    public function saveDebt($data = array(), Entity $watcher)
    {
        $debtorId = @$data['debtorId'];
        $debtor = $this->em->getRepository('ApiBundle:Debtor')->find($debtorId);

        if ($debtor instanceof Debtor) {
            $debt = new Debt();
            $debt->setDebtor($debtor);
            $debt->setEntity($watcher);

            foreach ($this->saveDebtExpectedKeys as $key) {
                if (isset($data[$key])) {
                    $setter = 'set' . ucfirst($key);
                    $debt->$setter($data[$key]);
                }
            }

            $errors = $this->validator->validate($debt);
            if (count($errors) > 0) {
                return array(
                    'errors' => UtilService::getViolationListAsArray($errors),
                );
            }

            $this->em->persist($debt);
            $this->em->flush();

            return array(
                'results' => array(
                    'id' => $debt->getId(),
                ),
            );
        }

        return array(
            'errors' => array(
                'debtorId' => 'This value is not associated to any debtor\'s "id"',
            ),
        );
    }

    /**
     * @param Entity $watcher
     * @return array
     */
    public function getWatcherFormatted(Entity $watcher)
    {
        $returnArr = array(
            'id' => $watcher->getId(),
            'name' => $watcher->getName(),
            'identifier' => $watcher->getIdentifier(),
            'email' => $watcher->getEmail(),
            'createdAt' => $watcher->getCreatedAt()->getTimestamp() * 1000,
        );

        $returnArr['debtors'] = $this->getDebtorsForWatcher($watcher);
        $returnArr['payoutNotices'] = $this->getPayoutNoticesForWatcher($watcher);

        return $returnArr;
    }

    /**
     * @param Entity $watcher
     * @return array
     */
    public function getDebtorsForWatcher(Entity $watcher)
    {
        $debtors = array();
        $debts = $watcher->getDebts();

        foreach ($debts as $debt) {
            $debtor = $debt->getDebtor();

            if (!isset($debtors[$debtor->getId()])) {
                $debtors[$debtor->getId()] = array(
                    'id' => $debtor->getId(),
                    'firstName' => $debtor->getFirstName(),
                    'lastName' => $debtor->getLastName(),
                    'CNP' => $debtor->getPin(),
                    'birthDate' => $debtor->getBirthDate()->format('d/m/Y'),
                    'birthPlace' => $debtor->getBirthPlace(),
                    'debts' => array(),
                );
            }

            $debtors[$debtor->getId()]['debts'][] = array(
                'id' => $debt->getId(),
                'externalId' => $debt->getExternalId(),
                'amount' => $debt->getAmount(),
                'reason' => $debt->getReason(),
                'createdAt' => $debt->getCreatedAt()->getTimestamp() * 1000,
                'updatedAt' => $debt->getUpdatedAt()->getTimestamp() * 1000,
            );
        }

        return array_values($debtors);
    }

    /**
     * @param Entity $watcher
     * @return array
     */
    public function getPayoutNoticesForWatcher(Entity $watcher)
    {
        $payoutNotices = array();
        $alerts = $watcher->getAlerts();

        foreach ($alerts as $alert) {
            $payoutNotice = $alert->getPayoutNotice();

            $payoutNotices[] = array(
                'ref' => $payoutNotice->getRef(),
                'amount' => $payoutNotice->getAmount(),
                'createdAt' => $payoutNotice->getCreatedAt()->getTimestamp() * 1000,
                'observations' => $payoutNotice->getObservations(),
                'designatedPerson' => $payoutNotice->getDesignatedPerson(),
                'bankAccount' => $payoutNotice->getBankAccount(),
                'debtor' => array(
                    'id' => $payoutNotice->getDebtor()->getId(),
                    'firstName' => $payoutNotice->getDebtor()->getFirstName(),
                    'lastName' => $payoutNotice->getDebtor()->getLastName(),
                    'CNP' => $payoutNotice->getDebtor()->getPin(),
                    'birthDate' => $payoutNotice->getDebtor()->getBirthDate(),
                    'birthPlace' => $payoutNotice->getDebtor()->getBirthPlace(),
                    'debt' => array(
                        'amount' => self::getDebtAmountByDebtor($payoutNotice->getDebtor()),
                        'count' => count($payoutNotice->getDebtor()->getDebts()),
                    ),
                ),
                'author' => array(
                    'id' => $payoutNotice->getAuthor(),
                    'name' => $payoutNotice->getAuthor()->getName(),
                    'identifier' => $payoutNotice->getAuthor()->getIdentifier(),
                    'email' => $payoutNotice->getAuthor()->getEmail(),
                    'createdAt' => $payoutNotice->getAuthor()->getCreatedAt()->getTimestamp() * 1000,
                ),
            );
        }

        return $payoutNotices;
    }

    /**
     * @param Debtor $debtor
     * @return float
     */
    public static function getDebtAmountByDebtor(Debtor $debtor)
    {
        $sum = 0.0;
        $debts = $debtor->getDebts();

        foreach ($debts as $debt) {
            $sum = $sum + $debt->getAmount();
        }

        return $sum;
    }
}