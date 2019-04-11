<?php
namespace AppBundle\Command\MercadoLibre;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use AppBundle\Utils\Meli\Meli;
use AppBundle\Entity\PublicacionPropia;

class ActualizarPublicacionPropiaCommand extends ContainerAwareCommand
{
    protected function configure()
	{
	    $this
	        ->setName('ml:actualizar:publicaciones:propias')
	        ->setDescription('Actualizar publicaciones propias ml.')
	        ->addOption('id_publicacion', null,         InputOption::VALUE_OPTIONAL,    'Id de la publicación propia');
	    ;
	}
	/*
		php app/console ml:actualizar:publicaciones:propias --id_publicacion=1
	*/

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$publicacionId = $input->getOption('id_publicacion');
        
        if ($publicacionId) {
    		$publicacion = $this->getContainer()->get('doctrine')->getEntityManager()->getRepository(PublicacionPropia::class)->findOneById($publicacionId);
    		$this->getContainer()->get('meli_service')->actualizarPublicacion($publicacion);	
        }
        else {
            $publicaciones = $this->getContainer()->get('doctrine')->getEntityManager()->getRepository(PublicacionPropia::class)->findAll();
            foreach ($publicaciones as $key => $publicacion) {
                if (!(strpos($publicacion->getTitulo(), 'Garmin') !== false))
                $this->getContainer()->get('post_meli_service')->actualizarPublicacion($publicacion);
                var_dump("termine");
            }
        }
    }
}
?>