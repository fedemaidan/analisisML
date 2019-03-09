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



class PublicacionesPropiasController extends Controller
{
    /**
     * @Route("/publicaciones_propias/woocommerce/csv", name="woocommerce_csv")
     */
    public function csvToWoocommerceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $publicaciones = $em->getRepository(PublicacionPropia::class)->findAll();

        $rows = array();
        $rows[] = "id,type,sku,name,status,featured,catalog_visibility,short_description,description,date_on_sale_from,date_on_sale_to,tax_status,tax_class,stock_status,backorders,sold_individually,weight,height,reviews_allowed,purchase_note,price,regular_price,manage_stock/stock_quantitiy,category_ids,tag_ids,shipping_class_id,attributes,attributes,default_attributes,attributes,image_id/gallery_image_ids,attributes,downloads,downloads,download_limit,download_expiry,parent_id,upsell_ids,cross_sell_ids";
//        $rows[] = ['id','type','sku','name','status','featured','catalog_visibility','short_description','description','date_on_sale_from','date_on_sale_to','tax_status','tax_class','stock_status','backorders','sold_individually','weight','height','reviews_allowed','purchase_note','price','regular_price','manage_stock/stock_quantitiy','category_ids','tag_ids','shipping_class_id','attributes','attributes','default_attributes','attributes','image_id/gallery_image_ids','attributes','downloads','downloads','download_limit','download_expiry','parent_id','upsell_ids','cross_sell_ids'];

        foreach ($publicaciones as $publi) {
            $data = [
                $publi->getWoocommerceId(), //id
                'simple', // type
                $publi->getId(), //sku
                $publi->getPublicacionEbay()->getTitulo(), //name
                1, //status
                $publi->getDestacado() ? 1 : 0, //featured
                'visible', //catalog_visibility
                '', //short_description
                '', //description
                '',//date_on_sale_from
                '',//date_on_sale_to
                '',//tax_status
                '',//tax_class
                1,//stock_status
                1,//backorders
                1,//sold_individually
                '',//weight
                '',//height
                1,//reviews_allowed
                'Muchas gracias por confiar en nosotros',//purchase_note
                $publi->getPrecioCompra()*0.85,//price
                $publi->getPrecioCompra(),//regular_price
                99,//manage_stock
                99,//stock_quantitiy
                $publi->getMarca(),//category_ids
                '',//tag_ids
                '',//shipping_class_id
                '',//attributes
                '',//attributes
                '',//default_attributes
                '',//attributes
                str_replace(',','/',$publi->getImagenes()),//image_id/gallery_image_ids
                '',//attributes
                '',//downloads
                '',//downloads
                '',//download_limit
                '',//download_expiry
                '',//parent_id
                '',//upsell_ids
                '',//cross_sell_ids
            ];

            $rows[] = implode(',', $data);
        }

        $content = implode("\n", $rows);
        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');
    
        return $response;
    }

}

