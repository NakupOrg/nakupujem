<?php

namespace Nakupujem\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Nakupujem\ShopBundle\Form\RegisterUserType;

class UserController extends Controller
{
    /**
     * @Route("/user/profile", name="user/profile")
     * @Template()
     */
    public function profileAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $user = $this->getDoctrine()->getRepository('NakupujemShopBundle:User')->findOneByUsername($username);

        return array(
            'user' => $user,
            );
    }

    /**
     * @Route("/user/")
     * @Template("NakupujemShopBundle:Product:index.html.twig")
     */
    public function indexAction()
    {
        if($this->get('security.context'))
        {
            $username = $this->get('security.context')->getToken()->getUsername();
            $user = $this->getDoctrine()->getRepository('NakupujemShopBundle:User')->findOneByUsername($username);
        }
        else 
        {
            return $this->redirect($this->generateUrl("_user_login"));
        }
        $products = $this->getDoctrine()->getRepository('NakupujemShopBundle:Product')->findAll();
        $categories = $this->getDoctrine()->getRepository('NakupujemShopBundle:Category')->findAll();

        return array(
            'user' => $user,
            'products' => $products,
            'categories' => $categories,
            );
    }

    /**
     * @Route("/user/show/{user_id}")
     * @Template()
     */
    public function showAction($user_id)
    {
        $user = $this->getDoctrine()->getRepository('NakupujemShopBundle:User')->find($user_id);

        return array(
            'user' => $user,
            );
    }


    /**
     * @Route("/user/edit")
     * @Template()
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $username = $this->get('security.context')->getToken()->getUsername();
        $user = $this->getDoctrine()->getRepository('NakupujemShopBundle:User')->findOneByUsername($username);

        $form = $this->createForm(new RegisterUserType(), $user);
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em->persist($user);
            $em->flush();
        }
    }

}
