<?php

namespace Nakupujem\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Nakupujem\ShopBundle\Entity\User;

use Nakupujem\ShopBundle\Form\RegisterUserType;

class SecurityController extends Controller
{
    /**
     * @Route("/user/security-check", name="_user_security_check")
     * @Template()
     */
    public function userSecurityCheckAction()
    {
        //Security layer will handle this
    }

    /**
     * @Route("/login/user", name="_user_login")
     * @Template()
     */
    public function userLoginAction()
    {
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );
    }

    /**
     * @Route("/register/user", name="_user_register")
     * @Template()
     */
    public function registerUserAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new RegisterUserType(), $user);

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $user->setLang('sk');
            $em->persist($user);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
            );
    }

    /**
     * @Route("/user/logout", name="_user_logout")
     * @Template()
     */
    public function userLogoutAction()
    {
        return $this->redirect($this->generateUrl('_parent_login'));
    }

}
