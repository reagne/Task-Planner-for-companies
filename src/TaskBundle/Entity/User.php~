<?php
namespace TaskBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="log_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @ORM\Column(name="section", type="string")
     */
    protected $section = null;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="taskOwner")
     */
    protected $tasks;

    /**
     * @ORM\OneToMany(targetEntity="Project", mappedBy="projectOwner")
     */
    protected $projects;

    /**
     * @ORM\ManyToMany(targetEntity="UsersTask", mappedBy="taskUsers")
     */
    protected $coTasks;

    /**
     * @ORM\ManyToMany(targetEntity="Project", mappedBy="projectUsers")
     */
    protected $coProjects;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="log_user")
     */
    protected $comments;

    /**
     * Set section
     *
     * @param string $section
     * @return User
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return string 
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Add tasks
     *
     * @param \TaskBundle\Entity\Task $tasks
     * @return User
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
     * Add projects
     *
     * @param \TaskBundle\Entity\Project $projects
     * @return User
     */
    public function addProject(\TaskBundle\Entity\Project $projects)
    {
        $this->projects[] = $projects;

        return $this;
    }

    /**
     * Remove projects
     *
     * @param \TaskBundle\Entity\Project $projects
     */
    public function removeProject(\TaskBundle\Entity\Project $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Add coTasks
     *
     * @param \TaskBundle\Entity\Task $coTasks
     * @return User
     */
    public function addCoTask(\TaskBundle\Entity\Task $coTasks)
    {
        $this->coTasks[] = $coTasks;

        return $this;
    }

    /**
     * Remove coTasks
     *
     * @param \TaskBundle\Entity\Task $coTasks
     */
    public function removeCoTask(\TaskBundle\Entity\Task $coTasks)
    {
        $this->coTasks->removeElement($coTasks);
    }

    /**
     * Get coTasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCoTasks()
    {
        return $this->coTasks;
    }

    /**
     * Add coProjects
     *
     * @param \TaskBundle\Entity\Project $coProjects
     * @return User
     */
    public function addCoProject(\TaskBundle\Entity\Project $coProjects)
    {
        $this->coProjects[] = $coProjects;

        return $this;
    }

    /**
     * Remove coProjects
     *
     * @param \TaskBundle\Entity\Project $coProjects
     */
    public function removeCoProject(\TaskBundle\Entity\Project $coProjects)
    {
        $this->coProjects->removeElement($coProjects);
    }

    /**
     * Get coProjects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCoProjects()
    {
        return $this->coProjects;
    }

    /**
     * Add comments
     *
     * @param \TaskBundle\Entity\Comment $comments
     * @return User
     */
    public function addComment(\TaskBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \TaskBundle\Entity\Comment $comments
     */
    public function removeComment(\TaskBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
}
