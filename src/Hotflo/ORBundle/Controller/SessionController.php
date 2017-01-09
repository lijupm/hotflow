<?php

namespace Hotflo\ORBundle\Controller;

use Hotflo\ORBundle\Entity\Session;
use Hotflo\ORBundle\Service\SessionService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Session controller.
 *
 * @Route("sessions")
 */
class SessionController extends Controller
{
    /**
     * @DI\Inject("hotflo.service.session")
     * @var SessionService
     */
    private $sessionService;

    /**
     * Lists all session entities.
     *
     * @Route("/", name="sessions_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sessions = $em->getRepository('HotfloORBundle:Session')->findAll();

        return $this->render('session/index.html.twig', array(
            'sessions' => $sessions,
        ));
    }

    /**
     * Creates a new session entity.
     *
     * @Route("/new", name="sessions_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $session = new Session();
        $form = $this->createForm('Hotflo\ORBundle\Form\SessionType', $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionAdded = $this->sessionService->addNewSession($session);
            $this->addFlash(
                $this->sessionService->getMessageType(),
                $this->sessionService->getMessage()
            );
            if (true === $sessionAdded) {
                return $this->redirectToRoute('sessions_show', array('id' => $session->getId()));
            }
        }

        return $this->render('session/new.html.twig', array(
            'session' => $session,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a session entity.
     *
     * @Route("/{id}", name="sessions_show")
     * @Method("GET")
     */
    public function showAction(Session $session)
    {
        $deleteForm = $this->createDeleteForm($session);

        return $this->render('session/show.html.twig', array(
            'session' => $session,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing session entity.
     *
     * @Route("/{id}/edit", name="sessions_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Session $session)
    {
        $deleteForm = $this->createDeleteForm($session);
        $editForm = $this->createForm('Hotflo\ORBundle\Form\SessionType', $session);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sessions_edit', array('id' => $session->getId()));
        }

        return $this->render('session/edit.html.twig', array(
            'session' => $session,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a session entity.
     *
     * @Route("/{id}", name="sessions_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Session $session)
    {
        $form = $this->createDeleteForm($session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($session);
            $em->flush($session);
        }

        return $this->redirectToRoute('sessions_index');
    }

    /**
     * Creates a form to delete a session entity.
     *
     * @param Session $session The session entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Session $session)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sessions_delete', array('id' => $session->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
