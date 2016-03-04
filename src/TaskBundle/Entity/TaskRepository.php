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
    public function findAllTasksWithActiveStatus($user){
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT t, u, s FROM TaskBundle:Task t
            JOIN t.taskUsers u JOIN t.taskStatus s
            WHERE u = :user AND s != 1
            ORDER BY t.dueDate ASC')
            ->setParameter('user', $user);
        return $query->getResult();
    }

    public function findAllTasksNotActiveStatus($user){
            $em = $this->getEntityManager();
            $query = $em->createQuery('
            SELECT t, u, s FROM TaskBundle:Task t
            JOIN t.taskUsers u JOIN t.taskStatus s
            WHERE u = :user AND s = 1
            ORDER BY t.dueDate ASC')
            ->setParameter('user', $user);
            return $query->getResult();
   }
}
