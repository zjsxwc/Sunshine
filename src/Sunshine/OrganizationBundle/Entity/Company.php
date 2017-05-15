<?php

namespace Sunshine\OrganizationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sunshine\AdminBundle\Entity\Choice;
use Sunshine\AdminBundle\Entity\Options;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Company
 *
 * @ORM\Table(name="sunshine_organization_company", options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 * @ORM\Entity(repositoryClass="Sunshine\OrganizationBundle\Repository\CompanyRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Company
{

    /**
     * 挂载软删除能力
     * 增加 deletedAt 字段
     */
    use SoftDeleteableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * 公司名称
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * 公司代码
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=10, nullable=true)
     */
    protected $code;

    /**
     * 排序号
     * @var int
     *
     * @ORM\Column(name="order_number", type="integer", options={"unsigned"=true}, nullable=true)
     */
    protected $orderNumber;

    /**
     * 外文名称
     * @var string
     *
     * @ORM\Column(name="foreign_name", type="string", length=255, nullable=true)
     */
    protected $foreignName;

    /**
     * 公司简称
     * @var string
     *
     * @ORM\Column(name="alias_name", type="string", length=20, nullable=true)
     */
    protected $alias;

    /**
     * 公司类型
     * @var Options
     *
     * @ORM\OneToOne(targetEntity="Sunshine\AdminBundle\Entity\Options")
     * @ORM\JoinColumn(name="organization_type_options_id", referencedColumnName="id", nullable=true)
     */
    protected $type;

    /**
     * 法人
     * @var string
     *
     * @ORM\Column(name="legal_person", type="string", length=50, nullable=true)
     */
    protected $legalPerson;

    /**
     * 地址
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    protected $address;

    /**
     * 邮政编码
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=20, nullable=true)
     */
    protected $zipCode;

    /**
     * 电话
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=30, nullable=true)
     */
    protected $phone;

    /**
     * 传真
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=30, nullable=true)
     */
    protected $fax;

    /**
     * 网站
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=60, nullable=true)
     */
    protected $website;

    /**
     * 邮箱
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=true)
     */
    protected $mail;

    /**
     * 办公地址
     * @var string
     *
     * @ORM\Column(name="office_address", type="string", length=255, nullable=true)
     */
    protected $officeAddress;

    /**
     * 描述
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true, nullable=true)
     */
    protected $description;

    /**
     * @var Organization
     *
     * @ORM\ManyToOne(targetEntity="Sunshine\OrganizationBundle\Entity\Organization", inversedBy="company")
     * @ORM\JoinColumn(name="", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $organization;

    /**
     * @var BusinessUnit[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Sunshine\OrganizationBundle\Entity\BusinessUnit", mappedBy="company")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $businessUnit;

    /**
     * @var User[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Sunshine\OrganizationBundle\Entity\User", mappedBy="company", fetch="LAZY")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $users;

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

    public function __toString()
    {
        return (string) $this->getName();
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
     * Constructor
     */
    public function __construct()
    {
        $this->businessUnit = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Company
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
     * Set foreignName
     *
     * @param string $foreignName
     *
     * @return Company
     */
    public function setForeignName($foreignName)
    {
        $this->foreignName = $foreignName;

        return $this;
    }

    /**
     * Get foreignName
     *
     * @return string
     */
    public function getForeignName()
    {
        return $this->foreignName;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return Company
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set legalPerson
     *
     * @param string $legalPerson
     *
     * @return Company
     */
    public function setLegalPerson($legalPerson)
    {
        $this->legalPerson = $legalPerson;

        return $this;
    }

    /**
     * Get legalPerson
     *
     * @return string
     */
    public function getLegalPerson()
    {
        return $this->legalPerson;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Company
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
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return Company
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Company
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
     * Set fax
     *
     * @param string $fax
     *
     * @return Company
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Company
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Company
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set officeAddress
     *
     * @param string $officeAddress
     *
     * @return Company
     */
    public function setOfficeAddress($officeAddress)
    {
        $this->officeAddress = $officeAddress;

        return $this;
    }

    /**
     * Get officeAddress
     *
     * @return string
     */
    public function getOfficeAddress()
    {
        return $this->officeAddress;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Company
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Company
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
     * @return Company
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
     * Set type
     *
     * @param \Sunshine\AdminBundle\Entity\Options $type
     *
     * @return Company
     */
    public function setType(\Sunshine\AdminBundle\Entity\Options $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Sunshine\AdminBundle\Entity\Options
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set organization
     *
     * @param \Sunshine\OrganizationBundle\Entity\Organization $organization
     *
     * @return Company
     */
    public function setOrganization(\Sunshine\OrganizationBundle\Entity\Organization $organization = null)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization
     *
     * @return \Sunshine\OrganizationBundle\Entity\Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Add businessUnit
     *
     * @param \Sunshine\OrganizationBundle\Entity\BusinessUnit $businessUnit
     *
     * @return Company
     */
    public function addBusinessUnit(\Sunshine\OrganizationBundle\Entity\BusinessUnit $businessUnit)
    {
        $this->businessUnit[] = $businessUnit;

        return $this;
    }

    /**
     * Remove businessUnit
     *
     * @param \Sunshine\OrganizationBundle\Entity\BusinessUnit $businessUnit
     */
    public function removeBusinessUnit(\Sunshine\OrganizationBundle\Entity\BusinessUnit $businessUnit)
    {
        $this->businessUnit->removeElement($businessUnit);
    }

    /**
     * Get businessUnit
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBusinessUnit()
    {
        return $this->businessUnit;
    }

    /**
     * Add user
     *
     * @param \Sunshine\OrganizationBundle\Entity\User $user
     *
     * @return Company
     */
    public function addUser(\Sunshine\OrganizationBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Sunshine\OrganizationBundle\Entity\User $user
     */
    public function removeUser(\Sunshine\OrganizationBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Company
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set orderNumber
     *
     * @param integer $orderNumber
     *
     * @return Company
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
}
