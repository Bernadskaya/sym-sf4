<?php

namespace Ant\WebBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ant\WebBundle\Entity\News;
//use Ant\WebBundle\Entity\NewsRepository;

/**
 * News controller.
 *
 */
class NewsController extends Controller
{

    /**
     * Lists all News entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AntWebBundle:News')->findAll();


        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );

        return $this->render('AntWebBundle:News:index.html.twig', array(
            'entities' => $entities,
            'pagination' => $pagination
        ));
    }

    /**
     * Finds and displays a News entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AntWebBundle:News')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }
        return $this->render('AntWebBundle:News:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /*
     * Find and display other News
     */

    public function otherAction($id) {
        $em = $this->getDoctrine()->getManager();
        $otherNews = $em->getRepository('AntWebBundle:News')->findOther($id);
        return $this->render('AntWebBundle:News:other.html.twig', array(
            'otherNews' => $otherNews,
        ));
    }
}
