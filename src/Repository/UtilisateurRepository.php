<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Utilisateur|null find(string $id, string $mdp)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Utilisateur::class);
	}

	/**
	 * @throws ORMException
	 * @throws OptimisticLockException
	 */
	public function add(Utilisateur $utilisateur, bool $flush = true): void
	{
		$this->_em->persist($utilisateur);
		if ($flush)
		{
			$this->_em->flush();
		}
	}

	/**
	 * @throws ORMException
	 * @throws OptimisticLockException
	 */
	public function remove(Utilisateur $utilisateur, bool $flush = true): void
	{
		$this->_em->remove($utilisateur);
		if ($flush)
		{
			$this->_em->flush();
		}
	}

	/**
	 * @throws ORMException
	 * @throws OptimisticLockException
	 */
	public function getUtilisateur(string $id)
	{
		return $this->_em->find(Utilisateur::class, $id);
	}

	// /**
	//  * @return Fzef[] Returns an array of Fzef objects
	//  */
	/*
	public function findByExampleField($value)
	{
		return $this->createQueryBuilder('f')
			->andWhere('f.exampleField = :val')
			->setParameter('val', $value)
			->orderBy('f.id', 'ASC')
			->setMaxResults(10)
			->getQuery()
			->getResult()
		;
	}
	*/

	/*
	public function findOneBySomeField($value): ?Fzef
	{
		return $this->createQueryBuilder('f')
			->andWhere('f.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/
}