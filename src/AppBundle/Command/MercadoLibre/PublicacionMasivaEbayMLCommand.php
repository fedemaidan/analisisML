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


class PublicacionMasivaEbayMLCommand extends ContainerAwareCommand
{
	private $row = 0;
    

    protected function configure()
    {
        $this
            ->setName('ml:publicar:masiva:ebay')
            ->setDescription('Publicacion masiva de productos en ml')
            ->addOption('id_cuenta', null,         InputOption::VALUE_REQUIRED,    'Cuenta id')
            ->addOption('archivo', null,         InputOption::VALUE_REQUIRED,    'Archivo de csv');
    }
    
    /*
		php app/console ml:publicar:masiva:ebay --id_cuenta=1 --archivo=/server/export.1.csv
	*/


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $archivo = $input->getOption('archivo');
        $cuenta_id = $input->getOption('id_cuenta');

        if(!file_exists($archivo))
        {
            throw new InvalidArgumentException("No existe el archivo $archivo");
        }
 		
 		    $array = [];
        if (($handle = fopen($archivo, "r")) !== FALSE) {
	        while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                
				if ($this->row > 0) {
	           	    $this->cargarPublicacion($data, $cuenta_id);
                }
	           	$this->row++;
	      }
      	}
        
      $this->getContainer()->get('doctrine')->getManager()->flush();
      fclose($handle);
    }

    protected function cargarPublicacion($data, $id_cuenta) {
        $tipoVenta = "STOCK";
        $comoYouTec = false;
        
    	    	
    	$cuenta = $this->getContainer()->get('doctrine')->getManager()->getRepository(Cuenta::class)->findOneById($id_cuenta);

		
		$id_ebay  = $data[0];

    	$publi_ebay = $busqueda = $this->getContainer()->get('doctrine')->getManager()->getRepository(PublicacionEbay::class)->findOneById($id_ebay);

        if ($publi_ebay == null) {
            var_dump("no tengo id ebay ".$id_ebay);
            return;
        }

    	$this->getContainer()->get('post_meli_service')->replicarPublicacionEbayEnMl($publi_ebay, $cuenta,$tipoVenta, $comoYouTec);
    	
    }

    

}