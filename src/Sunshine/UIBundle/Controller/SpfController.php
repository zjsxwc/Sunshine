<?php
namespace Sunshine\UIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class SpfController extends Controller
{
    protected $template;
    protected $params;
    protected $em;
    protected $twig;
    protected $jsonArray;

    protected function spfRender($template, $params=[])
    {
        $requestStack = $this->get('request_stack');
        $this->twig = $this->get('twig');
        $request = $requestStack->getCurrentRequest();
        $this->template = $template ? $template : null;
        $this->params = $params ? $params : [];

        $spf = $request->query->get('spf', '');
        if ($spf === 'navigate' && $template) {
            $data = $this->getNavigateData($template);
            if ($data) {
                return new JsonResponse($data);
            }
        }
        return $this->render($template, $params);
    }

    protected function getNavigateData($template)
    {
        $uniqueId = $this->getUniqueId($template);
        $this->em = $this->get('doctrine')->getManager();
        $blocks = $this->em->getRepository('SunshineUIBundle:Block')
            ->findByTemplate($uniqueId);
        $this->jsonArray = [
            'head' => '',
            'body' => [],
            'foot' => ''
        ];

        foreach ($blocks as $block) {
            $blockContent = $this->renderBlock($template, $block->getName(), $this->params);
            switch ($block->getSpfFragment()) {
                case "body":
                    $this->jsonArray['body'][$block->getName()] = $blockContent;
                    break;
                case "foot":
                    $this->jsonArray['foot'] .= $blockContent;
                    break;
                case 'head':
                    $this->jsonArray['head'] .= $blockContent;
                    break;
            }
        }

        $this->jsonArray = array_filter($this->jsonArray, function($value) { return $value !== ''; });

        return !empty($this->jsonArray)
            ? $this->jsonArray
            : null;
    }

    protected function getUniqueId($template)
    {
        $rootDir = str_replace('app', '', $this->get('kernel')->getRootDir());
        $path = $this->twig->getLoader()->getCacheKey(str_replace('@', '', $template));
        return crc32($rootDir.$path);
    }

    protected function renderBlock($template, $blockName, $params = array())
    {
        $template = $this->twig->loadTemplate($template);
        return $template->renderBlock($blockName, $this->twig->mergeGlobals($params));
    }
}