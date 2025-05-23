<?php
namespace App\Repository;

use App\Entity\MoyenTransport;
use App\Entity\StatusTransport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MoyenTransport>
 */
class MoyenTransportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoyenTransport::class);
    }

    /**
     * Récupère la liste de tous les moyens de transport
     * @return MoyenTransport[] 
     */
  
    
    // Dans le repository MoyenTransportRepository
    public function findAllMoyenTransport()
    {
        return $this->createQueryBuilder('m')
            ->where('m.status = :status')
            ->setParameter('status', StatusTransport::DISPONIBLE)
            ->getQuery()
            ->getResult();
    }

}
