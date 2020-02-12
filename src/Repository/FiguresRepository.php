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
	public function findItems(int $index = 1): array
	{
		return $this->getQueryDesc($index)
			->getQuery()
			->getResult();
	}

	public function findMoreItems(int $index): array
	{
		if ($index !== 1) {
			return $this->getQueryDesc($index)
				->getQuery()
				->getResult();
		}
	}


	private function getQueryDesc(int $index)
	{
		$total = $this->countAll();
		$nbGroups = round($total / 15);
		$start = 0;
		$intervals = [];

		for ($i = 1; $i <= $nbGroups; $i++) {
			$intervals[$i] = [
				'start' => $start
			];

			$start += 15;
		}

		$interval = $intervals[$index];

		return $this->createQueryBuilder('p')
			->orderBy('p.updated_at', 'DESC')
			->setFirstResult($interval['start'])
			->setMaxResults(15);
	}

	private function countAll()
	{
		return intval($this->createQueryBuilder('p')
			->select('COUNT(p)')
			->getQuery()->getSingleScalarResult());
	}
}
