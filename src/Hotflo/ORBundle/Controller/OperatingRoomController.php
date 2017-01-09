<?php

namespace Hotflo\ORBundle\Controller;

use Hotflo\ORBundle\Entity\OperatingRoom;
use Hotflo\ORBundle\Service\OperatingRoomService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Operatingroom controller.
 *
 * @Route("operating_rooms")
 */
class OperatingRoomController extends Controller
{
    /**
     * @DI\Inject("hotflo.service.operating_room")
     * @var OperatingRoomService
     */
    private $operatingRoomService;

    /**
     * Get Overview of an operating room
     *
     * @Route("/{operatingRoomId}/overview", name="operating_room_overview")
     * @Method("GET")
     * @param $operatingRoomId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function overviewAction($operatingRoomId)
    {
        $operatingRoom = $this->operatingRoomService->getOperatingRoomById($operatingRoomId);
        $sessions = $this->operatingRoomService->getSessions($operatingRoomId);

        return $this->render('operatingroom/overview.html.twig', [
            'operatingRoom' => $operatingRoom,
            'sessions'      => $sessions
        ]);
    }

    /**
     * Lists all operatingRoom entities.
     *
     * @Route("/", name="operating_rooms_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $operatingRooms = $em->getRepository('HotfloORBundle:OperatingRoom')->findAll();

        return $this->render('operatingroom/index.html.twig', array(
            'operatingRooms' => $operatingRooms,
        ));
    }

    /**
     * Creates a new operatingRoom entity.
     *
     * @Route("/new", name="operating_rooms_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $operatingRoom = new Operatingroom();
        $form = $this->createForm('Hotflo\ORBundle\Form\OperatingRoomType', $operatingRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $operatingRoomAdded = $this->operatingRoomService->addNewOperatingRoom($operatingRoom);
            $this->addFlash(
                    $this->operatingRoomService->getMessageType(),
                    $this->operatingRoomService->getMessage()
            );

            if (true === $operatingRoomAdded){
                return $this->redirectToRoute('operating_rooms_show', array('id' => $operatingRoom->getId()));
            }
        }

        return $this->render('operatingroom/new.html.twig', array(
            'operatingRoom' => $operatingRoom,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a operatingRoom entity.
     *
     * @Route("/{id}", name="operating_rooms_show")
     * @Method("GET")
     * @param OperatingRoom $operatingRoom
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(OperatingRoom $operatingRoom)
    {
        $deleteForm = $this->createDeleteForm($operatingRoom);

        return $this->render('operatingroom/show.html.twig', array(
            'operatingRoom' => $operatingRoom,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing operatingRoom entity.
     *
     * @Route("/{id}/edit", name="operating_rooms_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, OperatingRoom $operatingRoom)
    {
        $deleteForm = $this->createDeleteForm($operatingRoom);
        $editForm = $this->createForm('Hotflo\ORBundle\Form\OperatingRoomType', $operatingRoom);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operating_rooms_edit', array('id' => $operatingRoom->getId()));
        }

        return $this->render('operatingroom/edit.html.twig', array(
            'operatingRoom' => $operatingRoom,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a operatingRoom entity.
     *
     * @Route("/{id}", name="operating_rooms_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, OperatingRoom $operatingRoom)
    {
        $form = $this->createDeleteForm($operatingRoom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($operatingRoom);
            $em->flush($operatingRoom);
        }

        return $this->redirectToRoute('operating_rooms_index');
    }

    /**
     * Creates a form to delete a operatingRoom entity.
     *
     * @param OperatingRoom $operatingRoom The operatingRoom entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OperatingRoom $operatingRoom)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('operating_rooms_delete', array('id' => $operatingRoom->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
