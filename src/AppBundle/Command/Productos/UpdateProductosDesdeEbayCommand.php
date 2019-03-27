<?php
namespace AppBundle\Command\Productos;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use AppBundle\Utils\Meli\Meli;
use AppBundle\Entity\BusquedaEbay;

class UpdateProductosDesdeEbayCommand extends ContainerAwareCommand
{
    protected function configure()
	{
	    $this
	        ->setName('productos:ebay:update')
	        ->setDescription('Actualizar productos ebay.')
	    ;
	}
	/*
		php app/console productos:ebay:update
	*/

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$this->getContainer()->get('productos_service')->cargaProductosDesdeEbay();
    }
}
?>
