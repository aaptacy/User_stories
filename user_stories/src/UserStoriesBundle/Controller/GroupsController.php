<?php

namespace UserStoriesBundle\Controller;

use UserStoriesBundle\Entity\Groups;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Group controller.
 *
 * @Route("groups")
 */
class GroupsController extends Controller
{
    /**
     * Lists all group entities.
     *
     * @Route("/", name="groups_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $groups = $em->getRepository('UserStoriesBundle:Groups')->findAll();

        return $this->render('groups/index.html.twig', array(
            'groups' => $groups,
        ));
    }

    /**
     * Creates a new group entity.
     *
     * @Route("/new", name="groups_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $group = new Groups();
        $form = $this->createForm('UserStoriesBundle\Form\GroupsType', $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('groups_show', array('id' => $group->getId()));
        }

        return $this->render('groups/new.html.twig', array(
            'group' => $group,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a group entity.
     *
     * @Route("/{id}", name="groups_show")
     * @Method("GET")
     */
    public function showAction(Groups $group)
    {
        $deleteForm = $this->createDeleteForm($group);

        return $this->render('groups/show.html.twig', array(
            'group' => $group,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing group entity.
     *
     * @Route("/{id}/modify", name="groups_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Groups $group)
    {
        $deleteForm = $this->createDeleteForm($group);
        $editForm = $this->createForm('UserStoriesBundle\Form\GroupsType', $group);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('groups_edit', array('id' => $group->getId()));
        }

        return $this->render('groups/edit.html.twig', array(
            'group' => $group,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a group entity.
     *
     * @Route("/{id}", name="groups_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Groups $group)
    {
        $form = $this->createDeleteForm($group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();
        }

        return $this->redirectToRoute('groups_index');
    }

    /**
     * Creates a form to delete a group entity.
     *
     * @param Groups $group The group entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Groups $group)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('groups_delete', array('id' => $group->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
