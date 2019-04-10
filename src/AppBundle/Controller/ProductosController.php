<?php
namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\PublicacionPropia;



class ProductosController extends Controller
{
    /**
     * @Route("/productos/woocommerce/csv", name="woocommerce_csv")
     */
    public function csvWoocommerceAction(Request $request)
    {
        $rows = $this->container->get('productos_service')->productosToCSVWoocommerce();
        $content = implode("\n", $rows);
        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');
    
        return $response;
    }

}

