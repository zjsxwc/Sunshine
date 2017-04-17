<?php

namespace Sunshine\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BusinessUnit
 *
 * @ORM\Table(name="business_unit")
 * @ORM\Entity(repositoryClass="Sunshine\OrganizationBundle\Repository\BusinessUnitRepository")
 */
class BusinessUnit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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

