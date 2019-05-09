<?php

namespace AppBundle\Utils\Publicador;

class PublicadorPedido extends PublicadorAbstract {	

	const TIPO_DE_VENTA = "PEDIDO";

    protected function getSufijo() {
    	$sufijo = "";
    	
 		if ($this->producto) {
 			foreach ($this->producto->getCategorias() as $key => $cate) {
 				$sufijo .= " ".$cate->getNombre();
 			}
 		}

    	return $sufijo;
    }

    protected function getTipoPrincipioTexto() {
    	return "------------------------------------------
Producto Traído BAJO PEDIDO.
El producto arriba al País dentro de los 25 (veinticinco) días a partir de la confirmación de la Reserva.

•¡Adquirí tu producto con mayor facilidad! No es necesario tener Clave Fiscal ni realizar Trámites de Importación.

•No es necesario abones la totalidad del producto para comenzar con la Operación. Consultanos para abonar un Anticipo en concepto de Reserva.

•Una vez llegado tu Producto al País, podrás abonar el monto restante de acuerdo al Medio de Pago que desees.

•Al realizar la compra, recibirás el VOUCHER de RESERVA correspondiente para poder realizar un SEGUIMIENTO PERSONALIZADO y seguro de tu producto.


Nuestro compromiso es total para asegurarte una experiencia de compra positiva ¡Cualquier duda que tengas, consultanos!

------------------------------------------

;"
    }

    public function getAjuste() {
        return 1.1;
    }

    public function getTipoDeVenta() {
        return self::TIPO_DE_VENTA;
    }
}