<?php

namespace Sunshine\UIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Bundle
 *
 * @ORM\Table(name="sunshine_ui_bundle")
 * @ORM\Entity(repositoryClass="Sunshine\UIBundle\Repository\BundleRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Bundle
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
     * @var string
     *
     * @ORM\Column(name="bundle_real_path", type="string", length=255)
     */
    protected $bundleRealPath;

    /**
     * @var int
     *
     * @ORM\Column(name="twig_amount", type="integer", options={"unsigned"=true})
     */
    protected $twigAmount;

    /**
     * @var Twig[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Sunshine\UIBundle\Entity\Twig", mappedBy="bundle")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $twig;

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
     * Constructor
     */
    public function __construct()
    {
        $this->twig = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Bundle
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
     * Set bundleRealPath
     *
     * @param string $bundleRealPath
     *
     * @return Bundle
     */
    public function setBundleRealPath($bundleRealPath)
    {
        $this->bundleRealPath = $bundleRealPath;

        return $this;
    }

    /**
     * Get bundleRealPath
     *
     * @return string
     */
    public function getBundleRealPath()
    {
        return $this->bundleRealPath;
    }

    /**
     * Set twigAmount
     *
     * @param integer $twigAmount
     *
     * @return Bundle
     */
    public function setTwigAmount($twigAmount)
    {
        $this->twigAmount = $twigAmount;

        return $this;
    }

    /**
     * Get twigAmount
     *
     * @return integer
     */
    public function getTwigAmount()
    {
        return $this->twigAmount;
    }

    /**
     * Add twig
     *
     * @param \Sunshine\UIBundle\Entity\Twig $twig
     *
     * @return Bundle
     */
    public function addTwig(\Sunshine\UIBundle\Entity\Twig $twig)
    {
        $this->twig[] = $twig;

        return $this;
    }

    /**
     * Remove twig
     *
     * @param \Sunshine\UIBundle\Entity\Twig $twig
     */
    public function removeTwig(\Sunshine\UIBundle\Entity\Twig $twig)
    {
        $this->twig->removeElement($twig);
    }

    /**
     * Get twig
     *
     * @return \Doctrine\Common\Collections\Collection
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
     * @return Bundle
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
     * @return Bundle
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
