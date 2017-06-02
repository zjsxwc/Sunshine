<?php

namespace Sunshine\UIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Block
 *
 * @ORM\Table(name="block")
 * @ORM\Entity(repositoryClass="Sunshine\UIBundle\Repository\BlockRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Block
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var Twig
     *
     * @ORM\ManyToOne(targetEntity="Sunshine\UIBundle\Entity\Twig", inversedBy="block")
     * @ORM\JoinColumn(name="twig_id", referencedColumnName="id")
     */
    protected $twig;

    /**
     * @var bool
     *
     * @ORM\Column(name="spf_state", type="boolean")
     */
    protected $spfState;

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
     * @return Block
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
     * Set spfState
     *
     * @param boolean $spfState
     *
     * @return Block
     */
    public function setSpfState($spfState)
    {
        $this->spfState = $spfState;

        return $this;
    }

    /**
     * Get spfState
     *
     * @return boolean
     */
    public function getSpfState()
    {
        return $this->spfState;
    }

    /**
     * Set twig
     *
     * @param \Sunshine\UIBundle\Entity\Twig $twig
     *
     * @return Block
     */
    public function setTwig(\Sunshine\UIBundle\Entity\Twig $twig = null)
    {
        $this->twig = $twig;

        return $this;
    }

    /**
     * Get twig
     *
     * @return \Sunshine\UIBundle\Entity\Twig
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Block
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
     * @return Block
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
}
