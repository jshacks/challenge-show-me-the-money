<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alert
 *
 * @ORM\Table(name="alerts")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\AlertRepository")
 */
class Alert
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
     * @ORM\ManyToOne(targetEntity="PayoutNotice", inversedBy="alerts")
     * @ORM\JoinColumn(name="payout_notice_id", referencedColumnName="id")
     */
    private $payoutNotice;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Entity", inversedBy="alerts")
     * @ORM\JoinColumn(name="watcher_id", referencedColumnName="id")
     */
    private $watcher;

    /**
     * @var bool
     *
     * @ORM\Column(name="seen", type="boolean")
     */
    private $seen;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;


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
     * Set payoutNotice
     *
     * @param string $payoutNotice
     *
     * @return Alert
     */
    public function setPayoutNotice($payoutNotice)
    {
        $this->payoutNotice = $payoutNotice;

        return $this;
    }

    /**
     * Get payoutNotice
     *
     * @return string
     */
    public function getPayoutNotice()
    {
        return $this->payoutNotice;
    }

    /**
     * Set watcher
     *
     * @param string $watcher
     *
     * @return Alert
     */
    public function setWatcher($watcher)
    {
        $this->watcher = $watcher;

        return $this;
    }

    /**
     * Get watcher
     *
     * @return string
     */
    public function getWatcher()
    {
        return $this->watcher;
    }

    /**
     * Set seen
     *
     * @param boolean $seen
     *
     * @return Alert
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get seen
     *
     * @return bool
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Alert
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

