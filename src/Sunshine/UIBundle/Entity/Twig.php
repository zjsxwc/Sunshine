<?php

namespace Sunshine\UIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Twig
 *
 * @ORM\Table(name="twig")
 * @ORM\Entity(repositoryClass="Sunshine\UIBundle\Repository\TwigRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Twig
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
     * @var Bundle
     *
     * @ORM\ManyToOne(targetEntity="Sunshine\UIBundle\Entity\Bundle", inversedBy="twig")
     * @ORM\JoinColumn(name="", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $bundle;

    /**
     * @var string
     *
     * @ORM\Column(name="file_real_path", type="string", length=255)
     */
    protected $fileRealPath;

    /**
     * @var Block[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Sunshine\UIBundle\Entity\Block", mappedBy="twig")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $block;

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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $spfHead;

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
     * Constructor
     */
    public function __construct()
    {
        $this->block = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Twig
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
     * Set fileRealPath
     *
     * @param string $fileRealPath
     *
     * @return Twig
     */
    public function setFileRealPath($fileRealPath)
    {
        $this->fileRealPath = $fileRealPath;

        return $this;
    }

    /**
     * Get fileRealPath
     *
     * @return string
     */
    public function getFileRealPath()
    {
        return $this->fileRealPath;
    }

    /**
     * Set bundle
     *
     * @param \Sunshine\UIBundle\Entity\Bundle $bundle
     *
     * @return Twig
     */
    public function setBundle(\Sunshine\UIBundle\Entity\Bundle $bundle = null)
    {
        $this->bundle = $bundle;

        return $this;
    }

    /**
     * Get bundle
     *
     * @return \Sunshine\UIBundle\Entity\Bundle
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * Add block
     *
     * @param \Sunshine\UIBundle\Entity\Block $block
     *
     * @return Twig
     */
    public function addBlock(\Sunshine\UIBundle\Entity\Block $block)
    {
        $this->block[] = $block;

        return $this;
    }

    /**
     * Remove block
     *
     * @param \Sunshine\UIBundle\Entity\Block $block
     */
    public function removeBlock(\Sunshine\UIBundle\Entity\Block $block)
    {
        $this->block->removeElement($block);
    }

    /**
     * Get block
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Twig
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
     * @return Twig
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
     * Set title
     *
     * @param string $title
     *
     * @return Twig
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set spfHead
     *
     * @param boolean $spfHead
     *
     * @return Twig
     */
    public function setSpfHead($spfHead)
    {
        $this->spfHead = $spfHead;

        return $this;
    }

    /**
     * Get spfHead
     *
     * @return boolean
     */
    public function getSpfHead()
    {
        return $this->spfHead;
    }
}
