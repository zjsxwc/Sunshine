<?php

namespace Sunshine\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sunshine\AdminBundle\Entity\Choice;

/**
 * Title
 *
 * @ORM\Table(name="business_organization_title", options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 * @ORM\Entity(repositoryClass="Sunshine\OrganizationBundle\Repository\TitleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Title
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
     * 岗位名称
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    protected $name;

    /**
     * 岗位代码
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=20)
     */
    protected $code;

    /**
     * 岗位类型
     * @var Choice
     *
     * @ORM\OneToOne(targetEntity="Sunshine\AdminBundle\Entity\Choice")
     * @ORM\JoinColumn(name="title_type_choice_id", referencedColumnName="id", nullable=true)
     */
    protected $type;

    /**
     * 排序序号
     * @var int
     *
     * @ORM\Column(name="order_number", type="integer", options={"unsigned"=true})
     */
    protected $orderNumber;

    /**
     * 是否开启
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * 备注，描述
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * 此岗位用户
     * @var User[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Sunshine\OrganizationBundle\Entity\User", mappedBy="title", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $users;

    /**
     * 第二岗位为此岗位的用户
     * @var User[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Sunshine\OrganizationBundle\Entity\User", mappedBy="secondTitle", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $secondTitleUsers;

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
     * @return Title
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
     * @return Title
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
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->secondTitleUsers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Title
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
     * @return Title
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
     * @return Title
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
     * @return Title
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
     * Set description
     *
     * @param string $description
     *
     * @return Title
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
     * Set type
     *
     * @param \Sunshine\AdminBundle\Entity\Choice $type
     *
     * @return Title
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
     * Add user
     *
     * @param \Sunshine\OrganizationBundle\Entity\User $user
     *
     * @return Title
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
     * Add secondTitleUser
     *
     * @param \Sunshine\OrganizationBundle\Entity\User $secondTitleUser
     *
     * @return Title
     */
    public function addSecondTitleUser(\Sunshine\OrganizationBundle\Entity\User $secondTitleUser)
    {
        $this->secondTitleUsers[] = $secondTitleUser;

        return $this;
    }

    /**
     * Remove secondTitleUser
     *
     * @param \Sunshine\OrganizationBundle\Entity\User $secondTitleUser
     */
    public function removeSecondTitleUser(\Sunshine\OrganizationBundle\Entity\User $secondTitleUser)
    {
        $this->secondTitleUsers->removeElement($secondTitleUser);
    }

    /**
     * Get secondTitleUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSecondTitleUsers()
    {
        return $this->secondTitleUsers;
    }
}
