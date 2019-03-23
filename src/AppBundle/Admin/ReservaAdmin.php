<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;

class ReservaAdmin extends AbstractAdmin
{

    protected $baseRoutePattern = 'reserva';
    protected $datagridValues = [

        // reverse order (default = 'ASC')
        '_sort_order' => 'DESC',

        // name of the ordered field (default = the model's id field, if any)
        '_sort_by' => 'fechaAlta',
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, ['label' => "N° de reserva"])
            ->add('estado')
            ->add('empresa', null, [],  'choice', ['choices' => [ "INOVA" => "INOVA", "YOUTEC" => "YOUTEC"]])
            ->add('fechaAlta','doctrine_orm_date')
            ->add('precioVenta')
            ->add('informacion', null, array( 'label' => 'Información'))
            ->add('sena', null, array( 'label' => 'Seña'))
            ->add('link')
            ->add('mailCliente')
            ->add('facebookCliente')
            ->add('telefonoCliente')
            ->add('datosCliente')
            ->add('nickCliente')
            ->add('moneda', null, [],  'choice', ['choices' => [ "PESOS" => "PESOS", "DOLARES" => "DOLARES"]])
            ->add('productoNoCargado')
            ->add('codigoReserva')
            ->add('producto','doctrine_orm_model_autocomplete',[], null, ['property'=>'nombre', 'multiple' => true])
            ->add('tipoDePago_1')
            ->add('valorPago1')
            ->add('tipoDePago_2')
            ->add('valorPago2')
            ->add('tipoDeEntrega')
            ->add('tipoDeVenta')
            ->add('cuentaPago')
            ->add('cuentaPrincipal')
            ->add('costoCompraProducto')
            ->add('costoCompraProductoDeclarado')
            ->add('tracking')
            ->add('ordenDeCompra.warehouse')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', null, array(
                'label'   => "Acciones",
                'actions' => array(
                    'show' => array("template" => "AppBundle:Default:action_show_icon.html.twig"),
                    'edit' => array("template" => "AppBundle:Default:action_edit_icon.html.twig"),
                    'delete' => array("template" => "AppBundle:Default:action_delete_icon.html.twig"),
                ),
            ))
            ->add('id', null, ['label' => "N° Res"])
            ->add('empresa', 'choice', [
                'choices' => [
                    'INOVA' => 'INOVA',
                    'YOUTEC' => 'YOUTEC'
                ] ,
                'editable'=>true
                ])
            ->add('clienteStr',null, ['label' => "Cliente", 'editable'=>true])
            ->add('producto')
            ->add('productoNoCargado', null, ['label' => "Datos adicionales del producto", 'editable'=>true])
            ->add('link','url')
            ->add('precioVenta')
            ->add('estado', null, ['editable'=>true])
            ->add('fechaAlta', 'datetime', array( 'label' => 'Fecha de alta', 'format' => 'Y-m-d'))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab("Principal")
                ->with('Principal')
                ->add('empresa', 'choice', ['choices' => [ "INOVA" => "INOVA", "YOUTEC" => "YOUTEC"]])
                ->add('estado',null, ["required" => true])
                ->add('fechaAlta','sonata_type_datetime_picker',array(
                        'dp_side_by_side'       => true,
                        'dp_use_current'        => true,
                        'dp_use_seconds'        => false,
                        'dp_collapse'           => true,
                        'dp_calendar_weeks'     => false,
                        'dp_view_mode'          => 'days',
                        'format'                => 'yyyy-MM-dd'
                ))
                ->add('producto', 'sonata_type_model_autocomplete', array(
                    'property' => 'nombre',
                    'minimum_input_length' => 1
                ))
                ->add('productoNoCargado', null, ['label' => "Datos adicionales del producto"])
                ->add('cuentaPrincipal')
                ->add('fechaEstimada','sonata_type_datetime_picker',array(
                        'dp_side_by_side'       => true,
                        'dp_use_current'        => true,
                        'dp_use_seconds'        => false,
                        'dp_collapse'           => true,
                        'dp_calendar_weeks'     => false,
                        'dp_view_mode'          => 'days',
                        'format'                => 'yyyy-MM-dd',
                        'label'                 => 'Fecha estimada de entrega'
                ))
                ->add('fechaEntrega','sonata_type_datetime_picker',array(
                        'dp_side_by_side'       => true,
                        'dp_use_current'        => true,
                        'dp_use_seconds'        => false,
                        'dp_collapse'           => true,
                        'dp_calendar_weeks'     => false,
                        'required'              => false,
                        'dp_view_mode'          => 'days',
                        'format'                => 'yyyy-MM-dd'
                ))
                ->add('link')
                ->end()
            ->end()
            ->tab("Cliente")
                ->with('Cliente')
                ->add('nombreCliente')
                ->add('mailCliente')
                ->add('facebookCliente')
                ->add('telefonoCliente')
                ->add('tipoDocumento', 'choice', ['choices' => [ "DNI" => "DNI", "CUIT" => "CUIT"]])
                ->add('numeroDocumento')
                ->add('nickCliente')
                ->add('datosCliente','textarea',["required" => false])
                ->add('contactosConCliente','textarea',["required" => false, 'label' => 'Contactos con cliente'])
                ->end()
            ->end()
            ->tab('Pagos recibidos')
                ->with('Pago')
                ->add('cuentaPago')
                ->add('moneda', 'choice', ['choices' => [ "PESOS" => "PESOS", "DOLARES" => "DOLARES"]])
                ->add('precioVenta',  'number', array( 'precision' => 3))
                ->add('sena', null, array( 'label' => 'Seña'))
                ->add('tipoDeVenta')
                ->add('tipoDePago_1')
                ->add('fechaPago1','sonata_type_datetime_picker',array(
                        'dp_side_by_side'       => true,
                        'dp_use_current'        => true,
                        'dp_use_seconds'        => false,
                        'dp_collapse'           => true,
                        'dp_calendar_weeks'     => false,
                        'dp_view_mode'          => 'days',
                        'format'                => 'yyyy-MM-dd',
                        "required" => false
                ))
                ->add('valorPago1')
                ->add('tipoDePago_2')
                ->add('fechaPago2','sonata_type_datetime_picker',array(
                        'dp_side_by_side'       => true,
                        'dp_use_current'        => true,
                        'dp_use_seconds'        => false,
                        'dp_collapse'           => true,
                        'dp_calendar_weeks'     => false,
                        'dp_view_mode'          => 'days',
                        'format'                => 'yyyy-MM-dd',
                        "required" => false
                ))
                ->add('valorPago2')
                ->add('tipoDePago_3')
                ->add('fechaPago3','sonata_type_datetime_picker',array(
                        'dp_side_by_side'       => true,
                        'dp_use_current'        => true,
                        'dp_use_seconds'        => false,
                        'dp_collapse'           => true,
                        'dp_calendar_weeks'     => false,
                        'dp_view_mode'          => 'days',
                        'format'                => 'yyyy-MM-dd',
                        "required" => false
                ))
                ->add('valorPago3')
                ->add('tipoDePago_4')
                ->add('fechaPago4','sonata_type_datetime_picker',array(
                        'dp_side_by_side'       => true,
                        'dp_use_current'        => true,
                        'dp_use_seconds'        => false,
                        'dp_collapse'           => true,
                        'dp_calendar_weeks'     => false,
                        'dp_view_mode'          => 'days',
                        'format'                => 'yyyy-MM-dd',
                        "required" => false
                ))
                ->add('valorPago4')
                ->end()
            ->end()
            ->tab('Entrega')
                ->with('Entrega')
                ->add('tipoDeEntrega')
                ->add('costoClienteEntrega')
                ->add('provinciaEntrega')
                ->add('localidadEntrega')
                ->add('calleEntrega','textarea',["required" => false, "label" => "Dirección de la entrega"])
                ->add('nombreRecibeEntrega')
                ->add('celularRecibeEntrega')
                ->add('observacionesEntrega','textarea',["required" => false])
                ->end()
            ->end()
            ->tab('Facturación')
                ->with('Facturación')
                ->add('datosFactura')
                ->add('numeroFactura')
                ->end()
            ->end()
            ->tab('Costos')
                ->with('Costos')
                ->add('costoNosotrosEntrega')
                ->add('costoCompraProducto')
                ->add('costoCompraProductoDeclarado')
                ->end()
            ->end()
            ->tab('Otros')
                ->with('Otros')
                ->add('tracking')
                ->add('informacion','textarea',["required" => false, 'label' => 'Información'])
                ->end()
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
        ->with('Principal')
            ->add('id', null, ['label' => "N° de reserva"])
            ->add('empresa')
            ->add('estado',null, ["required" => true])
            ->add('fechaAlta', 'datetime', array( 'label' => 'Fecha de alta', 'format' => 'Y-m-d'))
            ->add('fechaEstimada', 'datetime', array( 'label' => 'Fecha de estimada', 'format' => 'Y-m-d'))
            ->add('fechaModificacion', 'datetime', array( 'label' => 'Última modificación', 'format' => 'Y-m-d H:i'))
            ->add('producto')
            ->add('productoNoCargado', null, ['label' => "Datos adicionales del producto"])
            ->end()
            ->with('Cliente')
            ->add('mailCliente')
            ->add('facebookCliente')
            ->add('telefonoCliente')
            ->add('tipoDocumento')
            ->add('numeroDocumento')
            ->add('nombreCliente')
            ->add('apellidoCliente')
            ->add('datosCliente')
            ->add('contactosConCliente')
            ->end()
            ->with('Pago')
            ->add('link')
            ->add('cuentaPrincipal')
            ->add('moneda')
            ->add('precioVenta')
            ->add('sena')
            ->add('tipoDeVenta')
            ->add('tipoDePago_1')
            ->add('fechaPago1', 'datetime', array( 'format' => 'Y-m-d'))
            ->add('valorPago1')
            ->add('tipoDePago_2')
            ->add('fechaPago2', 'datetime', array( 'format' => 'Y-m-d'))
            ->add('valorPago2')
            ->add('tipoDePago_3')
            ->add('fechaPago3', 'datetime', array( 'format' => 'Y-m-d'))
            ->add('valorPago3')
            ->add('tipoDePago_4')
            ->add('fechaPago4', 'datetime', array( 'format' => 'Y-m-d'))
            ->add('valorPago4')
            ->add('cuentaPago')
            ->add('datosFactura')
            ->add('numeroFactura')
            ->end()
            ->with('Entrega')
            ->add('tipoDeEntrega')
            ->add('costoClienteEntrega')
            ->add('costoNosotrosEntrega')
            ->add('provinciaEntrega')
            ->add('localidadEntrega')
            ->add('calleEntrega')
            ->add('codigoPostalEntrega')
            ->add('nombreRecibeEntrega')
            ->add('celularRecibeEntrega')
            ->add('fechaEntrega')
            ->add('observacionesEntrega')
            ->end()
            ->with('Otros')
            ->add('costoCompraProducto')
            ->add('costoCompraProductoDeclarado')
            ->add('tracking')
            ->add('ordenDeCompra.warehouse')
            ->add('informacion')
            ->add('codigoReserva')
            ->end()
            ->with('------')
            ->end()
        ;
    }

    protected function configureTabMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, array('edit', 'show', 'list'))) {
            return;
        }

        $comisiones = $this->getConfigurationPool()->getContainer()->get('analisis_service')->comisiones();

        $menu->addChild($comisiones);
    }

     public function getExportFields()
    {
        $results = $this->getModelManager()->getExportFields($this->getClass()); 
        //id - fecha alta - "producto - producto no cargado" - precio - tipo de venta - seña - tipo de pago 1 - valor pago 1 - tipo de apgo 2 - valor pago 2  - link - nombre cliente - email - documento cliente - telefono - nick mercado libre

        $results = array();
        $results[] = "id";
        $results[] = "empresa";
        $results[] = "estado";
        $results[] = "fechaAlta";
        $results[] = "fechaEstimada";
        $results[] = "producto.nombre";
        $results[] = "productoNoCargado";
        $results[] = "precioVenta";
        $results[] = "tipoDeVenta.codigo";
        $results[] = "sena";
        $results[] = "tipoDePago_1.codigo";
        $results[] = "fechapago1";
        $results[] = "valorPago1";
        $results[] = "tipoDePago_2.codigo";
        $results[] = "fechapago2";
        $results[] = "valorPago2";
        $results[] = "tipoDePago_3.codigo";
        $results[] = "fechapago3";
        $results[] = "valorPago3";
        $results[] = "link";
        $results[] = "nombreCliente";
        $results[] = "mailCliente";
        $results[] = "numeroDocumento";
        $results[] = "telefonoCliente";
        $results[] = "nickCliente";
        $results[] = "costoCompraProducto";
        $results[] = "costoCompraProductoDeclarado";
        $results[] = "tracking";
         
        return $results;
    }

    public function getDataSourceIterator()
    {
        $iterator = parent::getDataSourceIterator();
        $iterator->setDateTimeFormat('Y-m-d'); //change this to suit your needs
        return $iterator;
    }
}
