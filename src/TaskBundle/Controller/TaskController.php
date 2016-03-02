<?php

namespace TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TaskBundle\Entity\Task;
use TaskBundle\Entity\User;

class TaskController extends Controller
{
    private function taskForm($task){
        $form = $this->createFormBuilder($task);
        $form->add('title', 'text', ['label' => 'Tytuł: ']);
        $form->add('description', 'textarea', ['label' => 'Treść: ']);
        $form->add('taskUsers', 'entity', ['label' => 'Wybierz użytkownika: ', 'class' => 'TaskBundle\Entity\User', 'choice_label' => 'username', 'expanded' => 'true', 'multiple' =>'true']);
        $form->add('end_date', 'datetime', ['label' => 'Podaj termin realizacji: ', 'required' => false]);
        $form->add('save', 'submit', ['label' => 'Dodaj zadanie']);
        $form->setAction($this->generateUrl('createTask'));
        $taskForm = $form->getForm();

        return $taskForm;
    }

    /**
     * @Route("/addTask", name="addTask")
     * @Template("TaskBundle:Task:newTask.html.twig")
     */
    public function newTaskAction(){
        $task = new Task();
        $taskForm = $this->taskForm($task);

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

        $taskForm = $this->taskForm($task);
        $taskForm->handleRequest($req);

        if ($taskForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
        }

        return new Response('Stworzono zadanie');
    }
}
