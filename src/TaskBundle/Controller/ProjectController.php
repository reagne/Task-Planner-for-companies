<?php

namespace TaskBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TaskBundle\Entity\Project;
use TaskBundle\Entity\User;

class ProjectController extends Controller
{
    private function projectForm($project, $action){
        $form = $this->createFormBuilder($project);
        $form->add('title', 'text', ['label' => 'Tytuł: ']);
        $form->add('description', 'textarea', ['label' => 'Treść: ']);
        $form->add('projectUsers', 'entity', ['label' => 'Wybierz użytkownika: ', 'class' => 'TaskBundle\Entity\User', 'choice_label' => 'username', 'expanded' => 'true', 'multiple' =>'true']);
        $form->add('due_date', 'datetime', ['label' => 'Podaj termin realizacji: ', 'required' => false]);
        $form->add('projectStatus', 'entity', [
            'label' => 'Wybierz status: ',
            'class' => 'TaskBundle\Entity\Project_Status',
            'query_builder' => function(EntityRepository $er){
                return $er->createQueryBuilder('t')->where('t.id != 1')->orderBy('t.name', 'ASC');},
            'choice_label' => 'name',
            'expanded' => false,
            'multiple' => false]);
        $form->add('save', 'submit', ['label' => 'Zapisz']);
        $form->setAction($action);
        $projectForm = $form->getForm();

        return $projectForm;
    }

    /**
     * @Route("/addProject", name="addProject")
     * @Template("TaskBundle:Project:newProject.html.twig")
     */
    public function newProjectAction(){
        $project = new Project();
        $projectForm = $this->projectForm($project,$this->generateUrl('createProject'));

        return['project' => $projectForm->createView()];
    }
    /**
     * @Route("/createProject", name="createProject")
     */
    public function createProjectAction(Request $req){

        $project = new Project();
        $owner = $this->getUser();
        $project->setProjectOwner($owner);
        $create_date = date("Y-m-d H:i:s");
        $project->setCreateDate(new \DateTime($create_date));

        $projectForm = $this->projectForm($project, $this->generateUrl('createProject'));
        $projectForm->handleRequest($req);

        $status = $projectForm->get('projectStatus')->getData();

        if ($projectForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $project->setTaskStatus($status);
            $status->addTask($project);
            $em->persist($project);
            $em->flush();
        }

        return $this->redirectToRoute('Projects');
    }

    /**
     * @Route ("/projects", name="Projects")
     * @Template("TaskBundle:Project:allProjects.html.twig")
     *
     */
    public function allActiveProjectsAction(){
        $user = $this->getUser();
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Project');

        $projects = $repo->findAllProjectsWithActiveStatus($repo->findAllProjectsByDueDate($user));

        return ['projects' => $projects];
    }
    /**
     * @Route ("/archive/project", name="archiveProject")
     * @Template("TaskBundle:Project:allArchiveProject.html.twig")
     *
     */
    public function allNotActiveProjectsAction(){
        $user = $this->getUser();
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Project');

        $projects = $repo->findAllProjectsNotActiveStatus($repo->findAllProjectsByDueDate($user));

        return ['projects' => $projects];
    }
    /**
     * @Route("/project/{id}/{status}", name="showProject", defaults={"status" = null})
     * @Template("TaskBundle:Project:oneProject.html.twig")
     */
    public function showProjectAction($id, $status){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Project');
        $project = $repo->find($id);

        $repo2 = $this->getDoctrine()->getRepository('TaskBundle:Task');
        $tasks = $repo2->findByProject($id);

        // Wykonanie projektu
        if($status != null){
            $repo3 = $this->getDoctrine()->getRepository('TaskBundle:Project_Status');
            $projectStatus = $repo3->find($status);

            $project->setProjectStatus($projectStatus);
            $end_date = date("Y-m-d H:i:s");
            $project->setEndDate(new \DateTime($end_date));
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();
        }

        return['project' => $project, 'tasks' => $tasks];
    }
    /**
     * @Route("/project/{id}/edit", name="projectToEdit")
     * @Method("GET")
     * @Template("TaskBundle:Project:newProject.html.twig")
     */
    public function projectToEditAction($id){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Project');
        $project = $repo->find($id);
        $projectForm = $this->projectForm($project, $this->generateUrl('editProject', ['id' => $id]));

        return['project' => $projectForm->createView()];
    }
    /**
     * @Route("/project/{id}/edit", name="editProject")
     * @Method("POST")
     */
    public function editProjectAction(Request $req, $id)
    {
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Project');
        $project = $repo->find($id);

        $projectForm = $this->projectForm($project, $this->generateUrl('editProject',['id' => $id]));
        $projectForm->handleRequest($req);

        if ($projectForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->redirectToRoute('showProject', ['id' => $id]);
    }
    /**
     * @Route("/project/{id}/remove", name="removeProject")
     *
     */
    public function removeprojectAction($id){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Project');
        $project = $repo->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();

        return $this->redirectToRoute('Projects');
    }



}
