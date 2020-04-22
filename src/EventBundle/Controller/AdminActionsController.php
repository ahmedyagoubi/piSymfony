<?php

namespace EventBundle\Controller;


use PartnershipBundle\Entity\CategoriePartenaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Finder\Exception\AccessDeniedException;



class AdminActionsController extends Controller
{


    public function indexEventsAction()
    { #ahmed
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }

        $evenements = $this->getDoctrine()->getRepository('EventBundle:Evenement')->findAll();

        return $this->render('@Event/admin/index.html.twig', array(
            'events' => $evenements,
        ));
    }


    public function deleteAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }

        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EventBundle:Evenement')->find($id);
        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('evenement_admin_index');
    }


}