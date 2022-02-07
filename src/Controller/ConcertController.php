<?php

namespace App\Controller;

use App\Entity\Concert;
use App\Entity\Member;
use App\Form\ConcertType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcertController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $allConcerts = $this->getDoctrine()->getRepository(Concert::class)->findAll();
        $nextConcerts = array();

        $currentDate = new DateTime('now');

        foreach($allConcerts as $concert){
            if($concert->getDate()> $currentDate){
                $pastConcerts[$concert->getDate()->format("Y")][]=$concert;
            }
        }

        return $this->render('concert/index.html.twig', [
            'concerts' => $pastConcerts,
        ]);
    }


    /**
     * Affiche une liste de concerts
     *
     * @return Response
     *
     * @Route("/concerts", name="list_concerts")
     * @isGranted("ROLE_ADMIN")
     */
    public function list(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Concert::class);

        try{
            $results = $repository->findAll();
        }
        catch(\Exception $e)
        {
            dump($e); die;
        }

        return $this->render('admin/listConcert.html.twig', [
            'concerts' => $results
            ]
        );
    }


    /**
     * Affiche une liste de concerts
     *
     * @return Response
     *
     * @Route("/list", name="concerts_list")
     */
    public function next(): Response
    {
        //$repository = $this->getDoctrine()->getRepository(Concert::class);

        try{
            // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
            $results = $this->getDoctrine()->getRepository(Concert::class)->findBy([],['date' => 'desc']);
        }
        catch(\Exception $e)
        {
            dump($e); die;
        }

        return $this->render('concert/next.html.twig', [
            'concerts' => $results
            ]
        );
    }



    /**
     * Crée un nouveau concert
     *
     * @Route("/concert/create", name="concert_create")
     * @isGranted("ROLE_ADMIN")
     * 
     */
    public function createConcert(Request $request): Response
    {
        $concert = new Concert();

        $form = $this->createForm(ConcertType::class, $concert);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $concert = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($concert);
             $entityManager->flush();

            $this->addFlash('success', 'Concert crée! Music is power!');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('concert/new.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Update un concert
     *
     * @Route("/concert/edit/{id}", name="concert_edit")
     * @isGranted("ROLE_ADMIN")
     *
     */
    public function editConcert(Request $request, Concert $concert): Response
    {
        $form = $this->createForm(ConcertType::class, $concert);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $show = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($concert);
            $entityManager->flush();

            $this->addFlash('success', 'Concert update! Music is power!');
            return $this->redirectToRoute('list_concerts');
        }

        return $this->render('concert/new.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param Concert $concert
     *
     * @Route("/concert/delete/{id}", name="concert_delete")
     * @isGranted("ROLE_ADMIN")
     * 
     */
    public function delete(Request $request, Concert $concert): Response
    {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($concert);
                $entityManager->flush();

            return $this->redirectToRoute('list_concerts');
    }
}
