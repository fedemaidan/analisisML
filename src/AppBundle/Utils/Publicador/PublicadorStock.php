<?php

namespace AppBundle\Utils\Publicador;

class PublicadorStock {	

	const TIPO_DE_VENTA = "STOCK";

    protected function getSufijo() {
    	if ($this->comoYouTec)
    		return " YouTec";
    	return '';
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