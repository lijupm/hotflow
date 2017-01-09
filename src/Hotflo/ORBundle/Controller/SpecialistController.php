<?php

namespace Hotflo\ORBundle\Controller;

use Hotflo\ORBundle\Helper\MessageTrait;
use Hotflo\ORBundle\Entity\Specialist;
use Hotflo\ORBundle\Service\SpecialistService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Specialist controller.
 *
 * @Route("specialists")
 */
class SpecialistController extends Controller
{
    use MessageTrait;

    /**
     * @DI\Inject("hotflo.service.specialist")
     * @var SpecialistService
     */
    private $specialistService;

    /**
     * Get overview of a specialist
     *
     * @param $specialistId
     * @Route("/{specialistId}/overview", name="specialist_overview")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function overviewAction($specialistId)
    {
        $specialist = $this->specialistService->getSpecialistById($specialistId);
        $sessions = $this->specialistService->getSessions($specialistId);

        return $this->render('specialist/overview.html.twig', [
            'specialist' => $specialist,
            'sessions'   => $sessions
        ]);
    }

    /**
     * Check availability of specialist
     *
     * @Route("/check_availability/{specialistId}", name="specialist_check_availability")
     */
    public function checkAvailabilityAction(Request $request, $specialistId = null)
    {
        $specialist = null;
        $availability = null;
        if (!is_null($specialistId)){
            $specialist = $this->specialistService->getSpecialistById($specialistId);
        }

        $form = $this->createForm('Hotflo\ORBundle\Form\SpecialistAvailabilityType', [], ['specialist' => $specialist]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $availability = $this->specialistService->checkAvailabilityInTimeslot(
                $form['specialist']->getData(),
                $form['startTime']->getData(),
                $form['endTime']->getData()
            );

            if (true === $availability){
                $this->addFlash(
                    'success_message',
                    $this->getConfigMessage('specialist_timeslot_available')
                );
            } else {
                $this->addFlash(
                    'failure_message',
                    $this->getConfigMessage('specialist_timeslot_not_available')
                );
            }
        }

        return $this->render('specialist/check_availability.html.twig', array(
            'form' => $form->createView(),
            'availability' => $availability
        ));
    }

    /**
     * Lists all specialist entities.
     *
     * @Route("/", name="specialists_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $specialists = $em->getRepository('HotfloORBundle:Specialist')->findAll();

        return $this->render('specialist/index.html.twig', array(
            'specialists' => $specialists,
        ));
    }

    /**
     * Creates a new specialist entity.
     *
     * @Route("/new", name="specialists_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $specialist = new Specialist();
        $form = $this->createForm('Hotflo\ORBundle\Form\SpecialistType', $specialist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialistAdded = $this->specialistService->addNewSpecialist($specialist);
            $this->addFlash(
                $this->specialistService->getMessageType(),
                $this->specialistService->getMessage()
            );

            if (true === $specialistAdded) {
                return $this->redirectToRoute('specialists_show', array('id' => $specialist->getId()));
            }
        }

        return $this->render('specialist/new.html.twig', array(
            'specialist' => $specialist,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a specialist entity.
     *
     * @Route("/{id}", name="specialists_show")
     * @Method("GET")
     */
    public function showAction(Specialist $specialist)
    {
        $deleteForm = $this->createDeleteForm($specialist);

        return $this->render('specialist/show.html.twig', array(
            'specialist' => $specialist,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing specialist entity.
     *
     * @Route("/{id}/edit", name="specialists_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Specialist $specialist)
    {
        $deleteForm = $this->createDeleteForm($specialist);
        $editForm = $this->createForm('Hotflo\ORBundle\Form\SpecialistType', $specialist);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('specialists_edit', array('id' => $specialist->getId()));
        }

        return $this->render('specialist/edit.html.twig', array(
            'specialist' => $specialist,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a specialist entity.
     *
     * @Route("/{id}", name="specialists_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Specialist $specialist)
    {
        $form = $this->createDeleteForm($specialist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($specialist);
            $em->flush($specialist);
        }

        return $this->redirectToRoute('specialists_index');
    }

    /**
     * Creates a form to delete a specialist entity.
     *
     * @param Specialist $specialist The specialist entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Specialist $specialist)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('specialists_delete', array('id' => $specialist->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
