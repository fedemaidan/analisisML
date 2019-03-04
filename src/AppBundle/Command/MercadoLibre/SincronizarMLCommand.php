<?php
namespace AppBundle\Command\MercadoLibre;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use AppBundle\Utils\Meli\Meli;
use AppBundle\Entity\PublicacionEbay;
use AppBundle\Entity\Cuenta;

class SincronizarMlCommand extends ContainerAwareCommand
{
    protected function configure()
	{
	    $this
	        ->setName('ml:sincronizar:propio')
	        ->setDescription('Sincronizar publicaciones propias segun ML')
	        ->addOption('id_cuenta', null,         InputOption::VALUE_REQUIRED,    'Id de la cuenta');
	    ;
	}

	/*
		php app/console ml:publicar:ebay --id_ebay=10455 --id_cuenta=1
	*/

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$cuenta = $this->getContainer()->get('doctrine')->getManager()->getRepository(Cuenta::class)->findOneById($input->getOption('id_cuenta'));

    	$this->getContainer()->get('meli_service')->sincronizarPublicacionesPropiasConMercadoLibre($cuenta);
    }
}

?>
