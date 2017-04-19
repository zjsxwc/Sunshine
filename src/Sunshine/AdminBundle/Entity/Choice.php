<?php

namespace Sunshine\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Choice
 *
 * @ORM\Table(name="business_admin_choice")
 * @ORM\Entity(repositoryClass="Sunshine\AdminBundle\Repository\ChoiceRepository")
 */
class Choice
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    protected $name;

    /**
     * @var Options[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Sunshine\AdminBundle\Entity\Options", mappedBy="source")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $options;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

