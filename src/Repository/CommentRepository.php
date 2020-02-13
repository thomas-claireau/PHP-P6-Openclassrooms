<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Comment;
use Doctrine\ORM\Query;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Comment::class);
	}

	/**
	 * @return Comment[]
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
				->getResult(Query::HYDRATE_ARRAY);
		}
	}

	public function countAll()
	{
		return intval($this->createQueryBuilder('p')
			->select('COUNT(p)')
			->getQuery()->getSingleScalarResult());
	}

	private function getQueryDesc(int $index)
	{
		$total = $this->countAll();
		$nbResultsPerPage = 10;


		$nbGroups = round($total / $nbResultsPerPage);
		$start = 0;
		$intervals = [];

		if (!$total || !$nbGroups) {
			return $this->createQueryBuilder('p')
				->orderBy('p.created_at', 'DESC')
				->setMaxResults($nbResultsPerPage);
		}

		for ($i = 1; $i <= $nbGroups; $i++) {
			$intervals[$i] = [
				'start' => $start
			];

			$start += $nbResultsPerPage;
		}

		$interval = $intervals[$index];

		return $this->createQueryBuilder('p')
			->orderBy('p.created_at', 'DESC')
			->setFirstResult($interval['start'])
			->setMaxResults($nbResultsPerPage);
	}
}
