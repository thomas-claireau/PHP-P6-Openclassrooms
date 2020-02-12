<?php

namespace App\Repository;

use App\Entity\Figures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Figures|null find($id, $lockMode = null, $lockVersion = null)
 * @method Figures|null findOneBy(array $criteria, array $orderBy = null)
 * @method Figures[]    findAll()
 * @method Figures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FiguresRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Figures::class);
	}

	/**
	 * @return Figures[]
	 */
	public function findAll(): array
	{
		return $this->getQueryDesc()
			->getQuery()
			->getResult();
	}

	public function findAllQuery(): Query
	{
		return $this->getQueryDesc()
			->getQuery();
	}

	private function getQueryDesc()
	{
		return $this->createQueryBuilder('p')
			->orderBy('p.updated_at', 'DESC')
			->setMaxResults(15);
	}
}
