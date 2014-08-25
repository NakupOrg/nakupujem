<?php

namespace Nakupujem\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Nakupujem\ShopBundle\Entity\Product;
use Nakupujem\ShopBundle\Entity\Photo;
use Nakupujem\ShopBundle\Form\ProductType;


class ProductController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $products = $this->getDoctrine()->getRepository('NakupujemShopBundle:Product')->findAll();

        return array(
            'products' => $products,
            );
    }

    /**
     * @Route("/show")
     * @Template()
     */
    public function showAction()
    {

    }

    /**
     * @Route("product/add", name="product/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $product = new Product();
        $photo = new Photo();
        $product->addPhoto($photo);
        $form = $this->createForm(new ProductType(), $product);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            foreach ($photo as $item) {
            $item->upload();
            $item->setProduct($product);
                # code...
            }
            $em->persist($product);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
            );
    }

    /**
     * @Route("product/{product_id}/edit/", name="product/edit")
     * @Template()
     */
    public function editAction(Request $request, $product_id)
    {
        $product = $this->getDoctrine()->getRepository('NakupujemShopBundle:Product')->find($product_id);

        $form = $this->createForm(new ProductType(), $product);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine->getManager();
            $photo->upload();
            $photo->setProduct($product);
            $em->persist($product);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
            );
    }

    /**
     * @Route("product/{product_id}/delete")
     * @Template()
     */
    public function deleteAction($product_id)
    {
        $product = $this->getDoctrine()->getRepository('NakupujemShopBundle:Product')->find($product_id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
    }

}
