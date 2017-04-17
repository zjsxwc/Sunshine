<?php

namespace Sunshine\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceGrade
 *
 * @ORM\Table(name="service_grade")
 * @ORM\Entity(repositoryClass="Sunshine\OrganizationBundle\Repository\ServiceGradeRepository")
 */
class ServiceGrade
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

