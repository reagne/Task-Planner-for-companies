<?php

namespace TaskBundle\Controller;

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

        if ($projectForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
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
    public function allProjectsAction(){
        $user = $this->getUser();
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Project');

        $projects = $repo->findAllProjectsByDueDate($user);

        return ['projects' => $projects];
    }
    /**
     * @Route("/project/{id}", name="showProject")
     * @Template("TaskBundle:Project:oneProject.html.twig")
     */
    public function showprojectAction($id){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Project');
        $project = $repo->find($id);

        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task');
        $tasks = $repo->findByProject($id);

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
