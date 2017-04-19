<?php

namespace Sunshine\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Options
 *
 * @ORM\Table(name="business_admin_options")
 * @ORM\Entity(repositoryClass="Sunshine\AdminBundle\Repository\OptionsRepository")
 */
class Options
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

    protected $value;

    /**
     * @var Choice
     *
     * @ORM\ManyToOne(targetEntity="Sunshine\AdminBundle\Entity\Choice", inversedBy="options")
     * @ORM\JoinColumn(name="choice_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $source;

    protected $orderNumber;

    protected $enabled;

    protected $enabledSearch;

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

