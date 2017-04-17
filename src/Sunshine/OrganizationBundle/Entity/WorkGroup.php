<?php

namespace Sunshine\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkGroup
 *
 * @ORM\Table(name="work_group")
 * @ORM\Entity(repositoryClass="Sunshine\OrganizationBundle\Repository\WorkGroupRepository")
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

