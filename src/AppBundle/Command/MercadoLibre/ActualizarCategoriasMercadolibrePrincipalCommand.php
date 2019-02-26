<?php
namespace AppBundle\Command\MercadoLibre;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use AppBundle\Utils\Meli\Meli;
use AppBundle\Entity\CategoriaML;

class ActualizarCategoriasMercadolibrePrincipalCommand extends ContainerAwareCommand
{
    protected function configure()
	{
	    $this
	        ->setName('ml:actualizar:categorias:principal')
	        ->setDescription('Actualizar categorias ml padres.')
	    ;
	}
	/*
		php app/console ml:actualizar:publicaciones
	*/

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$this->getContainer()->get('meli_service')->cargoCategoriasPadres(false);
    }
}
?>