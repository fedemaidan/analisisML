<?php

namespace AppBundle\Repository\Traits;


trait PublicacionRepositoryTrait {
    public function damePublicacionesProducto($producto) {

		$query  = $this->createQueryBuilder('p');
     
		if ($producto) {
			$query->where('producto_id = $producto');
		}
		else {
			$query->where($query->expr()->isNull("p.producto"));
			$query->andWhere($query->expr()->isNotNull("p.brand"));
			$query->andWhere($query->expr()->isNotNull("p.model"));
		}

		$query->setMaxResults(2000);

		return $query->getQuery()->getResult();
	}
}