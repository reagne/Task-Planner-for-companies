<?php

namespace TaskBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TaskBundle\Entity\Comment;
use TaskBundle\Entity\Task;
use TaskBundle\Entity\User;

class TaskController extends Controller
{
    private function taskForm($task, $action){
        $form = $this->createFormBuilder($task);
        $form->add('title', 'text', ['label' => 'Tytuł: ']);
        $form->add('description', 'textarea', ['label' => 'Treść: ']);
        $form->add('taskStatus', 'entity', [
            'label' => 'Wybierz status: ',
            'class' => 'TaskBundle\Entity\Task_Status',
            'query_builder' => function(EntityRepository $er){
                  return $er->createQueryBuilder('t')->where('t.id != 1')->orderBy('t.name', 'ASC');},
            'choice_label' => 'name',
            'expanded' => false,
            'multiple' => false]);
        $form->add('taskUsers', 'entity', [
            'label' => 'Wybierz użytkownika: ',
            'class' => 'TaskBundle\Entity\User',
            'choice_label' => 'username',
            'expanded' => true,
            'multiple' => true]);
        $form->add('project', 'entity', [
            'label' => 'Wybierz projekt: ',
            'class' => 'TaskBundle\Entity\Project',
            'choice_label' => 'title',
            'expanded' => false,
            'multiple' => false,
            'required' => false]);
        $form->add('due_date', 'datetime', ['label' => 'Podaj termin realizacji: ', 'required' => false]);
        $form->add('save', 'submit', ['label' => 'Zapisz']);
        $form->setAction($action);
        $taskForm = $form->getForm();

        return $taskForm;
    }
    private function commentForm($comment, $action){
        $form = $this->createFormBuilder($comment);
        $form->add('description', 'textarea', ['label' => 'Komentarz: ']);
        $form->add('save', 'submit', ['label' => 'Zapisz']);
        $form->setAction($action);
        $commentForm = $form->getForm();

        return $commentForm;
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
     * @Method("POST")
     */
    public function createTaskAction(Request $req){

        $task = new Task();
        $owner = $this->getUser();
        $task->setTaskOwner($owner);
        $create_date = date("Y-m-d H:i:s");
        $task->setCreateDate(new \DateTime($create_date));

        $taskForm = $this->taskForm($task, $this->generateUrl('createTask'));
        $taskForm->handleRequest($req);

        $status = $taskForm->get('taskStatus')->getData();

        if ($taskForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $task->setTaskStatus($status);
            $status->addTask($task);
            $em->persist($task);
            $em->flush();
        }

        return $this->redirectToRoute('main');
    }

    /**
     * @Route ("/", name="main")
     * @Template("TaskBundle:Task:allTask.html.twig")
     *
     */
    public function allActiveTasksAction(){
        $user = $this->getUser();
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task');

        $tasks = $repo->findAllTasksWithActiveStatus($repo->findAllTasksByDueDate($user));

        return ['tasks' => $tasks];
    }
    /**
     * @Route ("/archive/task", name="archiveTask")
     * @Template("TaskBundle:Task:allArchiveTask.html.twig")
     *
     */
    public function allNotActiveTasksAction(){
        $user = $this->getUser();
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task');

        $tasks = $repo->findAllTasksNotActiveStatus($repo->findAllTasksByDueDate($user));

        return ['tasks' => $tasks];
    }
    /**
     * @Route("/task/{id}/{status}", name="showTask", defaults={"status" = null})
     * @Template("TaskBundle:Task:oneTask.html.twig")
     */
    public function showTaskAction(Request $req, $id, $status){
        // Pobranie zadanie
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task');
        $task = $repo->find($id);

        // Opcja komentarzy
        $comment = new Comment();
        $commentForm = $this->commentForm($comment, $this->generateUrl('showTask', ['id' => $id]));
        $commentForm->createView();

        $comment->setTask($task);
        $user = $this->getUser();
        $comment->setLogUser($user);

        $commentForm->handleRequest($req);

        if ($commentForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
        }

        $repo2 = $this->getDoctrine()->getRepository('TaskBundle:Comment');
        $comments = $repo2->findByTask($id);

        // Wykonanie zadanie
        if($status != null){
            $repo3 = $this->getDoctrine()->getRepository('TaskBundle:Task_Status');
            $taskStatus = $repo3->find($status);

            $task->setTaskStatus($taskStatus);
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
        }

        return['task' => $task, 'comment' => $commentForm->createView(), 'comments' => $comments];
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

// ARCHIWUM - zadań zrealizowanych
}
