<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Debt
 *
 * @ORM\Table(name="debts")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\DebtRepository")
 */
class Debt
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="external_id", type="integer")
     */
    private $externalId;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="decimal", precision=9, scale=2)
     */
    private $amount;

    /**
     * @var Debtor
     *
     * @ORM\ManyToOne(targetEntity="Debtor", inversedBy="debts")
     * @ORM\JoinColumn(name="debtor_id", referencedColumnName="id")
     */
    private $debtor;

    /**
     * @var Entity
     *
     * @ORM\ManyToOne(targetEntity="Entity", inversedBy="debts")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id")
     */
    private $entity;

    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="string", length=255)
     */
    private $reason;

    /**
     * @var string
     *
     * @ORM\Column(name="observations", type="text", nullable=true)
     */
    private $observations;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set externalId
     *
     * @param integer $externalId
     *
     * @return Debt
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * Get externalId
     *
     * @return int
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return Debt
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set debtor
     *
     * @param string $debtor
     *
     * @return Debt
     */
    public function setDebtor($debtor)
    {
        $this->debtor = $debtor;

        return $this;
    }

    /**
     * Get debtor
     *
     * @return Debtor
     */
    public function getDebtor()
    {
        return $this->debtor;
    }

    /**
     * Set entity
     *
     * @param string $entity
     *
     * @return Debt
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set reason
     *
     * @param string $reason
     *
     * @return Debt
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set observations
     *
     * @param string $observations
     *
     * @return Debt
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * Get observations
     *
     * @return string
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Debt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Debt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}

