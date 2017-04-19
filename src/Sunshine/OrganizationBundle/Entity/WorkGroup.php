<?php

namespace Sunshine\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sunshine\AdminBundle\Entity\Choice;

/**
 * WorkGroup
 *
 * @ORM\Table(name="business_organization_work_group", options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 * @ORM\Entity(repositoryClass="Sunshine\OrganizationBundle\Repository\WorkGroupRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class WorkGroup
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
     * 组名称
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    protected $name;

    /**
     * 排序号
     * @var int
     *
     * @ORM\Column(name="order_num", type="integer", options={"unsigned"=true})
     */
    protected $orderNum;

    /**
     * 所属部门
     * @var BusinessUnit
     *
     * @ORM\ManyToOne(targetEntity="Sunshine\OrganizationBundle\Entity\BusinessUnit", inversedBy="groups")
     * @ORM\JoinColumn(name="group_business_unit_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $businessUnit;

    /**
     * 组主管
     * @var User
     *
     * @ORM\OneToOne(targetEntity="Sunshine\OrganizationBundle\Entity\User")
     * @ORM\JoinColumn(name="group_manager_id", referencedColumnName="id", nullable=true)
     */
    protected $groupManager;

    /**
     * 是否启动
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * 组类型
     * @var Choice
     *
     * @ORM\OneToOne(targetEntity="Sunshine\AdminBundle\Entity\Choice")
     * @ORM\JoinColumn(name="group_type_choice_id", referencedColumnName="id", nullable=true)
     */
    protected $type;

    /**
     * 权限属性
     * @var Choice
     *
     * @ORM\OneToOne(targetEntity="Sunshine\AdminBundle\Entity\Choice")
     * @ORM\JoinColumn(name="group_authority_choice_id", referencedColumnName="id", nullable=true)
     */
    protected $authority;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return WorkGroup
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
     * @return WorkGroup
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
     * Set name
     *
     * @param string $name
     *
     * @return WorkGroup
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
     * Set orderNum
     *
     * @param integer $orderNum
     *
     * @return WorkGroup
     */
    public function setOrderNum($orderNum)
    {
        $this->orderNum = $orderNum;

        return $this;
    }

    /**
     * Get orderNum
     *
     * @return integer
     */
    public function getOrderNum()
    {
        return $this->orderNum;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return WorkGroup
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set businessUnit
     *
     * @param \Sunshine\OrganizationBundle\Entity\BusinessUnit $businessUnit
     *
     * @return WorkGroup
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
     * Set groupManager
     *
     * @param \Sunshine\OrganizationBundle\Entity\User $groupManager
     *
     * @return WorkGroup
     */
    public function setGroupManager(\Sunshine\OrganizationBundle\Entity\User $groupManager = null)
    {
        $this->groupManager = $groupManager;

        return $this;
    }

    /**
     * Get groupManager
     *
     * @return \Sunshine\OrganizationBundle\Entity\User
     */
    public function getGroupManager()
    {
        return $this->groupManager;
    }

    /**
     * Set type
     *
     * @param \Sunshine\AdminBundle\Entity\Choice $type
     *
     * @return WorkGroup
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
     * Set authority
     *
     * @param \Sunshine\AdminBundle\Entity\Choice $authority
     *
     * @return WorkGroup
     */
    public function setAuthority(\Sunshine\AdminBundle\Entity\Choice $authority = null)
    {
        $this->authority = $authority;

        return $this;
    }

    /**
     * Get authority
     *
     * @return \Sunshine\AdminBundle\Entity\Choice
     */
    public function getAuthority()
    {
        return $this->authority;
    }
}
