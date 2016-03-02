<?php

namespace TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TaskBundle\Entity\ProjectRepository")
 */
class Project
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="datetime")
     */
    private $dueDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity="Project_Status", inversedBy="projects")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $projectStatus;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="project")
     */
    private $tasks;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="projects")
     * @ORM\JoinColumn(name="owner_user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $projectOwner;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy= "coProjects")
     * @ORM\JoinTable(name="project_user")
     */
    private $projectUsers;

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
     * @return Project
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
     * @return Project
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
     * @return Project
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
     * @return Project
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
     * @return Project
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
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->projectUsers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set projectStatus
     *
     * @param \TaskBundle\Entity\Project_Status $projectStatus
     * @return Project
     */
    public function setProjectStatus(\TaskBundle\Entity\Project_Status $projectStatus = null)
    {
        $this->projectStatus = $projectStatus;

        return $this;
    }

    /**
     * Get projectStatus
     *
     * @return \TaskBundle\Entity\Project_Status 
     */
    public function getProjectStatus()
    {
        return $this->projectStatus;
    }

    /**
     * Add tasks
     *
     * @param \TaskBundle\Entity\Task $tasks
     * @return Project
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
     * Set projectOwner
     *
     * @param \TaskBundle\Entity\User $projectOwner
     * @return Project
     */
    public function setProjectOwner(\TaskBundle\Entity\User $projectOwner = null)
    {
        $this->projectOwner = $projectOwner;

        return $this;
    }

    /**
     * Get projectOwner
     *
     * @return \TaskBundle\Entity\User 
     */
    public function getProjectOwner()
    {
        return $this->projectOwner;
    }

    /**
     * Add projectUsers
     *
     * @param \TaskBundle\Entity\User $projectUsers
     * @return Project
     */
    public function addProjectUser(\TaskBundle\Entity\User $projectUsers)
    {
        $this->projectUsers[] = $projectUsers;

        return $this;
    }

    /**
     * Remove projectUsers
     *
     * @param \TaskBundle\Entity\User $projectUsers
     */
    public function removeProjectUser(\TaskBundle\Entity\User $projectUsers)
    {
        $this->projectUsers->removeElement($projectUsers);
    }

    /**
     * Get projectUsers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjectUsers()
    {
        return $this->projectUsers;
    }
}
