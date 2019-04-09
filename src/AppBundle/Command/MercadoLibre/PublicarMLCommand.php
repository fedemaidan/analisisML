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
            ->setName('ml:publicar:stock')
            ->setDescription('Publicacion masiva de productos en ml')
            ->addOption('id_cuenta', null,         InputOption::VALUE_OPTIONAL,    'Cuenta id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cuenta_id = $input->getOption('id_cuenta');

        $cuenta = $this->getContainer()->get('doctrine')->getManager()->getRepository(Cuenta::class)->findOneById($id_cuenta);
        $producto = $this->getContainer()->get('doctrine')->getManager()->getRepository(Producto::class)->findOneById(1);
        
        $this->getContainer()->get('post_meli_service')->replicarProductoEnMl($producto, 'STOCK' ,FALSE, $cuenta);
    }


}