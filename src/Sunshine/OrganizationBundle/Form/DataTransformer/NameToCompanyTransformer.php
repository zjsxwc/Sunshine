<?php

namespace Sunshine\OrganizationBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Sunshine\OrganizationBundle\Entity\Company;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class NameToCompanyTransformer implements DataTransformerInterface
{
    protected $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * 将公司名称转换成为 Company 对象
     *
     * @param mixed $companyName
     * @return Company|null
     */
    public function reverseTransform($companyName)
    {
        if (!$companyName) {
            return;
        }

        $company = $this->manager
            ->getRepository('SunshineOrganizationBundle:Company')
            ->findOneBy(['name' => $companyName]);

        if (null === $company) {
            throw new TransformationFailedException(sprintf(
                'An company with name "%s" does not exist!',
                $companyName
            ));
        }

        return $company;
    }

    /**
     * 将 Company 对象转换成为公司名称
     *
     * @param Company $company
     * @return mixed|string
     */
    public function transform($company)
    {
        if (null === $company) {
            return '';
        }

        return $company->getName();
    }
}