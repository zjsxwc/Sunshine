<?php

namespace Sunshine\FormBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @Route("/form/html/ajax")
 * Class FormHTMLAjaxController
 * @package Sunshine\FormBundle\Controller
 */
class FormHTMLAjaxController extends Controller
{
    /**
     * TextType FormType 渲染的 html
     *
     * @Route("/{type}", options={"expose"=true}, name="form_html")
     * @param $type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function textTypeHTML($type)
    {
        switch ($type) {
            case "Text":
                $typeClass = TextType::class;
                break;
            case "TextArea":
                $typeClass = TextAreaType::class;
                break;
        }

        $form = $this->createForm($typeClass);
        return $this->render("SunshineFormBundle:FormHTML:text.html.twig", ['formView' => $form->createView()]);
    }
}
