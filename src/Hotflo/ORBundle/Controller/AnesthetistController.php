<?php

namespace Hotflo\ORBundle\Controller;

use Hotflo\ORBundle\Entity\Anesthetist;
use Hotflo\ORBundle\Service\AnesthetistService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Anesthetist controller.
 *
 * @Route("anesthetists")
 */
class AnesthetistController extends Controller
{
    /**
     * @DI\Inject("hotflo.service.anesthetist")
     * @var AnesthetistService
     */
    private $anesthetistService;

    /**
     * Lists all anesthetist entities.
     *
     * @Route("/", name="anesthetists_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $anesthetists = $em->getRepository('HotfloORBundle:Anesthetist')->findAll();

        return $this->render('anesthetist/index.html.twig', array(
            'anesthetists' => $anesthetists,
        ));
    }

    /**
     * Creates a new anesthetist entity.
     *
     * @Route("/new", name="anesthetists_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $anesthetist = new Anesthetist();
        $form = $this->createForm('Hotflo\ORBundle\Form\AnesthetistType', $anesthetist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $anesthetistAdded = $this->anesthetistService->addNewAnesthetist($anesthetist);
            $this->addFlash(
                $this->anesthetistService->getMessageType(),
                $this->anesthetistService->getMessage()
            );
            if (true == $anesthetistAdded) {
                return $this->redirectToRoute('anesthetists_show', array('id' => $anesthetist->getId()));
            }
        }

        return $this->render('anesthetist/new.html.twig', array(
            'anesthetist' => $anesthetist,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a anesthetist entity.
     *
     * @Route("/{id}", name="anesthetists_show")
     * @Method("GET")
     */
    public function showAction(Anesthetist $anesthetist)
    {
        $deleteForm = $this->createDeleteForm($anesthetist);

        return $this->render('anesthetist/show.html.twig', array(
            'anesthetist' => $anesthetist,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing anesthetist entity.
     *
     * @Route("/{id}/edit", name="anesthetists_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Anesthetist $anesthetist)
    {
        $deleteForm = $this->createDeleteForm($anesthetist);
        $editForm = $this->createForm('Hotflo\ORBundle\Form\AnesthetistType', $anesthetist);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('anesthetists_edit', array('id' => $anesthetist->getId()));
        }

        return $this->render('anesthetist/edit.html.twig', array(
            'anesthetist' => $anesthetist,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a anesthetist entity.
     *
     * @Route("/{id}", name="anesthetists_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Anesthetist $anesthetist)
    {
        $form = $this->createDeleteForm($anesthetist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($anesthetist);
            $em->flush($anesthetist);
        }

        return $this->redirectToRoute('anesthetists_index');
    }

    /**
     * Creates a form to delete a anesthetist entity.
     *
     * @param Anesthetist $anesthetist The anesthetist entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Anesthetist $anesthetist)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('anesthetists_delete', array('id' => $anesthetist->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
