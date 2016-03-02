<?php

namespace TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TaskBundle\Entity\TaskRepository")
 */
class Task
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
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime", nullable=true)
     */
    private $createDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="datetime", nullable=true)
     */
    private $dueDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="task")
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="Task_Status", inversedBy="tasks")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $taskStatus;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="tasks")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
     * @ORM\JoinColumn(name="owner_user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $taskOwner;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy= "coTasks")
     * @ORM\JoinTable(name="task_user")
     */
    private $taskUsers;


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
     * Set title
     *
     * @param string $title
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Task
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set dueDate
     *
     * @param \DateTime $dueDate
     * @return Task
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime 
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Task
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->taskUsers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add comments
     *
     * @param \TaskBundle\Entity\Comment $comments
     * @return Task
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

    /**
     * Set taskStatus
     *
     * @param \TaskBundle\Entity\Task_Status $taskStatus
     * @return Task
     */
    public function setTaskStatus(\TaskBundle\Entity\Task_Status $taskStatus = null)
    {
        $this->taskStatus = $taskStatus;

        return $this;
    }

    /**
     * Get taskStatus
     *
     * @return \TaskBundle\Entity\Task_Status 
     */
    public function getTaskStatus()
    {
        return $this->taskStatus;
    }

    /**
     * Set project
     *
     * @param \TaskBundle\Entity\Project $project
     * @return Task
     */
    public function setProject(\TaskBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \TaskBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set taskOwner
     *
     * @param \TaskBundle\Entity\User $taskOwner
     * @return Task
     */
    public function setTaskOwner(\TaskBundle\Entity\User $taskOwner = null)
    {
        $this->taskOwner = $taskOwner;

        return $this;
    }

    /**
     * Get taskOwner
     *
     * @return \TaskBundle\Entity\User 
     */
    public function getTaskOwner()
    {
        return $this->taskOwner;
    }

    /**
     * Add taskUsers
     *
     * @param \TaskBundle\Entity\User $taskUsers
     * @return Task
     */
    public function addTaskUser(\TaskBundle\Entity\User $taskUsers)
    {
        $this->taskUsers[] = $taskUsers;

        return $this;
    }

    /**
     * Remove taskUsers
     *
     * @param \TaskBundle\Entity\User $taskUsers
     */
    public function removeTaskUser(\TaskBundle\Entity\User $taskUsers)
    {
        $this->taskUsers->removeElement($taskUsers);
    }

    /**
     * Get taskUsers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTaskUsers()
    {
        return $this->taskUsers;
    }
}