<?php
namespace AppBundle\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use AppBundle\Entity\PublicacionPropia;
use JMS\DiExtraBundle\Annotation as DI;

class PublicacionPropiaSubscriber implements EventSubscriber
{
    private $container;
        
    public function __construct($container) {
        $this->container = $container;
    }

    public function getSubscribedEvents()
    {
        return array(
            'preUpdate',
        );
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entidad = $args->getEntity();

        if ($entidad instanceof PublicacionPropia) {

            if ($entidad->getSincronizar()) {
                $arrayCambios = $args->getEntityChangeSet();
                try {
                    $this->container->get('post_meli_service')->editarCamposPublicacionMercadolibre($entidad, $arrayCambios);
                }
                catch(\Exception $e) {
                    var_dump($e->getMessage(). " en ". $entidad->getId());
                }
            }

        }
    }

    
}
