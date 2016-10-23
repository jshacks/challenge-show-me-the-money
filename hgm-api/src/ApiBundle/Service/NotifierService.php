<?php

namespace ApiBundle\Service;

use ApiBundle\Entity\Debt;
use ApiBundle\Entity\Debtor;
use ApiBundle\Entity\Entity;
use ApiBundle\Entity\PayoutNotice;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\RecursiveValidator as Validator;

class NotifierService
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
     * @param Entity $notifier
     * @return array
     */
    public function getNotifierFormatted(Entity $notifier)
    {
        $returnArr = array(
            'id' => $notifier->getId(),
            'name' => $notifier->getName(),
            'identifier' => $notifier->getIdentifier(),
            'email' => $notifier->getEmail(),
            'createdAt' => $notifier->getCreatedAt()->getTimestamp() * 1000,
        );

        $returnArr['debtors'] = $this->getDebtorsForNotifier();
        $returnArr['payoutNotices'] = $this->getPayoutNoticesForNotifier();

        return $returnArr;
    }

    /**
     * @return array
     */
    public function getDebtorsForNotifier()
    {
        $debtors = array();
        $debts = $this->em->getRepository('ApiBundle:Debt')->findAll();
        /** @var Debt $debt */
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
                    'debt' => array(
                        'amount' => 0.0,
                        'watcherCount' => 0,
                    ),
                );
            }

            $debtors[$debtor->getId()]['debt']['amount'] += (double) $debt->getAmount();
            $debtors[$debtor->getId()]['debt']['watcherCount'] ++;
        }

        return array_values($debtors);
    }

    /**
     * @return array
     */
    public function getPayoutNoticesForNotifier()
    {
        $payoutNotices = array();
        $payoutNoticeObjects = $this->em->getRepository('ApiBundle:PayoutNotice')
            ->findAll();

        /** @var PayoutNotice $payoutNotice */
        foreach ($payoutNoticeObjects as $payoutNotice) {

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
                        'amount' => WatcherService::getDebtAmountByDebtor($payoutNotice->getDebtor()),
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
}