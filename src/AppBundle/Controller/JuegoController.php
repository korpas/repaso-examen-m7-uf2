<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Juego;
use AppBundle\Form\JuegoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\HttpFoundation\Request;

class JuegoController extends Controller{
    /**
     * indexAction
     *
     * @Route(
     *     path="/juego_index",
     *     name="app_juego_index"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
{
    $m = $this->getDoctrine()->getManager();

    $repository = $m->getRepository('AppBundle:Juego');
    /**
     * @var Juego $juego
     */

    $juegos = $repository->findAll();
    return $this->render(':juego:index.html.twig',
        [
            'juegos' => $juegos,
        ]
    );
}

    /**
     * @Route("/juego_insert", name="app_juego_insert")
     */
    public function insertAction()
    {

        $juego = new Juego();
        $form = $this->createForm(JuegoType::class, $juego);
        return $this->render(':juego:insert.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_juego_do-insert')
            ]
        );
    }
    /**
     * @Route("/juego_do-insert", name="app_juego_do-insert")
     */
    public function doInsert(Request $request)
    {
        $juego = new Juego();
        $form = $this->createForm(JuegoType::class, $juego);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $m = $this->getDoctrine()->getManager();
            $m->persist($juego);
            $m->flush();
            $this->addFlash('messages', 'Juego añadido');
            return $this->redirectToRoute('app_juego_index');
        }
        $this->addFlash('messages', 'Review your form data');
        return $this->render(':juego:insert.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_juego_do-insert')
            ]
        );
    }
    /**
     * @Route("/juego_update/{id}", name="app_juego_update")
     */

    public function updateAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Juego');
        $juego = $repository->find($id);
        $form = $this->createForm(JuegoType::class, $juego);
        return $this->render(':juego:insert.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_juego_do-update', ['id' => $id])
            ]
        );
    }

/**
 * @Route("/juego_do-update/{id}", name="app_juego_do-update")
*
* @param Request $request
* @return \Symfony\Component\HttpFoundation\RedirectResponse
*/
    public function doUpdateAction($id, Request $request)
    {
        $m          = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Juego');
        $juego       = $repository->find($id);
        $form       = $this->createForm(JuegoType::class, $juego);
        // user is updated with incoming data
        $form->handleRequest($request);
        if ($form->isValid()) {
            $m->flush();
            $this->addFlash('messages', 'Juego Actualizado');
            return $this->redirectToRoute('app_juego_index');
        }
        $this->addFlash('messages', 'Review your form');
        return $this->render(':juego:insert.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_juego_index', ['id' => $id]),
            ]
        );
    }

    /**
     * We are using here param converters: https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html
     *
     * @Route("/juego_remove/{id}", name="app_juego_remove")
     * @ParamConverter(name="juego", class="AppBundle:Juego")
     */
    public function removeAction(Juego $juego)
    {
        $m = $this->getDoctrine()->getManager();
        $m->remove($juego);
        $m->flush();
        $this->addFlash('messages', 'Juego Eliminado');
        return $this->redirectToRoute('app_juego_index');
    }
}