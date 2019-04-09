<?php

namespace AppBundle\Utils\Publicador;

class PublicadorStock extends PublicadorAbstract {	

	const TIPO_DE_VENTA = "STOCK";

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
•Contamos con STOCK del producto publicado.
";
    }


    public function getAjuste() {
        return 1.1;
    }
}