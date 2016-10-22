<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PayoutNotice
 *
 * @ORM\Table(name="payout_notices")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\PayoutNoticeRepository")
 */
class PayoutNotice
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
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Debtor", inversedBy="payoutNotices")
     * @ORM\JoinColumn(name="debtor_id", referencedColumnName="id")
     */
    private $debtor;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Entity", inversedBy="payoutNotices")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=255)
     */
    private $ref;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=9, scale=2)
     */
    private $amount;

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
     * @var Alert[]
     *
     * @ORM\OneToMany(targetEntity="Alert", mappedBy="payoutNotice")
     */
    private $alerts;

    /**
     * @return Alert[]
     */
    public function getAlerts()
    {
        return $this->alerts;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="designated_person", type="string", length=255, nullable=true)
     */
    private $designatedPerson;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_account", type="string", length=255, nullable=true)
     */
    private $bankAccount;

    /**
     * @return string
     */
    public function getDesignatedPerson()
    {
        return $this->designatedPerson;
    }

    /**
     * @param $designatedPerson
     * @return $this
     */
    public function setDesignatedPerson($designatedPerson)
    {
        $this->designatedPerson = $designatedPerson;

        return $this;
    }

    /**
     * @return string
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * @param $bankAccount
     * @return $this
     */
    public function setBankAccount($bankAccount)
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

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
     * Set debtor
     *
     * @param string $debtor
     *
     * @return PayoutNotice
     */
    public function setDebtor($debtor)
    {
        $this->debtor = $debtor;

        return $this;
    }

    /**
     * Get debtor
     *
     * @return string
     */
    public function getDebtor()
    {
        return $this->debtor;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return PayoutNotice
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set ref
     *
     * @param string $ref
     *
     * @return PayoutNotice
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return PayoutNotice
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set observations
     *
     * @param string $observations
     *
     * @return PayoutNotice
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
     * @return PayoutNotice
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
}

