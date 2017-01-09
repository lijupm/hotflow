<?php

namespace Hotflo\ORBundle\Controller;

use Hotflo\ORBundle\Entity\Specialism;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Specialism controller.
 *
 * @Route("specialisms")
 */
class SpecialismController extends Controller
{
    /**
     * Lists all specialism entities.
     *
     * @Route("/", name="specialisms_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $specialisms = $em->getRepository('HotfloORBundle:Specialism')->findAll();

        return $this->render('specialism/index.html.twig', array(
            'specialisms' => $specialisms,
        ));
    }

    /**
     * Creates a new specialism entity.
     *
     * @Route("/new", name="specialisms_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $specialism = new Specialism();
        $form = $this->createForm('Hotflo\ORBundle\Form\SpecialismType', $specialism);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($specialism);
            $em->flush($specialism);

            return $this->redirectToRoute('specialisms_show', array('id' => $specialism->getId()));
        }

        return $this->render('specialism/new.html.twig', array(
            'specialism' => $specialism,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a specialism entity.
     *
     * @Route("/{id}", name="specialisms_show")
     * @Method("GET")
     */
    public function showAction(Specialism $specialism)
    {
        $deleteForm = $this->createDeleteForm($specialism);

        return $this->render('specialism/show.html.twig', array(
            'specialism' => $specialism,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing specialism entity.
     *
     * @Route("/{id}/edit", name="specialisms_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Specialism $specialism)
    {
        $deleteForm = $this->createDeleteForm($specialism);
        $editForm = $this->createForm('Hotflo\ORBundle\Form\SpecialismType', $specialism);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('specialisms_edit', array('id' => $specialism->getId()));
        }

        return $this->render('specialism/edit.html.twig', array(
            'specialism' => $specialism,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a specialism entity.
     *
     * @Route("/{id}", name="specialisms_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Specialism $specialism)
    {
        $form = $this->createDeleteForm($specialism);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($specialism);
            $em->flush($specialism);
        }

        return $this->redirectToRoute('specialisms_index');
    }

    /**
     * Creates a form to delete a specialism entity.
     *
     * @param Specialism $specialism The specialism entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Specialism $specialism)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('specialisms_delete', array('id' => $specialism->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
