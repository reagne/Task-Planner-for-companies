<?php

namespace TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use TaskBundle\Entity\Task_Status;
use TaskBundle\Entity\Project_Status;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusControllerController extends Controller
{
    private function statusForm($status, $action){
        $form = $this->createFormBuilder($status);
        $form->add('name', 'text', ['label' => 'Nazwa: ']);
        $form->add('save', 'submit', ['label' => 'Zapisz']);
        $form->setAction($action);
        $statusForm = $form->getForm();

        return $statusForm;
    }

//----------------- TASK STATUS -------------------------------------

    /**
     * @Route("addStatus/task", name="addStatusT")
     * @Template("TaskBundle:Task:newStatus.html.twig")
     */
    public function newStatusAction(){
        $status = new Task_Status();
        $statusForm = $this->statusForm($status,$this->generateUrl('createStatusT'));

        return['status' => $statusForm->createView()];
    }
    /**
     * @Route("createStatus/task", name="createStatusT")
     */
    public function createStatusAction(Request $req){
        $status = new Task_Status();
        $statusForm = $this->statusForm($status, $this->generateUrl('createStatusT'));
        $statusForm->handleRequest($req);

        if ($statusForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($status);
            $em->flush();
        }

        return $this->redirectToRoute('allStatusT');
    }
    /**
     * @Route ("status/task", name="allStatusT")
     * @Template("TaskBundle:Task:allStatus.html.twig")
     *
     */
    public function allStatusAction(){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task_Status');
        $statuses = $repo->findAll();

        return ['statuses' => $statuses];
    }
    /**
     * @Route("status/task/{id}", name="statusToEditT")
     * @Method("GET")
     * @Template("TaskBundle:Task:newStatus.html.twig")
     */
    public function statusToEditAction($id){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task_Status');
        $status = $repo->find($id);
        $statusForm = $this->statusForm($status, $this->generateUrl('editStatusT', ['id' => $id]));

        return['status' => $statusForm->createView()];
    }
    /**
     * @Route("status/task/{id}", name="editStatusT")
     * @Method("POST")
     */
    public function editStatusAction(Request $req, $id)
    {
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task_Status');
        $status = $repo->find($id);

        $statusForm = $this->statusForm($status, $this->generateUrl('editStatusT', ['id' => $id]));
        $statusForm->handleRequest($req);

        if ($statusForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->redirectToRoute('allStatusT');
    }
    /**
     * @Route("status/task/{id}/remove", name="removeStatusT")
     */
    public function removeStatusAction($id){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task_Status');
        $status = $repo->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($status);
        $em->flush();

        return $this->redirectToRoute('allStatusT');
    }

// ------------ PROJECT STATUS --------------------------------------------

    private function projectStatusForm($status, $action){
        $form = $this->createFormBuilder($status);
        $form->add('name', 'text', ['label' => 'Nazwa: ']);
        $form->add('save', 'submit', ['label' => 'Zapisz']);
        $form->setAction($action);
        $statusForm = $form->getForm();

        return $statusForm;
    }

    /**
     * @Route("addStatus/project", name="addStatusP")
     * @Template("TaskBundle:Project:newStatus.html.twig")
     */
    public function newProjectStatusAction(){
        $status = new project_Status();
        $statusForm = $this->statusForm($status,$this->generateUrl('createStatusP'));

        return['status' => $statusForm->createView()];
    }
    /**
     * @Route("createStatus/project", name="createStatusP")
     */
    public function createProjectStatusAction(Request $req){
        $status = new project_Status();
        $statusForm = $this->statusForm($status, $this->generateUrl('createStatusP'));
        $statusForm->handleRequest($req);

        if ($statusForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($status);
            $em->flush();
        }

        return $this->redirectToRoute('allStatusP');
    }
    /**
     * @Route ("status/project", name="allStatusP")
     * @Template("TaskBundle:Project:allStatus.html.twig")
     *
     */
    public function allProjectStatusAction(){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Project_Status');
        $statuses = $repo->findAll();

        return ['statuses' => $statuses];
    }
    /**
     * @Route("status/project/{id}", name="statusToEditP")
     * @Method("GET")
     * @Template("TaskBundle:Project:newStatus.html.twig")
     */
    public function statusProjectToEditAction($id){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Project_Status');
        $status = $repo->find($id);
        $statusForm = $this->statusForm($status, $this->generateUrl('editStatusP', ['id' => $id]));

        return['status' => $statusForm->createView()];
    }
    /**
     * @Route("status/project/{id}", name="editStatusP")
     * @Method("POST")
     */
    public function editProjectStatusAction(Request $req, $id)
    {
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Project_Status');
        $status = $repo->find($id);

        $statusForm = $this->statusForm($status, $this->generateUrl('editStatusP', ['id' => $id]));
        $statusForm->handleRequest($req);

        if ($statusForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->redirectToRoute('allStatusP');
    }
    /**
     * @Route("status/project/{id}/remove", name="removeStatusP")
     */
    public function removeProjectStatusAction($id){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Project_Status');
        $status = $repo->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($status);
        $em->flush();

        return $this->redirectToRoute('allStatusP');
    }
}
