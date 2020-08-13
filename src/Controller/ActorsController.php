<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Actors;
use App\Form\ActorsCreateType;
use App\Form\ActorsEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ActorsController extends AbstractController
{
    /**
     * @Route("/", name="actors")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $actors = $em->getRepository(Actors::class)->findAll();

        return $this->render('actors/index.html.twig', [
            'actors' => $actors,
        ]);
    }

    /**
     * @Route("/actors/create", name="actorsCreate")
     */
    public function ActorsCreate(Request $request)
    {

        $actors = new Actors();

        $form = $this->createForm(ActorsCreateType::class , $actors);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($actors);
            $em->flush();
            return $this->redirectToRoute('actors');
        }
        return $this->render('actors/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/actors/edit/{id}", name="actorsEdit")
     */
    public function ActorsEdit(Actors $actors ,Request $request , EntityManagerInterface $em, int $id)
    {

        $form = $this->createForm(ActorsEditType::class, $actors);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($actors);
            $em->flush();
            $this->addFlash('success', 'actors Updated! Inaccuracies squashed!');
            return $this->redirectToRoute('actors');
        }

        return $this->render('actors/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
}
