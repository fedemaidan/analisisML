<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Entity\PublicacionML;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Reserva;
use AppBundle\Entity\TipoDePago;
use AppBundle\Entity\TipoDeVenta;
use AppBundle\Entity\Estado;
/**
 * Include the SDK by using the autoloader from Composer.
 */

class ReservasService
{

    private $container;
    
    /**
    *
    * @var EntityManager
    */
    private $em;


    public function __construct( Container $container, EntityManager $entityManager )
    {
        $this->container = $container;
        $this->em = $entityManager;
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
    }

    public function cargaMasivaReservas($archivo) {
        $row = 0;
        $titulos = [];
        if (($handle = fopen($archivo, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                    $row++;
                    if ($row == 1 ) {
                        $titulos = $data;
                        continue;
                    }

                    $masivaOC = $this->actualizarReservas($data, $titulos);

              }
            }
        
        $this->em->flush();
    }

    public function actualizarReservas($data, $titulos){
        
        foreach ($data as $key => $value) {
            $data[$key] = $value == "" ? null : $data[$key];
        }

        $reserva = null;
        foreach ($data as $key => $value) {
            $attr = $titulos[$key];
            
            if (empty($value)) continue;

            if ($key == 0) {
                $reserva = $this->em->getRepository(Reserva::class)->findOneById($value);
                continue;
            }
            else if ($attr == "estado") {
                $value = $this->em->getRepository(Estado::class)->findOneByCodigo($value);;
            }
            else if (strpos($attr, 'tipoDeVenta') === 0) {
                $attr = 'tipoDeVenta';
                $tv = $this->em->getRepository(TipoDeVenta::class)->findOneByCodigo($value);;
                if (!$tv && !empty($value)) {
                    throw new \Exception("Tipo de venta ".$value." no reconocido", 1);
                }
                $value = $tv;
            }
            else if (strpos($attr, 'tipoDePago') === 0) {
                $aux = explode('.', $attr);
                $aux = str_replace('_', '', $aux);
                $attr = $aux[0];
                $tp = $this->em->getRepository(TipoDePago::class)->findOneByCodigo($value);
                if (!$tp && !empty($value)) {
                    throw new \Exception("Tipo de pago ".$value." no reconocido", 1);
                }
                $value=$tp;
            }
            else if (strpos($attr, 'fecha') !== false) {
                $value = \DateTime::createFromFormat('Y-m-d', $value);
            }
            else if ($attr == "producto.nombre") {
                continue;
            }
            
            if ($reserva) {
                $attr = ucfirst($attr);
                $func = 'set'.$attr;
                $reserva->$func($value);
            }
        }
        
        $reserva = 1;
    }
}