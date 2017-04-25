<?php

namespace Sunshine\OrganizationBundle\Entity;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr\Base;
use Sunshine\AdminBundle\Entity\Choice;
use Symfony\Component\Validator\Constraints as Assert;
use Sunshine\OrganizationBundle\Entity\BusinessUnit;
use Sunshine\OrganizationBundle\Entity\Organization;

/**
 * User
 *
 * @ORM\Table(name="sunshine_organization_user", options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 * @ORM\Entity(repositoryClass="Sunshine\OrganizationBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=25)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60, unique=true, nullable=true)
     */
    protected $email;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isActive;

    /**
     * 真实姓名
     * @var string
     *
     * @ORM\Column(name="real_name", type="string", length=50, nullable=true)
     * @Assert\Length(
     *     min = 2,
     *     max = 50,
     *     minMessage = "sunshine.user.real_name.length_min",
     *     maxMessage = "sunshine.user.real_name.length_max"
     * )
     */
    protected $realName;

    /**
     * Todo 为未来的多语言版本做准备
     * @var
     */
    protected $locale;

    /**
     * Todo 个人角色，如某部门管理员
     */
    protected $personalRoles;

    /**
     * 部门
     * @var BusinessUnit
     *
     * @ORM\ManyToOne(targetEntity="BusinessUnit", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(name="user_business_unit_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $businessUnit;

    /**
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="Sunshine\OrganizationBundle\Entity\Company", inversedBy="users")
     * @ORM\JoinColumn(name="user_company_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $company;

    /**
     * 员工编号
     * @var string
     *
     * @ORM\Column(name="employee_number", type="string", length=255, nullable=true)
     */
    protected $employeeNumber;

    /**
     * 排序号
     * @var int
     *
     * @ORM\Column(name="order_number", type="integer", options={"unsigned"=true}, nullable=true)
     */
    protected $orderNumber;

    /**
     * 主岗
     * @var Title
     *
     * @ORM\ManyToOne(targetEntity="Title", inversedBy="users", cascade="persist")
     * @ORM\JoinColumn(name="title", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $title;

    /**
     * 副岗
     * @var Second Title
     *
     * @ORM\ManyToOne(targetEntity="Title", inversedBy="secondTitleUsers", cascade="persist")
     * @ORM\JoinColumn(name="second_title", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $secondTitle;

    /**
     * 职务级别
     * @var ServiceGrade
     *
     * @ORM\ManyToOne(targetEntity="ServiceGrade", inversedBy="users", cascade="persist")
     * @ORM\JoinColumn(name="service_grade", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $serviceGrade;

    /**
     * 员工类型
     * @var Choice
     *
     * @ORM\OneToOne(targetEntity="Sunshine\AdminBundle\Entity\Choice")
     * @ORM\JoinColumn(name="type_choice_id", referencedColumnName="id", nullable=true)
     */
    protected $type;

    /**
     * Todo 头像
     * @var
     */
    protected $avatar;

    /**
     * 性别
     * @var Choice
     *
     * @ORM\OneToOne(targetEntity="Sunshine\AdminBundle\Entity\Choice")
     * @ORM\JoinColumn(name="gender_choice_id", referencedColumnName="id", nullable=true)
     */
    protected $gender;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Assert\Length(
     *     max = 30,
     *     maxMessage = "sunday.user.education.length_max"
     * )
     */
    protected $education;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     * @Assert\Date(
     *     message = "sunday.user.birthday.date"
     * )
     */
    protected $birthday;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Length(
     *     max = 50,
     *     maxMessage = "sunday.user.phone.length_max"
     * )
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=255, nullable=true)
     */
    protected $mobile;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, nullable=true)
     * @Assert\Length(
     *     min = 2,
     *     max = 255,
     *     minMessage = "sunday.string.length_min",
     *     maxMessage = "sunday.user.address.length_max"
     * )
     */
    protected $address;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Country(
     *     message = "sunday.user.citizenship.country"
     * )
     */
    protected $citizenship;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \Datetime $updateAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return __CLASS__;
    }

    /**
     * Pre persist event listener
     *
     * @ORM\PrePersist
     */
    public function beforeSave()
    {
        $this->createdAt = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * Pre update event listener
     *
     * @ORM\PreUpdate
     */
    public function beforeUpdate()
    {
        $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    public function __construct()
    {
        $this->isActive = true;
    }

    /**
    ┌─────────────────────────────────────────────────────────────────────┐
    │                                                                     │
    │                                                                     │░░
    │     _____                           _           _  ______           │░░
    │    |  __ \                         | |         | | | ___ \          │░░
    │    | |  \/ ___ _ __   ___ _ __ __ _| |_ ___  __| | | |_/ /_   _     │░░
    │    | | __ / _ \ '_ \ / _ \ '__/ _` | __/ _ \/ _` | | ___ \ | | |    │░░
    │    | |_\ \  __/ | | |  __/ | | (_| | ||  __/ (_| | | |_/ / |_| |    │░░
    │     \____/\___|_| |_|\___|_|  \__,_|\__\___|\__,_| \____/ \__, |    │░░
    │                                                            __/ |    │░░
    │                                                           |___/     │░░
    │               ______           _        _                           │░░
    │               |  _  \         | |      (_)                          │░░
    │               | | | |___   ___| |_ _ __ _ _ __   ___                │░░
    │               | | | / _ \ / __| __| '__| | '_ \ / _ \               │░░
    │               | |/ / (_) | (__| |_| |  | | | | |  __/               │░░
    │               |___/ \___/ \___|\__|_|  |_|_| |_|\___|               │░░
    │                                                                     │░░
    │                                                                     │░░
    └─────────────────────────────────────────────────────────────────────┘░░
    ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
    ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
     */

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
     * Set realName
     *
     * @param string $realName
     *
     * @return User
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;

        return $this;
    }

    /**
     * Get realName
     *
     * @return string
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * Set employeeNumber
     *
     * @param string $employeeNumber
     *
     * @return User
     */
    public function setEmployeeNumber($employeeNumber)
    {
        $this->employeeNumber = $employeeNumber;

        return $this;
    }

    /**
     * Get employeeNumber
     *
     * @return string
     */
    public function getEmployeeNumber()
    {
        return $this->employeeNumber;
    }

    /**
     * Set orderNumber
     *
     * @param integer $orderNumber
     *
     * @return User
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return integer
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set education
     *
     * @param string $education
     *
     * @return User
     */
    public function setEducation($education)
    {
        $this->education = $education;

        return $this;
    }

    /**
     * Get education
     *
     * @return string
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return User
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return User
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set citizenship
     *
     * @param string $citizenship
     *
     * @return User
     */
    public function setCitizenship($citizenship)
    {
        $this->citizenship = $citizenship;

        return $this;
    }

    /**
     * Get citizenship
     *
     * @return string
     */
    public function getCitizenship()
    {
        return $this->citizenship;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
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
     * @return User
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

    /**
     * Set businessUnit
     *
     * @param \Sunshine\OrganizationBundle\Entity\BusinessUnit $businessUnit
     *
     * @return User
     */
    public function setBusinessUnit(\Sunshine\OrganizationBundle\Entity\BusinessUnit $businessUnit = null)
    {
        $this->businessUnit = $businessUnit;

        return $this;
    }

    /**
     * Get businessUnit
     *
     * @return \Sunshine\OrganizationBundle\Entity\BusinessUnit
     */
    public function getBusinessUnit()
    {
        return $this->businessUnit;
    }

    /**
     * Set title
     *
     * @param \Sunshine\OrganizationBundle\Entity\Title $title
     *
     * @return User
     */
    public function setTitle(\Sunshine\OrganizationBundle\Entity\Title $title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return \Sunshine\OrganizationBundle\Entity\Title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set secondTitle
     *
     * @param \Sunshine\OrganizationBundle\Entity\Title $secondTitle
     *
     * @return User
     */
    public function setSecondTitle(\Sunshine\OrganizationBundle\Entity\Title $secondTitle = null)
    {
        $this->secondTitle = $secondTitle;

        return $this;
    }

    /**
     * Get secondTitle
     *
     * @return \Sunshine\OrganizationBundle\Entity\Title
     */
    public function getSecondTitle()
    {
        return $this->secondTitle;
    }

    /**
     * Set serviceGrade
     *
     * @param \Sunshine\OrganizationBundle\Entity\ServiceGrade $serviceGrade
     *
     * @return User
     */
    public function setServiceGrade(\Sunshine\OrganizationBundle\Entity\ServiceGrade $serviceGrade = null)
    {
        $this->serviceGrade = $serviceGrade;

        return $this;
    }

    /**
     * Get serviceGrade
     *
     * @return \Sunshine\OrganizationBundle\Entity\ServiceGrade
     */
    public function getServiceGrade()
    {
        return $this->serviceGrade;
    }

    /**
     * Set type
     *
     * @param \Sunshine\AdminBundle\Entity\Choice $type
     *
     * @return User
     */
    public function setType(\Sunshine\AdminBundle\Entity\Choice $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Sunshine\AdminBundle\Entity\Choice
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set gender
     *
     * @param \Sunshine\AdminBundle\Entity\Choice $gender
     *
     * @return User
     */
    public function setGender(\Sunshine\AdminBundle\Entity\Choice $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return \Sunshine\AdminBundle\Entity\Choice
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            ) = unserialize($serialized);
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set company
     *
     * @param \Sunshine\OrganizationBundle\Entity\Company $company
     *
     * @return User
     */
    public function setCompany(\Sunshine\OrganizationBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Sunshine\OrganizationBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }
}
