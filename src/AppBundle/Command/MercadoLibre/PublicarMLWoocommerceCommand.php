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


class PublicarMLWoocommerceCommand extends ContainerAwareCommand
{
	private $row = 0;
    

    protected function configure()
    {
        $this
            ->setName('ml:publicar:woocommerce')
            ->setDescription('Publicacion masiva de productos en ml')
            ->addOption('id_cuenta', null,         InputOption::VALUE_OPTIONAL,    'Cuenta id')
            ->addOption('youtec', null,         InputOption::VALUE_OPTIONAL,    'Publica Youtec')
            ->addOption('archivo', null,         InputOption::VALUE_OPTIONAL,    'Archivo');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cuenta_id = $input->getOption('id_cuenta');
        $archivo = $input->getOption('archivo');
        $youtec = $input->getOption('youtec') == "true" ? true : false ;

        $cuenta = $this->getContainer()->get('doctrine')->getManager()->getRepository(Cuenta::class)->findOneById($cuenta_id);

        if(!file_exists($archivo))
        {
            var_dump("Archivo no existe");die;
        }
        
        $array = [];
        if (($handle = fopen($archivo, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                if ($this->row > 1)
                    $this->getContainer()->get('post_meli_service')->replicarWoocommerce($data, $youtec, $cuenta);
                $this->row++;
          }
        }
      
        fclose($handle);
    }
}