<?php

namespace Sunshine\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sunshine\AdminBundle\Entity\Choice;

/**
 * Company
 *
 * @ORM\Table(name="sunshine_organization_company", options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 * @ORM\Entity(repositoryClass="Sunshine\OrganizationBundle\Repository\CompanyRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Company
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
     * 公司名称
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * 外文名称
     * @var string
     *
     * @ORM\Column(name="foreign_name", type="string", length=255)
     */
    protected $foreignName;

    /**
     * 公司简称
     * @var string
     *
     * @ORM\Column(name="alias_name", type="string", length=20)
     */
    protected $alias;

    /**
     * 公司类型
     * @var Choice
     *
     * @ORM\OneToOne(targetEntity="Sunshine\AdminBundle\Entity\Choice")
     * @ORM\JoinColumn(name="organization_type_choice_id", referencedColumnName="id", nullable=true)
     */
    protected $type;

    /**
     * 法人
     * @var string
     *
     * @ORM\Column(name="legal_person", type="string", length=50)
     */
    protected $legalPerson;

    /**
     * 地址
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    protected $address;

    /**
     * 邮政编码
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=20)
     */
    protected $zipCode;

    /**
     * 电话
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=30)
     */
    protected $phone;

    /**
     * 传真
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=30)
     */
    protected $fax;

    /**
     * 网站
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=60)
     */
    protected $website;

    /**
     * 邮箱
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    protected $mail;

    /**
     * 办公地址
     * @var string
     *
     * @ORM\Column(name="office_address", type="string", length=255)
     */
    protected $officeAddress;

    /**
     * 描述
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
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
}

