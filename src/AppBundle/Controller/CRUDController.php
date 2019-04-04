<?php

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CRUDController extends Controller
{
    public function buscarEnEbayAction()
    {
        $object = $this->admin->getSubject();
        exec("php /server/app/console ebay:actualizar:publicacion --busqueda_id=".$object->getId()." >> /server/logs/logs_publicaciones_".$object->getId().".log &");

        $this->addFlash('sonata_flash_success', 'La carga de datos se esta realizando, pronto estaran cargados los resultados');

        return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }

    public function buscarEnMLAction()
    {
        $object = $this->admin->getSubject();
        
        exec("php /server/app/console ml:actualizar:publicaciones --busqueda_id=".$object->getId()." >> /server/logs/logs_publicaciones_ML_".$object->getId().".log &");

        $this->addFlash('sonata_flash_success', 'La carga de datos se esta realizando, pronto estaran cargados los resultados');

        return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }
    
    public function sincronizarCuentaMLAction()
    {
        $cuenta = $this->admin->getSubject();
        $empresa = 'youtec';
        
        /** Sincronizar con ML **/
        $id = $cuenta->getId();

        return new RedirectResponse("https://notiml.com/iniciarConML?cuenta_id=".$id.'&empresa='.$empresa);
    }

    public function crearProductoAction()
    {
        $publicacionML = $this->admin->getSubject();
        
        $producto = $this->container->get('productos_service')->crearProducto($publicacionML);

        return new RedirectResponse($this->container->get('router')->generate('admin_app_producto_edit', ["id"=>$producto->getId()]));

    }

    public function cloneAction()
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        $clonedObject = clone $object;  // Careful, you may need to overload the __clone method of your object
                                        // to set its id to null
        $clonedObject->setName($object->getName()." (Clone)");

        $this->admin->create($clonedObject);

        $this->addFlash('sonata_flash_success', 'Cloned successfully');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}