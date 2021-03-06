<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    /**
     * BookingRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    /**
     * @param \DateTime $date
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findNumberOfTicketsByDate(\DateTime $date)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('SUM(c.number)')
            ->where('c.date = :date')
            ->setParameter('date', $date);
        return $qb->getQuery()->getSingleScalarResult();
    }

}
