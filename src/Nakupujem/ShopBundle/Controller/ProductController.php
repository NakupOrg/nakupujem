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
use Nakupujem\ShopBundle\Form\ContactFormType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Padam87\SearchBundle\Filter\Filter;


class ProductController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $products = $this->getDoctrine()->getRepository('NakupujemShopBundle:Product')->findAll();
        $categories = $this->getDoctrine()->getRepository('NakupujemShopBundle:Category')->findAll();

        return array(
            'products' => $products,
            'categories' => $categories,
            );
    }

    /**
     * @Route("/search", name="search")
     * @Template("NakupujemShopBundle:Product:index.html.twig")
     */
    public function searchAction(Request $request)
    {
        $data = array(
            'title' => "*".$request->get('keyword')."*",
            'description' => "*".$request->get('keyword')."*",
            );
        $fm = $this->get('padam87_search.filter.manager');
        $filter = new Filter($data, 'NakupujemShopBundle:Product', 'product');
        $qb = $fm->createQueryBuilder($filter);
        $result = $qb->getQuery()->getResult();
        $categories = $this->getDoctrine()->getRepository('NakupujemShopBundle:Category')->findAll();

        return array(
            'products' => $result,
            'categories' => $categories,
            );
    }

    /**
     * @Route("/product/show/{product_id}", defaults={"product_id" = null}, name="product_show")
     * @Template()
     */
    public function showAction($product_id)
    {
        $product = $this->getDoctrine()->getRepository('NakupujemShopBundle:Product')->find($product_id);
        $form = $this->createForm(new ContactFormType());
        if($product)
        {    
            return array(
                'product' => $product,
                'form' => $form->createView(),
                );
        }
        else 
        {
            throw new HttpNotFoundException('Daný produkt neexistuje!');
            
        }
    }

    /**
     * @Route("/user/product/add", name="product/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = new Product();
        $photo = new Photo();
        $product->addPhoto($photo);
        $photo->setProduct($product);
        $form = $this->createForm(new ProductType(), $product);
        $user = $this->getDoctrine()->getRepository("NakupujemShopBundle:User")->find(1);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $hash = substr(md5(microtime()), 1, 4);
            $photo->setUploadDir($hash);
            $photo->upload($hash);
            $product->setUser($user);
            $em->persist($product);
            $em->flush();
        }

        return array(
            'form' => $form->createView(),
            );
    }

    /**
     * @Route("/user/product/edit/{product_id}", name="product/edit")
     * @Template()
     */
    public function editAction(Request $request, $product_id)
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $user = $this->getDoctrine()->getRepository('NakupujemShopBundle:User')->findOneByUsername($username);

        $product = $this->getDoctrine()->getRepository('NakupujemShopBundle:Product')->find($product_id);
        if($product)
        {   
            if($product->getUser() === $user)
            {
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

            else 
            {
                throw new AccessDeniedHttpException('You have no right to do this!');            
            }
        }

        else 
        {
            throw new NotFoundHttpException('Daný produkt neexistuje!');
        }

    }

    /**
     * @Route("/user/product/delete/{product_id}")
     * @Template()
     */
    public function deleteAction($product_id)
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $user = $this->getDoctrine()->getRepository('NakupujemShopBundle:User')->findOneByUsername($username);

        $product = $this->getDoctrine()->getRepository('NakupujemShopBundle:Product')->find($product_id);
        if($product)
        {
            if($product->getUser() === $user)
            {
                $em = $this->getDoctrine()->getManager();
                $em->remove($product);
                $em->flush();
            }

            else 
            {
                throw new AccessDeniedHttpException('You have no right to do this!');            
            }
        }

        else 
        {
            throw new NotFoundHttpException('Daný produkt neexistuje!');
        }
    }

}
