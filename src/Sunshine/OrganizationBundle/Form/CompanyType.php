<?php

namespace Sunshine\OrganizationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Translation\TranslatorInterface;

class CompanyType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;
    protected $translation;

    /**
     * {@inheritdoc}
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->translation = $this->translator->trans('sunshine.organization.form.org.type');

        $builder
            ->add('name', TextType::class, ['label' => 'sunshine.organization.form.company.name'])
            ->add('foreignName', TextType::class, ['label' => 'sunshine.organization.form.org.foreignName'])
            ->add('alias', TextType::class, ['label' => 'sunshine.organization.form.company.alias'])
            ->add('legalPerson', TextType::class, ['label' => 'sunshine.organization.form.org.legalPerson'])
            ->add('address', TextType::class, ['label' => 'sunshine.organization.form.org.address'])
            ->add('zipCode', TextType::class, ['label' => 'sunshine.organization.form.org.zipCode'])
            ->add('phone', TextType::class, ['label' => 'sunshine.organization.form.org.phone'])
            ->add('fax', TextType::class, ['label' => 'sunshine.organization.form.org.fax'])
            ->add('website', TextType::class, ['label' => 'sunshine.organization.form.org.website'])
            ->add('mail', TextType::class, ['label' => 'sunshine.organization.form.org.mail'])
            ->add('officeAddress', TextType::class, ['label' => 'sunshine.organization.form.org.officeAddress'])
            ->add('description', TextareaType::class, ['label' => 'sunshine.organization.form.org.description'])
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
                            ->setParameter('name', $this->translation)
                            ->andWhere('op.source = c');
                    }
                ])
            ->add('organization', EntityType::class,
                [
                    'class' => 'SunshineOrganizationBundle:Organization',
                    'label' => 'sunshine.organization.form.company.owner'
                ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sunshine\OrganizationBundle\Entity\Company'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sunshine_organizationbundle_company';
    }
}
