<?php

namespace PartnershipBundle\Controller;


use PartnershipBundle\Entity\CategoriePartenaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Finder\Exception\AccessDeniedException;


/**
 * User controller.
 *
 * @Route("categoriePartenaires")
 */
class CategoriePartenaireController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="categorie_partenaire_index")
     * @Method("GET")
     */
    public function indexCategoriePartenairesAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        $em = $this->getDoctrine()->getManager();

        $categoriesPartenaires = $em->getRepository('PartnershipBundle:CategoriePartenaire')->findAll();

        return $this->render('categoriePartenaire/index.html.twig', array(
            'categoriesPartenaires' => $categoriesPartenaires,
        ));
    }
    /**
     * Finds and displays a user entity.
     *
     * @Route("/new", name="categorie_partenaire_new")
     */
    public function newAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!",
                Response::HTTP_FORBIDDEN);
        }
        $cat = new CategoriePartenaire();
        $form = $this->createForm('PartnershipBundle\Form\CategoriePartenaireType', $cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cat);
            $em->flush();

            return $this->redirectToRoute('categorie_partenaire_index');
        }

        return $this->render('categoriePartenaire/new.html.twig', array(
            'cat' => $cat,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="categorie_partenaire_show")
     * @Method("GET")
     */
    public function showAction(Request $request, CategoriePartenaire $cat)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        $userLogged = $this->get('security.token_storage')->getToken()->getUser();
        $editForm = $this->createForm('PartnershipBundle\Form\CategoriePartenaireType', $cat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_partenaire_show', array('id' => $cat->getId()));
        }

        return $this->render('categoriePartenaire/show.html.twig', array(
            'edit_form' => $editForm->createView(),
            'c' => $cat,
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/edit/{id}", name="categorie_partenaire_edit")
     * @Method("GET")
     */
    public function editAction(Request $request, CategoriePartenaire $cat)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        $editForm = $this->createForm('PartnershipBundle\Form\CategoriePartenaireType', $cat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_partenaire_show', array('id' => $cat->getId()));
        }

        return $this->render('categoriePartenaire/edit.html.twig', array(
            'user' => $cat,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/deleteCategorie/{id}", name="categorie_partenaire_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('PartnershipBundle:CategoriePartenaire')->find($id);
        $em->remove($cat);
        $em->flush();

        return $this->redirectToRoute('categorie_partenaire_index');
    }




}