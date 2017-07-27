<?php

namespace Sunshine\OrganizationBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Sunshine\OrganizationBundle\Entity\BusinessUnit;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\Session\Session;

class NameToBusinessUnitTransformer implements DataTransformerInterface
{
    protected $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * 将 BusinessUnit 对象转换成为部门名称
     *
     * @param BusinessUnit $bu
     * @return string
     */
    public function transform($bu)
    {
        if (null === $bu) {
            return '';
        }

        return $bu->getName();
    }

    /**
     * 将部门名称转换成为 BusinessUnit 对象
     *
     * @param mixed $buName
     * @return BusinessUnit|null
     */
    public function reverseTransform($buName)
    {
        $session =  new Session;

        if (!$buName) {
            return;
        }

        $bu = $this->manager
            ->getRepository('SunshineOrganizationBundle:BusinessUnit')
            ->findByCompanyAndBUName($session->get('company'), $buName);

        if (null === $bu) {
            throw new TransformationFailedException(sprintf(
               'An business unit with name "%s" does not exist!',
               $buName
            ));
        }

        return $bu;
    }
}