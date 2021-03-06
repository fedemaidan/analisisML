<?php
namespace AppBundle\Command\MercadoLibre;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use AppBundle\Entity\Reserva;
use AppBundle\Entity\Producto;
use AppBundle\Entity\TipoDeVenta;
use AppBundle\Entity\TipoDeEntrega;
use AppBundle\Entity\TipoDePago;
use AppBundle\Entity\Estado;
use AppBundle\Entity\PublicacionEbay;
use AppBundle\Entity\Cuenta;


class PublicarMLCommand extends ContainerAwareCommand
{
	private $row = 0;
    

    protected function configure()
    {
        $this
            ->setName('ml:publicar')
            ->setDescription('Publicacion masiva de productos en ml')
            ->addOption('id_cuenta', null,         InputOption::VALUE_OPTIONAL,    'Cuenta id')
            ->addOption('youtec', null,         InputOption::VALUE_OPTIONAL,    'Publica Youtec')
            ->addOption('tipo_venta', null,         InputOption::VALUE_OPTIONAL,    'Tipo de venta');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cuenta_id = $input->getOption('id_cuenta');
        $tipo_venta = $input->getOption('tipo_venta');
        $youtec = $input->getOption('youtec') == "true" ? true : false ;

        $cuenta = $this->getContainer()->get('doctrine')->getManager()->getRepository(Cuenta::class)->findOneById($cuenta_id);

        $productos = $this->getContainer()->get('doctrine')->getManager()->getRepository(Producto::class)->findAll();
        
        foreach ($productos as $key => $producto) {
            
        $this->getContainer()->get('post_meli_service')->replicarProductoEnMl($producto, $tipo_venta ,$youtec, $cuenta);
        }
    }


}