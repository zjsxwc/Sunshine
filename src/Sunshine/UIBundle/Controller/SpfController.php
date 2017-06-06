<?php
namespace Sunshine\UIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sunshine\UIBundle\Entity\Twig;
use Symfony\Component\HttpFoundation\Response;

abstract class SpfController extends Controller
{
    protected $template;
    protected $params;
    protected $em;
    protected $twig;

    protected function spfRender($template, $params=[])
    {
        $requestStack = $this->get('request_stack');
        $request = $requestStack->getCurrentRequest();
        $this->template = $template ? $template : null;
        $this->params = $params ? $params : [];

        $spf = $request->query->get('spf', '');
        if ($spf === 'navigate' && $template) {
            $data = $this->getNavigateData($template);
            return new JsonResponse($data);
        }
        return $this->render($template, $params);
    }

    protected function getNavigateData($template)
    {
        $this->twig = $this->get('twig');
        $uniqueId = $this->getUniqueId($template);
        $this->em = $this->get('doctrine')->getManager();
        $blocks = $this->em->getRepository('SunshineUIBundle:Block')
            ->findByTemplate($uniqueId);
        dump($blocks);
    }

    protected function getUniqueId($template)
    {
        $rootDir = str_replace('app', '', $this->get('kernel')->getRootDir());
        $path = $this->twig->getLoader()->getCacheKey(str_replace('@', '', $template));
        return crc32($rootDir.$path);
    }
}