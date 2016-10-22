<?php

namespace ApiBundle\Service;

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
        'externalId',
        'firstName',
        'lastName',
        'pin',
        'birthDate',
        'birthPlace',
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
            'createdAt' => $watcher->getCreatedAt()->getTimestamp(),
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
                'createdAt' => $debt->getCreatedAt()->getTimestamp(),
                'updatedAt' => $debt->getUpdatedAt()->getTimestamp(),
            );
        }

        return array_values($debtors);
    }

    public function getPayoutNoticesForWatcher(Entity $watcher)
    {
        $payoutNotices = array();
        $alerts = $watcher->getAlerts();

        foreach ($alerts as $alert) {
            $payoutNotice = $alert->getPayoutNotice();

            $payoutNotices[] = array(
                'ref' => $payoutNotice->getRef(),
                'amount' => $payoutNotice->getAmount(),
                'createdAt' => $payoutNotice->getCreatedAt()->getTimestamp(),
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
                        'amount' => $this->getDebtAmountByDebtor($payoutNotice->getDebtor()),
                        'count' => count($payoutNotice->getDebtor()->getDebts()),
                    ),
                ),
                'author' => array(
                    'id' => $payoutNotice->getAuthor(),
                    'name' => $payoutNotice->getAuthor()->getName(),
                    'identifier' => $payoutNotice->getAuthor()->getIdentifier(),
                    'email' => $payoutNotice->getAuthor()->getEmail(),
                    'createdAt' => $payoutNotice->getAuthor()->getCreatedAt()->getTimestamp(),
                ),
            );
        }

        return $payoutNotices;
    }

    public function getDebtAmountByDebtor(Debtor $debtor)
    {
        $sum = 0.0;
        $debts = $debtor->getDebts();

        foreach ($debts as $debt) {
            $sum = $sum + $debt->getAmount();
        }

        return $sum;
    }
}