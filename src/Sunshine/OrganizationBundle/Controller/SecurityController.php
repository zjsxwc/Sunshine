<?php

namespace Sunshine\OrganizationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @param Request $request
     * @Route("/login", name="login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        //获取可能存在的登录错误信息
        $error = $authenticationUtils->getLastAuthenticationError();

        //获取用户输入的username（用户名）
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'Security/login.html.twig',
            array(
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }
}
