<?php

namespace Sunshine\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrganizationRole
 *
 * @ORM\Table(name="organization_role")
 * @ORM\Entity(repositoryClass="Sunshine\OrganizationBundle\Repository\OrganizationRoleRepository")
 */
class OrganizationRole
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

