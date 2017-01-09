<?php

namespace Hotflo\ORBundle\Controller;

use Hotflo\ORBundle\Entity\Hospital;
use Hotflo\ORBundle\Service\HospitalService as HospitalService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Hospital controller.
 *
 * @Route("hospitals")
 */
class HospitalController extends Controller
{
    /**
     * @var HospitalService
     *
     * @DI\Inject("hotflo.service.hospital")
     */
    private $hospitalService;

    /**
     * List Operation Rooms in the hospital
     *
     * @Route("/{hospitalHandle}/operating_rooms", name="list_hospital_operating_rooms")
     * @Method("GET")
     */
    public function listOperatingRoomsAction($hospitalHandle)
    {
        $operatingRooms = $this->hospitalService->getOperatingRooms($hospitalHandle);

        return $this->render('hospital/operating_rooms.html.twig', [
            'operatingRooms' => $operatingRooms
        ]);
    }

    /**
     * Lists all hospital entities.
     *
     * @Route("/", name="hospitals_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $hospitals = $em->getRepository('HotfloORBundle:Hospital')->findAll();

        return $this->render('hospital/index.html.twig', array(
            'hospitals' => $hospitals,
        ));
    }

    /**
     * Creates a new hospital entity.
     *
     * @Route("/new", name="hospitals_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $hospital = new Hospital();
        $form = $this->createForm('Hotflo\ORBundle\Form\HospitalType', $hospital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hospital);
            $em->flush($hospital);

            return $this->redirectToRoute('hospitals_show', array('id' => $hospital->getId()));
        }

        return $this->render('hospital/new.html.twig', array(
            'hospital' => $hospital,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a hospital entity.
     *
     * @Route("/{id}", name="hospitals_show")
     * @Method("GET")
     */
    public function showAction(Hospital $hospital)
    {
        $deleteForm = $this->createDeleteForm($hospital);

        return $this->render('hospital/show.html.twig', array(
            'hospital' => $hospital,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing hospital entity.
     *
     * @Route("/{id}/edit", name="hospitals_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Hospital $hospital)
    {
        $deleteForm = $this->createDeleteForm($hospital);
        $editForm = $this->createForm('Hotflo\ORBundle\Form\HospitalType', $hospital);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hospitals_edit', array('id' => $hospital->getId()));
        }

        return $this->render('hospital/edit.html.twig', array(
            'hospital' => $hospital,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hospital entity.
     *
     * @Route("/{id}", name="hospitals_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Hospital $hospital)
    {
        $form = $this->createDeleteForm($hospital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hospital);
            $em->flush($hospital);
        }

        return $this->redirectToRoute('hospitals_index');
    }

    /**
     * Creates a form to delete a hospital entity.
     *
     * @param Hospital $hospital The hospital entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hospital $hospital)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hospitals_delete', array('id' => $hospital->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
