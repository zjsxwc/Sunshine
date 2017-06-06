<?php

namespace Sunshine\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Sunshine\UIBundle\Entity\Bundle;
use Sunshine\UIBundle\Entity\Twig;
use Sunshine\UIBundle\Entity\Block;

/**
 * Traverse the bundles to import all templates information to the database.
 *
 * Class SunshineImportTemplatesCommand
 * @package Sunshine\AdminBundle\Command
 */
class SunshineImportTemplatesCommand extends ContainerAwareCommand
{
    protected $em;

    protected function configure()
    {
        $this
            ->setName('sunshine:import-templates')
            ->setDescription('Import templates in the specific bundles to the database.')
            //->addArgument('bundle-scope', InputArgument::OPTIONAL, 'All Bundle or Specific Bundle')
            ->addOption('bundle-name-contains', null, InputOption::VALUE_REQUIRED, 'What the name at very begin of the bundle name')
            ->addOption('bundle-name', null, InputOption::VALUE_REQUIRED, 'What the bundle name you want to import')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$argument = $input->getArgument('argument');
        $bundles = $this->getApplication()->getKernel()->getBundles();
        $this->em = $this->getContainer()->get('doctrine')->getManager();

        if ($input->getOption('bundle-name-contains')) {
            $bundleNameBegin = $input->getOption('bundle-name-contains');
            foreach (array_keys($bundles) as &$value) {
                if (0 === strpos($value, $bundleNameBegin)) {
                    $bundlesName[] = $value;
                }
            };
        }

        if ($input->getOption('bundle-name')) {
            $name = $input->getOption('bundle-name');
            foreach (array_keys($bundles) as &$value) {
                if ($value === $name) {
                    $bundlesName[] = $value;
                }
            };
        }

        foreach($bundlesName as $bundleName) {
            /**
             * Check whether the bundle name exit in database.
             */
            $checkBundle = $this->em->getRepository('SunshineUIBundle:Bundle')
                ->findOneBy(['name' => $bundleName]);
            if (null !== $checkBundle) {
                $output->writeln('Bundle name '.$bundleName.' exist.');
                continue;
            }

            $dir = $this->getApplication()->getKernel()->locateResource('@'.$bundleName);
            $twigs = Finder::create()->files()->in($dir)->name('*.twig');
            $bundle = new Bundle();
            $bundle->setName($bundleName)
                ->setBundleRealPath($dir)
                ->setUniqueId(crc32($dir))
                ->setTwigAmount($twigs->count());
            $this->em->persist($bundle);

            foreach ($twigs->sortByName() as $file) {
                /**
                 * Check whether the twig exit in database.
                 */
                $checkTwig = $this->em->getRepository('SunshineUIBundle:Twig')
                    ->findOneBy(['fileRealPath' => $file->getRelativePath(), 'name' => $file->getFileName()]);
                if (null !== $checkTwig) {
                    $output->writeln('The Twig '.$file->getRealPath().' exist.');
                    continue;
                }

                $twig = new Twig();
                $twigPath = $file->getRealPath();
                $twig->setName($file->getFileName())
                    ->setFileRealPath($twigPath)
                    ->setUniqueId(crc32($twigPath))
                    ->setBundle($bundle);
                $this->em->persist($twig);

                /**
                 * Check whether the blocks exit in the twig.
                 */
                $twigService = $this->getContainer()->get('twig');
                $template = $twigService->loadTemplate($file->getRealPath());
                $blocks = $template->getBlockNames();
                if (empty($blocks)) {
                    $output->writeln('There is no block in the twig '.$file->getRealPath().'.');
                    continue;
                }

                foreach ($blocks as $blockName) {
                    $block = new Block();
                    $block->setName($blockName)
                        ->setTwig($twig);
                    $this->em->persist($block);
                }
            }
        }

        $this->em->flush();
        $output->writeln('------------ END --------------');
    }

}
