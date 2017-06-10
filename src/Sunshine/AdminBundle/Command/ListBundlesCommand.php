<?php

namespace Sunshine\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class ListBundlesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('list:bundles')
            ->setDescription('List all bundles or the bundles contains "Sunshine" at very begin of the bundle name')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('with-twig', null, InputOption::VALUE_NONE, 'List all Twigs of the Bundles')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument('argument');

        $bundles = $this->getApplication()->getKernel()->getBundles();
        switch ($argument) {
            case "mine":
                foreach (array_keys($bundles) as &$value) {
                    if (0 === strpos($value, 'Sunshine')) {
                        $bundlesName[] = $value;
                    }
                };
                break;
            case "all":
                foreach (array_keys($bundles) as &$value) {
                    $bundlesName[] = $value;
                };
                break;
        }

        if ($input->getOption('with-twig')) {
            foreach($bundlesName as $bundleName) {
                $dir = $this->getApplication()->getKernel()->locateResource('@'.$bundleName);
                $output->writeln('Bundle所处目录: '.$dir);
                $twigs = Finder::create()->files()->in($dir)->name('*.twig');
                $output->writeln("Twig 数量: ".$twigs->count());
                foreach ($twigs->sortByName() as $file) {
                    $output->writeln("Twig 名称: ".$file->getFilename());

                    $twigFile = $file->getRealPath();
                    $output->writeln("Twig 文件: ".$twigFile);

                    $twig = $this->getContainer()->get('twig');
                    $template = $twig->loadTemplate($twigFile);
                    dump('Template name: '.$template->getTemplateName());

                    $output->writeln("包含的 Block: ");
                    dump($template->getBlockNames());

                    $twigShortName = "SunshineUIBundle::base.html.twig";
                    //$twigShortName = "SunshineUIBundle::base.html.twig";
                    //$name  = $this->getContainer()->get('kernel')->locateResource($twigShortName);
                    $rootDir = str_replace('app', '', $this->getContainer()->get('kernel')->getRootDir());
                    $path = $twig->getLoader()->getCacheKey($twigShortName);
                    dump($rootDir.$path);
                    //dump($this->getContainer()->get('file_locator')->locate($name));

                    $output->writeln('');
                }
                $output->writeln('---------------------------------');
                $output->writeln('');
            }
        }

        $output->writeln('----- End -------');
    }

}
