<?php

namespace AppBundle\Repository;

use AppBundle\Entity\PublicacionEbay;

/**
 * PublicacionEbayRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PublicacionEbayRepository extends \Doctrine\ORM\EntityRepository
{
	public function selectMaxId() {
		return $this->getEntityManager()->createQueryBuilder()
			    ->select('MAX(e.id)')
			    ->from(PublicacionEbay::ORM_ENTITY, 'e')
			    ->getQuery()
			    ->getSingleScalarResult();

	}

	public function findPaginated($first, $max) {
		return $this->getEntityManager()->createQueryBuilder()
			    ->select('e')
			    ->setFirstResult($first)
			    ->setMaxResults($max)
			    ->from(PublicacionEbay::ORM_ENTITY, 'e')
			    ->getQuery()
			    ->getResult();

	}

}
