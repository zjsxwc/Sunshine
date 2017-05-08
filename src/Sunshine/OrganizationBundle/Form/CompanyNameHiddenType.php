<?php

namespace Sunshine\OrganizationBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Sunshine\OrganizationBundle\Form\DataTransformer\NameToCompanyTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class CompanyNameHiddenType extends AbstractType
{
    protected $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new NameToCompanyTransformer($this->manager);
        $builder->addViewTransformer($transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'sunshine.organization.form.bu.invalidCompany'
        ]);
    }

    public function getParent()
    {
        return HiddenType::class;
    }
}