<?php

namespace Nakupujem\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Nakupujem\ShopBundle\Entity\Category;
use Nakupujem\ShopBundle\Form\CategoryType;

class CategoryController extends Controller
{
    /**
     * @Route("/category/")
     * @Template()
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()->getRepository('NakupujemShopBundle:Category')->findAll();

        return array(
            'categories' => $categories,
            );
    }

    /**
     * @Route("/category/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(new CategoryType(), $category);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
            );
    }

    /**
     * @Route("/category/{category_id}/edit", name="category/edit")
     * @Template()
     */
    public function editAction(Request $request, $category_id)
    {
        $category = $this->getDoctrine()->getRepository('NakupujemShopBundle:Category')->find($category_id);

        $form = $this->createForm(new CategoryType(), $category);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
            );
    }

    /**
     * @Route("/category/{category_id}/delete", name="category/delete")
     * @Template()
     */
    public function deleteAction($category_id)
    {
        $category = $this->getDoctrine()->getRepository('NakupujemShopBundle:Category')->find($category_id);

        if($category)
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();

            return new Response("Zmazaná kategória: " . $category->getName());
        }

        else
        {
            return new Response("Kategória s ID " . $category_id ." neexistuje.");
        }
    }

}
