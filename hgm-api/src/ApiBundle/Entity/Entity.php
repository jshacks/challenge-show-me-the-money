<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Entity
 *
 * @ORM\Table(name="entities")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\EntityRepository")
 *
 * @UniqueEntity(
 *      fields={"email"},
 *      ignoreNull=true,
 *      message="This email is already registered."
 * )
 */
class Entity
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
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=255)
     */
    private $identifier;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     *
     * @Assert\NotBlank()
     *
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *      min = 8,
     *      max = 255,
     *      minMessage = "Your password must be at least {{ limit }} characters long.",
     *      maxMessage = "Your password cannot be longer than {{ limit }} characters."
     * )
     *
     * @Assert\Regex(
     *     pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/",
     *     message="Your password must be at least 8 characters long, with minimum 1 uppercase letter, 1 lowercase letter and 1 number."
     * )
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="password_salt", type="string", length=255, nullable=true)
     */
    private $passwordSalt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @var Debt[]
     *
     * @ORM\OneToMany(targetEntity="Debt", mappedBy="entity")
     */
    private $debts;

    /**
     * @return Debt[]
     */
    public function getDebts()
    {
        return $this->debts;
    }

    /**
     * @var PayoutNotice[]
     *
     * @ORM\OneToMany(targetEntity="PayoutNotice", mappedBy="author")
     */
    private $payoutNotices;

    /**
     * @return PayoutNotice[]
     */
    public function getPayoutNotices()
    {
        return $this->payoutNotices;
    }

    /**
     * @var Alert[]
     *
     * @ORM\OneToMany(targetEntity="Alert", mappedBy="watcher")
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
     * @ORM\Column(name="auth_token", type="string", length=255, nullable=true)
     */
    private $authToken;

    /**
     * @return string
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * @param $authToken
     * @return $this
     */
    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;

        return $this;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="register_confirm_token", type="string", length=255, nullable=true)
     */
    private $registerConfirmToken;

    /**
     * @return string
     */
    public function getRegisterConfirmToken()
    {
        return $this->registerConfirmToken;
    }

    /**
     * @param $registerConfirmToken
     * @return $this
     */
    public function setRegisterConfirmToken($registerConfirmToken)
    {
        $this->registerConfirmToken = $registerConfirmToken;

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
     * Set name
     *
     * @param string $name
     *
     * @return Entity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return Entity
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Entity
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Entity
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set passwordSalt
     *
     * @param string $passwordSalt
     *
     * @return Entity
     */
    public function setPasswordSalt($passwordSalt)
    {
        $this->passwordSalt = $passwordSalt;

        return $this;
    }

    /**
     * Get passwordSalt
     *
     * @return string
     */
    public function getPasswordSalt()
    {
        return $this->passwordSalt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Entity
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
     * Set type
     *
     * @param string $type
     *
     * @return Entity
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}

