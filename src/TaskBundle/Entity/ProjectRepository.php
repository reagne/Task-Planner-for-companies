<?php

namespace TaskBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends EntityRepository
{
    public function findAllProjectsByDueDate($user)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT p FROM TaskBundle:Project p
            JOIN p.projectUsers u
            WHERE u = :user OR p.projectOwner = :user
            ORDER BY p.dueDate ASC')
            ->setParameter('user', $user);
        return $query->getResult();
    }
    public function findAllProjectsWithActiveStatus(){
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT p FROM TaskBundle:Project p
            JOIN p.projectStatus s
            WHERE s.id != 1
            ORDER BY p.dueDate ASC');
        return $query->getResult();
    }
    public function findAllProjectsNotActiveStatus(){
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT p FROM TaskBundle:Project p
            JOIN p.projectStatus s
            WHERE s.id = 1
            ORDER BY p.dueDate ASC');
        return $query->getResult();
    }
}
