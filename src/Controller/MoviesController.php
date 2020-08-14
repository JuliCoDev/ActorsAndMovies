<?php

namespace App\Controller;

use App\Entity\Movies;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MoviesType;
use App\Form\MoviesEditType;
use Doctrine\ORM\EntityManagerInterface;

class MoviesController extends AbstractController
{
    /**
     * @Route("/movies", name="movies")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository(Movies::class)->findAll();

        return $this->render('movies/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("/movies/create", name="moviesCreate")
     */
    public function MoviesCreate(Request $request)
    {

        $movies = new Movies();

        $form = $this->createForm(MoviesType::class , $movies);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movies);
            $em->flush();
            return $this->redirectToRoute('movies');
        }
        return $this->render('movies/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/movies/edit/{id}", name="moviesEdit")
     */
    public function MoviesEdit(Movies $movies ,Request $request , EntityManagerInterface $em)
    {

        $form = $this->createForm(MoviesEditType::class, $movies);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($movies);
            $em->flush();
            $this->addFlash('success', 'Movies Updated!');
            return $this->redirectToRoute('movies');
        }

        return $this->render('movies/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
