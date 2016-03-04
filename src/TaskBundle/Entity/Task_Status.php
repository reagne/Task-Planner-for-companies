<?php

namespace TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task_Status
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Task_Status
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="taskStatus")
     */
    private $ownerTask;

    /**
     * @ORM\OneToMany(targetEntity="UsersTask", mappedBy="coTaskStatus")
     */
    private $coTask;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Task_Status
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add tasks
     *
     * @param \TaskBundle\Entity\Task $tasks
     * @return Task_Status
     */
    public function addTask(\TaskBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \TaskBundle\Entity\Task $tasks
     */
    public function removeTask(\TaskBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add ownerTask
     *
     * @param \TaskBundle\Entity\Task $ownerTask
     * @return Task_Status
     */
    public function addOwnerTask(\TaskBundle\Entity\Task $ownerTask)
    {
        $this->ownerTask[] = $ownerTask;

        return $this;
    }

    /**
     * Remove ownerTask
     *
     * @param \TaskBundle\Entity\Task $ownerTask
     */
    public function removeOwnerTask(\TaskBundle\Entity\Task $ownerTask)
    {
        $this->ownerTask->removeElement($ownerTask);
    }

    /**
     * Get ownerTask
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwnerTask()
    {
        return $this->ownerTask;
    }

    /**
     * Add coTask
     *
     * @param \TaskBundle\Entity\UsersTask $coTask
     * @return Task_Status
     */
    public function addCoTask(\TaskBundle\Entity\UsersTask $coTask)
    {
        $this->coTask[] = $coTask;

        return $this;
    }

    /**
     * Remove coTask
     *
     * @param \TaskBundle\Entity\UsersTask $coTask
     */
    public function removeCoTask(\TaskBundle\Entity\UsersTask $coTask)
    {
        $this->coTask->removeElement($coTask);
    }

    /**
     * Get coTask
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCoTask()
    {
        return $this->coTask;
    }
}
