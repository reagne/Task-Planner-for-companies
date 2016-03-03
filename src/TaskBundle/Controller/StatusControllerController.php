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
     * @Route("task/addStatus", name="addStatusT")
     * @Template("TaskBundle:Task:newStatus.html.twig")
     */
    public function newStatusAction(){
        $status = new Task_Status();
        $statusForm = $this->statusForm($status,$this->generateUrl('createStatusT'));

        return['status' => $statusForm->createView()];
    }
    /**
     * @Route("task/createStatus", name="createStatusT")
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
     * @Route ("task/status", name="allStatusT")
     * @Template("TaskBundle:Task:allStatus.html.twig")
     *
     */
    public function allStatusAction(){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Task_Status');
        $statuses = $repo->findAll();

        return ['statuses' => $statuses];
    }
    /**
     * @Route("task/status/{id}", name="statusToEditT")
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
     * @Route("task/status/{id}", name="editStatusT")
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
     * @Route("task/status/{id}/remove", name="removeStatusT")
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
     * @Route("project/addStatus", name="addStatusP")
     * @Template("TaskBundle:Project:newStatus.html.twig")
     */
    public function newProjectStatusAction(){
        $status = new project_Status();
        $statusForm = $this->statusForm($status,$this->generateUrl('createStatusP'));

        return['status' => $statusForm->createView()];
    }
    /**
     * @Route("project/createStatus", name="createStatusP")
     */
    public function createProjectStatusAction(Request $req){
        $status = new project_Status();
        $statusForm = $this->statusForm($status, $this->generateUrl('createProjectStatus'));
        $statusForm->handleRequest($req);

        if ($statusForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($status);
            $em->flush();
        }

        return $this->redirectToRoute('allStatusP');
    }
    /**
     * @Route ("project/status", name="allStatusP")
     * @Template("TaskBundle:Project:allStatus.html.twig")
     *
     */
    public function allProjectStatusAction(){
        $repo = $this->getDoctrine()->getRepository('TaskBundle:Project_Status');
        $statuses = $repo->findAll();

        return ['statuses' => $statuses];
    }
    /**
     * @Route("project/status/{id}", name="statusToEditP")
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
     * @Route("project/status/{id}", name="editStatusP")
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
     * @Route("project/status/{id}/remove", name="removeStatus")
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
