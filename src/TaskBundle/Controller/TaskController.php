<?php

namespace TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TaskBundle\Entity\Task;
use TaskBundle\Entity\User;

class TaskController extends Controller
{
    private function taskForm($task, $action){
        $form = $this->createFormBuilder($task);
        $form->add('title', 'text', ['label' => 'Tytuł: ']);
        $form->add('description', 'textarea', ['label' => 'Treść: ']);
//        $form->add('taskStatus', 'entity', ['label' => 'Wybierz status: ', 'class' => 'TaskBundle\Entity\Task_Status', 'choice_label' => 'name', 'expanded' => 'true', 'multiple' =>'false']);
        $form->add('taskUsers', 'entity', ['label' => 'Wybierz użytkownika: ', 'class' => 'TaskBundle\Entity\User', 'choice_label' => 'username', 'expanded' => 'true', 'multiple' =>'true']);
        $form->add('due_date', 'datetime', ['label' => 'Podaj termin realizacji: ', 'required' => false]);
        $form->add('save', 'submit', ['label' => 'Zapisz']);
        $form->setAction($action);
        $taskForm = $form->getForm();

        return $taskForm;
    }

    /**
     * @Route("/addTask", name="addTask")
     * @Template("TaskBundle:Task:newTask.html.twig")
     */
    public function newTaskAction(){
        $task = new Task();
        $taskForm = $this->taskForm($task,$this->generateUrl('createTask'));

        return['task' => $taskForm->createView()];
    }
    /**
     * @Route("/createTask", name="createTask")
     */
    public function createTaskAction(Request $req){

        $task = new Task();
        $owner = $this->getUser();
        $task->setTaskOwner($owner);
        $create_date = date("Y-m-d H:i:s");
        $task->setCreateDate(new \DateTime($create_date));

        $taskForm = $this->taskForm($task, $this->generateUrl('createTask'));
        $taskForm->handleRequest($req);

        if ($taskForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
        }

        //return $this->redirectToRoute('main');
        return new Response ("Utworzono");
    }

    /**
     * @Route ("/", name="main")
     * @Template("TaskBundle:Task:allTask.html.twig")
     *
     */
    public function allTasksAction(){
        $user = $this->getUser();
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task');

        $tasks = $repo->findAllTasksByDueDate($user);

        return ['tasks' => $tasks];
    }
    /**
     * @Route("/task/{id}", name="showTask")
     * @Template("TaskBundle:Task:oneTask.html.twig")
     */
    public function showTaskAction($id){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task');
        $task = $repo->find($id);

        return['task' => $task];
    }
    /**
     * @Route("/task/{id}/edit", name="taskToEdit")
     * @Method("GET")
     * @Template("TaskBundle:Task:newTask.html.twig")
     */
    public function taskToEditAction($id){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task');
        $task = $repo->find($id);
        $taskForm = $this->taskForm($task, $this->generateUrl('editTask', ['id' => $id]));

        return['task' => $taskForm->createView()];
    }
    /**
     * @Route("/task/{id}/edit", name="editTask")
     * @Method("POST")
     */
    public function editTaskAction(Request $req, $id)
    {
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task');
        $task = $repo->find($id);

        $taskForm = $this->taskForm($task, $this->generateUrl('editTask',['id' => $id]));
        $taskForm->handleRequest($req);

        if ($taskForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->redirectToRoute('showTask', ['id' => $id]);
    }
    /**
     * @Route("/task/{id}/remove", name="removeTask")
     *
     */
    public function removeTaskAction($id){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task');
        $task = $repo->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('main');
    }



}
