<?php

namespace Nakupujem\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Nakupujem\ShopBundle\Entity\Subcategory;
use Nakupujem\ShopBundle\Form\SubcategoryType;


class SubcategoryController extends Controller
{
    /**
     * @Route("/user/subcategory/")
     * @Template()
     */
    public function indexAction()
    {
        $subcategories = $this->getDoctrine()->getRepository('NakupujemShopBundle:Subcategory')->findAll();

        return array(
            'subcategories' => $subcategories,
            );
    }

    /**
     * @Route("/subcategory/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $subcategory = new Subcategory();

        $form = $this->createForm(new SubcategoryType(), $subcategory);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subcategory);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
            );
    }

    /**
     * @Route("/subcategory/{subcategory_id}/edit")
     * @Template()
     */
    public function editAction($subcategory_id, Request $request)
    {
        $subcategory = $this->getDoctrine()->getRepository('NakupujemShopBundle:Subcategory')->find($subcategory_id);

        $form = $this->createForm(new SubcategoryType(), $subcategory);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subcategory);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
            );

    }

    /**
     * @Route("subcategory/{subcategory_id}/delete")
     * @Template()
     */
    public function deleteAction($subcategory_id)
    {
        $subcategory = $this->getDoctrine()->getRepository('NakupujemShopBundle:Subcategory')->find($subcategory_id);

        if($subcategory)
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subcategory);
            $em->flush();

            return new Response("Zmazaná subkategória: " . $subcategory->getName());
        }

        else
        {
            return new Response("Subkategória s ID " . $subcategory_id ." neexistuje.");
        }
    }

}
