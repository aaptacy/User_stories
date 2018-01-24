<?php

namespace UserStoriesBundle\Controller;

use UserStoriesBundle\Entity\User;
use UserStoriesBundle\Entity\Address;
use UserStoriesBundle\Entity\Email;
use UserStoriesBundle\Entity\Phone;
use UserStoriesBundle\Entity\Groups;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('UserStoriesBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new/", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('UserStoriesBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

      /**
     *
     * @Route("/search/", name="user_searxh")
     * @Method("POST")
     */
    public function searchAction(Request $request, $id, User $user)
    {
        $address = new Address(); 
        $address->setUser($user);
        $form = $this->createForm('UserStoriesBundle\Form\AddressType', $address);
        $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();
         return $this->redirectToRoute('user_show', ['id' => $id]);
    }
    
    
    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction($id, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $em = $this->getDoctrine()->getManager();
       
        $userAddress = $em->getRepository('UserStoriesBundle:Address')->
                findByUser($id);
        
        $userEmail = $em->getRepository('UserStoriesBundle:Email')->
                        findByUser($user->getId());
        
        $userPhone = $em->getRepository('UserStoriesBundle:Phone')->
                        findByUser($user->getId());
        
        $userGroup = $user->getGroups();
       
        return $this->render('user/show.html.twig', 
                                    [
                                    'user' => $user,
                                    'addresses' => $userAddress,
                                    'emails'=> $userEmail,
                                    'phones' => $userPhone,
                                    'groups' => $userGroup,
                                    'delete_form' => $deleteForm->createView(),
                                    ]);
    }
    
     /**
     *
     * @Route("/{id}/addAddress", name="user_add_address")
     * @Method("POST")
     */
    public function addAddressAction(Request $request, $id, User $user)
    {
        $address = new Address(); 
        $address->setUser($user);
        $form = $this->createForm('UserStoriesBundle\Form\AddressType', $address);
        $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();
         return $this->redirectToRoute('user_show', ['id' => $id]);
    }

     /**
     *
     * @Route("/{id}/addEmail", name="user_add_email")
     * @Method("POST")
     */
    public function addEmailAction(Request $request, User $user, $id)
    {
        $email = new Email(); 
        $email->setUser($user);
        $form = $this->createForm('UserStoriesBundle\Form\EmailType', $email);
        $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $em->persist($email);
            $em->flush();
         return $this->redirectToRoute('user_show', ['id' => $id]);
    }
    
     /**
     *
     * @Route("/{id}/addPhone", name="user_add_phone")
     * @Method("POST")
     */
    public function addPhoneAction(Request $request, User $user, $id)
    {
        $phone = new Phone(); 
        $phone->setUser($user);
        $form = $this->createForm('UserStoriesBundle\Form\PhoneType', $phone);
        $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $em->persist($phone);
            $em->flush();
         return $this->redirectToRoute('user_show', ['id' => $id]);
    }
    
         /**
     *
     * @Route("/{id}/addGroup", name="user_add_group")
     * @Method("POST")
     */
    
        public function addGroupAction(Request $request, User $user, $id)
    {
        $group = new Groups(); 
        $group->addUser($user);
        $user->addGroup($group);
        $form = $this->createForm('UserStoriesBundle\Form\GroupsType', $group);
        $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();
            $user->addGroup($group);
         return $this->redirectToRoute('user_show', ['id' => $id]);
    }
    
    
    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/modify", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user, $id)
    {  
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('UserStoriesBundle\Form\UserType', $user);
        $editForm->handleRequest($request);
        
       
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_show', ['id' => $id]);
        }

        $address = new Address();
        $addressForm = $this->createForm('UserStoriesBundle\Form\AddressType', $address,
                ['action' => $this->generateUrl('user_add_address', ['id' => $id])]);
        
        $email = new Email();
        $emailForm = $this->createForm('UserStoriesBundle\Form\EmailType', $email,
                ['action' => $this->generateUrl('user_add_email', ['id' => $id])]);
        
        $phone = new Phone();
        $phoneForm = $this->createForm('UserStoriesBundle\Form\PhoneType', $phone,
                ['action' => $this->generateUrl('user_add_phone', ['id' => $id])]);
        
        $group = new Groups();
        $groupForm = $this->createForm('UserStoriesBundle\Form\GroupsType', $group,
                ['action' => $this->generateUrl('user_add_group', ['id' => $id])]);
        
       return $this->render('user/edit.html.twig', ['user' => $em->getRepository('UserStoriesBundle:User')->
                findOneById($id),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'address_form' => $addressForm->createView(),
            'email_form' => $emailForm->createView(),
            'phone_form' => $phoneForm->createView(),
            'group_form' => $groupForm->createView()
            ]);
    }
    
    

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
}
