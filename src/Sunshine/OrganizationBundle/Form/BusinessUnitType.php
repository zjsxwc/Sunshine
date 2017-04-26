<?php

namespace Sunshine\OrganizationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusinessUnitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')->add('code')->add('orderNumber')->add('enabled')->add('createSpace')->add('description')->add('lft')->add('lvl')->add('rgt')->add('createdAt')->add('updatedAt')->add('manager')->add('preManager')->add('businessUnitAdmin')->add('documentReceiver')->add('company')->add('parent')->add('root');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunshine\OrganizationBundle\Entity\BusinessUnit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sunshine_organizationbundle_businessunit';
    }


}
