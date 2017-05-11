<?php

namespace Sunshine\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Tree\Node as GedmoNode;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * BusinessUnit
 *
 * @ORM\Table(name="sunshine_organization_business_unit",
 *     options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"},
 *     indexes={
 *         @ORM\Index(name="idx_business_unit_name", columns={"name"}),
 *         @ORM\Index(name="idx_business_unit_enabled", columns={"enabled"})
 *     })
 * @ORM\Entity(repositoryClass="Sunshine\OrganizationBundle\Repository\BusinessUnitRepository")
 * @UniqueEntity(
 *     fields={"company", "name"},
 *     errorPath="name",
 *     message="sunshine.organization.form.bu.nameExist"
 * )
 * @Gedmo\Tree(type="nested")
 * @ORM\HasLifecycleCallbacks()
 */
class BusinessUnit implements GedmoNode
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
     * 部门名称
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * 部门代码
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=10, nullable=true)
     */
    protected $code;

    /**
     * 排序号
     * @var int
     *
     * @ORM\Column(name="order_number", type="integer", options={"unsigned"=true})
     */
    protected $orderNumber;

    /**
     * 开启状态
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * 是否创建部门空间
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $createSpace;

    /**
     * 部门主管
     * @var User
     *
     * @ORM\OneToOne(targetEntity="Sunshine\OrganizationBundle\Entity\User")
     * @ORM\JoinColumn(name="bu_manager_user_id", referencedColumnName="id", nullable=true)
     */
    protected $manager;

    /**
     * 部门分管领导
     * @var User
     *
     * @ORM\OneToOne(targetEntity="Sunshine\OrganizationBundle\Entity\User")
     * @ORM\JoinColumn(name="pre_manager", referencedColumnName="id", nullable=true)
     */
    protected $preManager;

    /**
     * 部门管理员
     * @var User
     *
     * @ORM\OneToOne(targetEntity="Sunshine\OrganizationBundle\Entity\User")
     * @ORM\JoinColumn(name="bu_admin", referencedColumnName="id", nullable=true)
     */
    protected $businessUnitAdmin;

    /**
     * 部门公文收发员
     * @var User
     *
     * @ORM\OneToOne(targetEntity="Sunshine\OrganizationBundle\Entity\User")
     * @ORM\JoinColumn(name="document_receiver", referencedColumnName="id", nullable=true)
     */
    protected $documentReceiver;

    /**
     * Todo 部门岗位
     * @var $title
     */
    protected $title;

    /**
     * 部门描述
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var User[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="businessUnit")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $users;

    /**
     * @var WorkGroup[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Sunshine\OrganizationBundle\Entity\WorkGroup", mappedBy="businessUnit")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $groups;

    /**
     * 部门所属公司
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="Sunshine\OrganizationBundle\Entity\Company", inversedBy="businessUnit")
     * @ORM\JoinColumn(name="", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    protected $company;

    /**
     * 上级部门
     * @var BusinessUnit
     *
     * @ORM\ManyToOne(targetEntity="BusinessUnit", inversedBy="children", fetch="LAZY")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     * @Gedmo\TreeParent
     */
    protected $parent;

    /**
     * 下级部门
     * @var BusinessUnit[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BusinessUnit", mappedBy="parent", fetch="LAZY")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $children;

    /**
     * 根部门
     * @var BusinessUnit
     *
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="BusinessUnit")
     * @ORM\JoinColumn(name="root", referencedColumnName="id", nullable=true)
     */
    protected $root;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\TreeLeft
     */
    protected $lft;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\TreeLevel
     */
    protected $lvl;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\TreeRight
     */
    protected $rgt;

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
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

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

    /**
     * Set name
     *
     * @param string $name
     *
     * @return BusinessUnit
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
     * Set code
     *
     * @param string $code
     *
     * @return BusinessUnit
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
     * @return BusinessUnit
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
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return BusinessUnit
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
     * Set createSpace
     *
     * @param boolean $createSpace
     *
     * @return BusinessUnit
     */
    public function setCreateSpace($createSpace)
    {
        $this->createSpace = $createSpace;

        return $this;
    }

    /**
     * Get createSpace
     *
     * @return boolean
     */
    public function getCreateSpace()
    {
        return $this->createSpace;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return BusinessUnit
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
     * Set lft
     *
     * @param integer $lft
     *
     * @return BusinessUnit
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     *
     * @return BusinessUnit
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     *
     * @return BusinessUnit
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return BusinessUnit
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
     * @return BusinessUnit
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
     * Set manager
     *
     * @param \Sunshine\OrganizationBundle\Entity\User $manager
     *
     * @return BusinessUnit
     */
    public function setManager(\Sunshine\OrganizationBundle\Entity\User $manager = null)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Get manager
     *
     * @return \Sunshine\OrganizationBundle\Entity\User
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Set preManager
     *
     * @param \Sunshine\OrganizationBundle\Entity\User $preManager
     *
     * @return BusinessUnit
     */
    public function setPreManager(\Sunshine\OrganizationBundle\Entity\User $preManager = null)
    {
        $this->preManager = $preManager;

        return $this;
    }

    /**
     * Get preManager
     *
     * @return \Sunshine\OrganizationBundle\Entity\User
     */
    public function getPreManager()
    {
        return $this->preManager;
    }

    /**
     * Set businessUnitAdmin
     *
     * @param \Sunshine\OrganizationBundle\Entity\User $businessUnitAdmin
     *
     * @return BusinessUnit
     */
    public function setBusinessUnitAdmin(\Sunshine\OrganizationBundle\Entity\User $businessUnitAdmin = null)
    {
        $this->businessUnitAdmin = $businessUnitAdmin;

        return $this;
    }

    /**
     * Get businessUnitAdmin
     *
     * @return \Sunshine\OrganizationBundle\Entity\User
     */
    public function getBusinessUnitAdmin()
    {
        return $this->businessUnitAdmin;
    }

    /**
     * Set documentReceiver
     *
     * @param \Sunshine\OrganizationBundle\Entity\User $documentReceiver
     *
     * @return BusinessUnit
     */
    public function setDocumentReceiver(\Sunshine\OrganizationBundle\Entity\User $documentReceiver = null)
    {
        $this->documentReceiver = $documentReceiver;

        return $this;
    }

    /**
     * Get documentReceiver
     *
     * @return \Sunshine\OrganizationBundle\Entity\User
     */
    public function getDocumentReceiver()
    {
        return $this->documentReceiver;
    }

    /**
     * Set company
     *
     * @param \Sunshine\OrganizationBundle\Entity\Company $company
     *
     * @return BusinessUnit
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

    /**
     * Set parent
     *
     * @param \Sunshine\OrganizationBundle\Entity\BusinessUnit $parent
     *
     * @return BusinessUnit
     */
    public function setParent(\Sunshine\OrganizationBundle\Entity\BusinessUnit $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Sunshine\OrganizationBundle\Entity\BusinessUnit
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \Sunshine\OrganizationBundle\Entity\BusinessUnit $child
     *
     * @return BusinessUnit
     */
    public function addChild(\Sunshine\OrganizationBundle\Entity\BusinessUnit $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Sunshine\OrganizationBundle\Entity\BusinessUnit $child
     */
    public function removeChild(\Sunshine\OrganizationBundle\Entity\BusinessUnit $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set root
     *
     * @param \Sunshine\OrganizationBundle\Entity\BusinessUnit $root
     *
     * @return BusinessUnit
     */
    public function setRoot(\Sunshine\OrganizationBundle\Entity\BusinessUnit $root = null)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return \Sunshine\OrganizationBundle\Entity\BusinessUnit
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Add user
     *
     * @param \Sunshine\OrganizationBundle\Entity\User $user
     *
     * @return BusinessUnit
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
     * Add group
     *
     * @param \Sunshine\OrganizationBundle\Entity\WorkGroup $group
     *
     * @return BusinessUnit
     */
    public function addGroup(\Sunshine\OrganizationBundle\Entity\WorkGroup $group)
    {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * Remove group
     *
     * @param \Sunshine\OrganizationBundle\Entity\WorkGroup $group
     */
    public function removeGroup(\Sunshine\OrganizationBundle\Entity\WorkGroup $group)
    {
        $this->groups->removeElement($group);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
