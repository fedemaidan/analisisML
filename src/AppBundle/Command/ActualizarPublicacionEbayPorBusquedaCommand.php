<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use AppBundle\Utils\Meli\Meli;
use AppBundle\Entity\BusquedaEbay;

class ActualizarPublicacionEbayPorBusquedaCommand extends ContainerAwareCommand
{
    protected function configure()
{
    $this
        ->setName('ebay:actualizar:publicacion')
        ->setDescription('Actualizar publicacion ebay.')
        ->addOption('busqueda_id', null,         InputOption::VALUE_REQUIRED,    'Id de la busqueda');
    ;
}
	/*
		php app/console ebay:actualizar:publicacion --busqueda_id=1
	*/

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $busqueda_id = $input->getOption('busqueda_id');
        $busqueda = $this->getContainer()->get('doctrine')->getManager()->getRepository(BusquedaEbay::ORM_ENTITY)->findOneById($busqueda_id);
        
        $this->getContainer()->get('ebay_service')->actualizarPublicaciones($busqueda);

    }
}