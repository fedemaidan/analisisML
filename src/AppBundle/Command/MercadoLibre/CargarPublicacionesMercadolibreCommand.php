<?php
namespace AppBundle\Command\MercadoLibre;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use AppBundle\Utils\Meli\Meli;
use AppBundle\Entity\BusquedaEbay;

class CargarPublicacionesMercadolibreCommand extends ContainerAwareCommand
{
    protected function configure()
	{
	    $this
	        ->setName('ml:actualizar:publicaciones')
	        ->setDescription('Actualizar publicacion ml.')
	        ->addOption('busqueda_id', null,         InputOption::VALUE_REQUIRED,    'Id de la busqueda de MercadoLibre')
	    ;
	}
	/*
		php app/console ml:actualizar:publicaciones
	*/

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$busquedaId = $input->getOption('busqueda_id');
    	$this->getContainer()->get('meli_service')->buscarPublicacionesPorCategoria($busquedaId);
    }
}
?>