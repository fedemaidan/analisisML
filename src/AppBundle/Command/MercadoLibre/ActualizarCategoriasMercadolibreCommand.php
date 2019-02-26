<?php
namespace AppBundle\Command\MercadoLibre;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use AppBundle\Utils\Meli\Meli;
use AppBundle\Entity\CategoriaML;

class ActualizarCategoriasMercadolibreCommand extends ContainerAwareCommand
{
    protected function configure()
	{
	    $this
	        ->setName('ml:actualizar:categorias')
	        ->setDescription('Actualizar categorias ml.')
	        ->addOption('categoria_ml', null,         InputOption::VALUE_OPTIONAL,    'Id de la categoria de MercadoLibre');
	    ;
	}
	/*
		php app/console ml:actualizar:publicaciones
	*/

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$categoriaId = $input->getOption('categoria_ml');
    	if ($categoriaId) {
    		$categoria = $this->getContainer()->get('doctrine')->getEntityManager()->getRepository(CategoriaML::class)->findOneByIdMl($categoriaId);
    		$this->getContainer()->get('meli_service')->buscarCategoriasHijas($categoria);	
    	}
    	else $this->getContainer()->get('meli_service')->cargoCategoriasPadres();
    }
}
?>