<?php

namespace Sunshine\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr\Base;
use Sunshine\AdminBundle\Entity\Choice;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
use Sunshine\OrganizationBundle\Entity\BusinessUnit;
use Sunshine\OrganizationBundle\Entity\Organization;

/**
 * User
 *
 * @ORM\Table(name="sunshine_user", options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 * @ORM\Entity(repositoryClass="Sunshine\OrganizationBundle\Repository\UserRepository")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(type="string", name="email", length=255, unique=false, nullable=true)),
 *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(type="string", name="email_canonical", length=255, unique=false, nullable=true))
 * })
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
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
     * 员工编号
     * @var string
     *
     * @ORM\Column(name="employee_number", type="string", length=255)
     */
    protected $employeeNumber;

    /**
     * 排序号
     * @var int
     *
     * @ORM\Column(name="order_number", type="integer", options={"unsigned"=true})
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
     * @ORM\ManyToOne(targetEntity="Title", inversedBy="users", cascade="persist")
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
     * @ORM\Column(name="mobile", type="string", length=255)
     */
    protected $mobile;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
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

