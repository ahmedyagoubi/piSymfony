<?php
namespace PartnershipBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Histogram;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ScatterChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Data;
use Doctrine\Common\Collections\ArrayCollection;
use PartnershipBundle\Entity\PartnerShipRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Ob\HighchartsBundle\Highcharts\Highchart;

/**
 * User controller.
 *
 * @Route("partenaires")
 */
class PartenaireController extends Controller
{

    /**
     * Lists all user entities.
     *
     * @Route("/partnerships", name="becomePartner")
     * @Method({"GET", "POST"})
     */
    public function becomePartnerPageAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('PartnershipBundle:CategoriePartenaire')->findAll();
        return $this->render('partenaire/becomePartner.html.twig', array(
            'categories' => $categories
        ));
    }


    /**
     * Lists all user entities.
     *
     * @Route("/becomePartner/{id}", name="choosePartnership")
     * @Method({"GET", "POST"})
     */
    public function becomePartnerAction(Request $request , int $id)
    {
        $userLogged = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $categorie = $em->getRepository('PartnershipBundle:CategoriePartenaire')->find($id);

        $requestPartenairships = new PartnerShipRequest();
        $requestPartenairships->setClient($userLogged);
        $requestPartenairships->setCategorie($categorie);

        $em->persist($requestPartenairships);
        $em->flush();
        return $this->redirectToRoute('homepage');
    }


    /**
     * Lists all user entities.
     *
     * @Route("/statClients", name="statistiques_clients")
     * @Method({"GET", "POST"})
     */
    public function chartAction()
    {
        $em = $this->getDoctrine()->getManager();
        $partenaires = array();
        $clients = array();

        $allClients = $em->getRepository('PartnershipBundle:Client')->findAll();
        $histo = new Histogram();
        $scatter = new ScatterChart();

        $data = array();
        array_push($data, ['Nom clients', 'Pts fidélité']);
        foreach ($allClients as $cat) {
            array_push($data, [$cat->getNom(), $cat->getPtFidelite()]);
        }
        $histo->getData()->setArrayToDataTable($data);

        $histo->getOptions()->setTitle('Points de fidelité par client');
        $histo->getOptions()->setWidth(900);
        $histo->getOptions()->setHeight(500);
        $histo->getOptions()->getLegend()->setPosition('none');
        $histo->getOptions()->setColors(['green']);

        $scatter->getData()->setArrayToDataTable($data);
        $scatter->getOptions()->setTitle('Client vs. Pts fidelité');
        $scatter->getOptions()->getHAxis()->setTitle('User');
        $scatter->getOptions()->getHAxis()->setMinValue(0);
        $scatter->getOptions()->getHAxis()->setMaxValue(15);
        $scatter->getOptions()->getVAxis()->setTitle('Pts fidélité');
        $scatter->getOptions()->getVAxis()->setMinValue(0);
        $scatter->getOptions()->getVAxis()->setMaxValue(15);
        $scatter->getOptions()->getLegend()->setPosition('none');


        return $this->render('partenaire/statistiquesPartenaires.html.twig', array(
            'histo' => $histo,
            'scatter' => $scatter,
        ));
    }

    /**
     *
     * @Route("/statCategorie", name="statistiques_partenaires")
     * @Method("GET")
     */
    public function statClientAction(Request $request)
    {
        $pieChart = new PieChart();
        $em = $this->getDoctrine()->getManager();
        $allCategories = $em->getRepository('PartnershipBundle:CategoriePartenaire')->findAll();
        $data = array();
        array_push($data, ['Libelle', 'Nombre de partenaires']);
        foreach ($allCategories as $cat) {
            array_push($data, [$cat->getLibelle(), count($cat->getPartenaires())]);
        }
        $pieChart->getData()->setArrayToDataTable($data);
        $pieChart->getOptions()->setTitle('Nombre de partenaires par catégorie de partenariat');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('categoriePartenaire/statCategorie.twig', array(
            'piechart' => $pieChart
        ));

    }


}