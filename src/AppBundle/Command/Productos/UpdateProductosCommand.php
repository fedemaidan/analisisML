<?php
namespace AppBundle\Command\Productos;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use AppBundle\Utils\Meli\Meli;
use AppBundle\Entity\BusquedaEbay;

class UpdateProductosCommand extends ContainerAwareCommand
{
    protected function configure()
	{
	    $this
	        ->setName('productos:update')
	        ->setDescription('Actualizar productos ml.')
	    ;
	}
	/*
		php app/console ml:actualizar:publicaciones
	*/

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$this->getContainer()->get('productos_service')->cargaProductosDesdeML();
    }
}
?>
