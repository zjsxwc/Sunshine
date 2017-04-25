<?php

namespace Sunshine\OrganizationBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OrganizationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'sunshine.organization.form.org.name'])
            ->add('foreignName', TextType::class, ['label' => 'sunshine.organization.form.org.foreignName'])
            ->add('alias', TextType::class, ['label' => 'sunshine.organization.form.org.alias'])
            ->add('admin', EntityType::class,
                [
                    'class' => 'SunshineAdminBundle:Admin',
                    'label' => 'sunshine.organization.form.org.admin'
                ])
            ->add('type', EntityType::class,
                [
                    'class' => 'SunshineAdminBundle:Options',
                    'label' => 'sunshine.organization.form.org.type',
                    'choice_label' => 'displayName',
                    'placeholder' => 'sunshine.organization.form.org.chooseOne',
                    'query_builder' => function (EntityRepository $repository) {
                        return $repository->createQueryBuilder('op')
                            ->select('op')
                            ->innerJoin('SunshineAdminBundle:Choice', 'c')
                            ->andWhere('c.name = :name')
                            ->setParameter('name', '组织类型')
                            ->andWhere('op.source = c');
                    }
                ])
            ->add('legalPerson', TextType::class, ['label' => 'sunshine.organization.form.org.legalPerson'])
            ->add('address', TextType::class, ['label' => 'sunshine.organization.form.org.address'])
            ->add('zipCode', TextType::class, ['label' => 'sunshine.organization.form.org.zipCode'])
            ->add('phone', TextType::class, ['label' => 'sunshine.organization.form.org.phone'])
            ->add('fax', TextType::class, ['label' => 'sunshine.organization.form.org.fax'])
            ->add('website', TextType::class, ['label' => 'sunshine.organization.form.org.website'])
            ->add('mail', TextType::class, ['label' => 'sunshine.organization.form.org.mail'])
            ->add('officeAddress', TextType::class, ['label' => 'sunshine.organization.form.org.officeAddress'])
            ->add('description', TextareaType::class, ['label' => 'sunshine.organization.form.org.description']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunshine\OrganizationBundle\Entity\Organization'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sunshine_organizationbundle_organization';
    }
}
