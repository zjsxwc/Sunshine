<?php
namespace Sunshine\UIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sunshine\UIBundle\Entity\Twig;

abstract class SpfController extends Controller
{
    protected $template;
    protected $params;

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
        $data = [];
        $blocks  = $twig->getBlock();
        foreach ($blocks as $block) {
            if (true === $block->getSpfState()) {

            }
        }
    }
}