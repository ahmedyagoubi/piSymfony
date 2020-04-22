<?php
namespace PartnershipBundle\Controller;

use PartnershipBundle\Entity\Client;
use PartnershipBundle\Entity\PartnerShipRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Ob\HighchartsBundle\Highcharts\Highchart;

/**
 * User controller.
 *
 * @Route("clients")
 */
class ClientController extends Controller
{

    /**
     * @Route("/new", name="client_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userLogged = $this->get('security.token_storage')->getToken()->getUser();
        $c  = new Client();
        $form = $this->createForm('PartnershipBundle\Form\ClientType', $c);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($c->getType() == 'Client') {$c->addRole('ROLE_CLIENT');}
            elseif ($c->getType() == 'Administrateur'){$c->addRole('ROLE_ADMIN');}
            elseif ($c->getType() == 'Partenaire'){
                $c->addRole('ROLE_PARTENAIRE');

            }
            $em->persist($c);
            $em->flush();
            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/new.html.twig', array(
            'c' => $c,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/partnerShips", name="partnerShips")
     * @Method("GET")
     */
    public function partnerShipsRequestAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $allReq = $em->getRepository('PartnershipBundle:PartnerShipRequest')->findBy(['status' => 'EN_COURS']);
        return $this->render('client/allRequests.html.twig', array(
            'allReq' => $allReq,
        ));

    }

    /**
     * Lists all user entities.
     *
     * @Route("/", name="client_index")
     * @Method("GET")
     */
    public function indexClientsAction()
    {
//        dump($this->get('security.token_storage')->getToken()->getUser());die;
        if (!$this->get('security.token_storage')->getToken()->getUser()->hasRole('ROLE_ADMIN')) {
            return $this->redirectToRoute('homepage');
        }
        $em = $this->getDoctrine()->getManager();
        $partenaires = array();
        $clients = array();

        $all = $em->getRepository('PartnershipBundle:Client')->findAll();

        foreach ($all as $user) {
            if ($user->hasRole("ROLE_PARTENAIRE")) {
                $partenaires[] = $user;
            }
            if ($user->hasRole("ROLE_CLIENT")) {
                $clients[] = $user;
            }
        }
        return $this->render('client/index.html.twig', array(
            'all' => $all,
            'clients' => $clients,
            'partenaires' => $partenaires,
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="client_show")
     * @Method("GET")
     */
    public function showAction(Request $request, Client $client)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        $userLogged = $this->get('security.token_storage')->getToken()->getUser();
        $editForm = $this->createForm('PartnershipBundle\Form\ClientType', $client);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_show', array('id' => $client->getId()));
        }
        return $this->render('client/show.html.twig', array(
            'edit_form' => $editForm->createView(),
            'client' => $client,
        ));
    }


    /**
     * Finds and displays a user entity.
     *
     * @Route("/confirme/{id}", name="client_confirme")
     * @Method("GET")
     */
    public function confirmeAction(Request $request, PartnerShipRequest $partnerShipRequest)
    {


        $em = $this->getDoctrine()->getManager();
        $partnerShipRequest->setStatus('CONFIRMED');

        $c = $partnerShipRequest->getClient();
        $c->addRole('ROLE_PARTENAIRE');

        $em->flush();


        // Your Account SID and Auth Token from twilio.com/console
        $sid = 'AC3847bf5ac1f9587a1eb630f6095feb80';
        $token = '72df07096a73e702fc7f09b0d4377028';
        $client = new \Twilio\Rest\Client($sid, $token);
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
        // the number you'd like to send the message to
            '+21620372156',
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '+12029526315',
                // the body of the text message you'd like to send
                'body' => 'Hello Mr (Mrs) '.$c->getNom() .', Votre demande de partenariat à etais accéptées !'
            )
        );
        return $this->redirectToRoute('partnerShips');
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/archiver/{id}", name="client_archiver")
     * @Method("GET")
     */
    public function archiverAction(Request $request, PartnerShipRequest $partnerShipRequest)
    {
        $em = $this->getDoctrine()->getManager();
        $partnerShipRequest->setStatus('ARCHIVED');
        $em->flush();

        return $this->redirectToRoute('partnerShips');
    }


    /**
     * Finds and displays a user entity.
     *
     * @Route("/edit/{id}", name="client_edit")
     * @Method("GET")
     */
    public function editAction(Request $request, int $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository('PartnershipBundle:Client')->find($id);

        $editForm = $this->createForm('PartnershipBundle\Form\ClientType', $p);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_show', array('id' => $p->getId()));
        }

        return $this->render('client/edit.html.twig', array(
            'p' => $p,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/delete/{id}", name="client_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Client $p)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($p);
        $em->flush();

        return $this->redirectToRoute('client_index');
    }


}