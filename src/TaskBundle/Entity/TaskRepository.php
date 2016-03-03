<?php

namespace TaskBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TaskRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TaskRepository extends EntityRepository
{
    public function findAllTasksByDueDate($user){
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT t FROM TaskBundle:Task t
            JOIN t.taskUsers u
            WHERE u = :user OR t.taskOwner = :user
            ORDER BY t.dueDate ASC')
            ->setParameter('user', $user);
        return $query->getResult();
    }
}
