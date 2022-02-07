<?php

namespace App\Controller;

use App\Entity\Band;
use App\Form\BandType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BandController extends AbstractController
{

      /**
     * Affiche une liste de bands
     *
     * @return Response
     *
     * @Route("/listbands", name="list_bands")
     * @isGranted("ROLE_ADMIN")
     */
    public function adminBands(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Band::class);

        try{
            $results = $repository->findAll();
        }
        catch(\Exception $e)
        {
            dump($e); die;
        }

        return $this->render('admin/listBand.html.twig', [
            'bands' => $results
            ]
        );
    }

    /**
     * Affiche une liste de groupe
     *
     * @return Response
     *
     * @Route("/bands", name="band_list")
     */
    public function bandsAll(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Band::class);
        $bands = $repository->findAll();

        return $this->render('band/list.html.twig', [
                'bands' => $bands
            ]
        );
    }

    /**
     * Affiche une liste de groupe
     *
     * @param int $id
     * @return Response
     *
     * @Route("/band/{id}", name="band_show")
     */
    public function list(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Band::class);

        return $this->render('band/band.html.twig', [
                'band' => $repository->find($id)
            ]
        );
    }


    /**
     * Crée un nouveau groupe
     *
     * @Route("/band/create", name="band_create")
     * @isGranted("ROLE_ADMIN")
     * 
     * 
     */
    public function createBand(Request $request): Response
    {
        $band = new Band();

        $form = $this->createForm(BandType::class, $band);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $band = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($band);
             $entityManager->flush();

            $this->addFlash('success', 'Groupe crée! Music is power!');
            return $this->redirectToRoute('band_list');
        }

        return $this->render('band/new.html.twig', [
                'form' => $form->createView()
            ]
        );
    }


    /**
     * Update un band
     *
     * @Route("/band/edit/{id}", name="band_edit")
     * @isGranted("ROLE_ADMIN")
     *
     */
    public function editBand(Request $request, Band $band): Response
    {
        $form = $this->createForm(BandType::class, $band);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $show = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($band);
            $entityManager->flush();

            $this->addFlash('success', 'Groupe update! Music is power!');
            return $this->redirectToRoute('band_list');
        }

        return $this->render('band/new.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param Band $band
     *
     * @Route("/band/delete/{id}", name="band_delete")
     * @isGranted("ROLE_ADMIN")
     * 
     */
    public function delete(Request $request, Band $band): Response
    {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($band);
                $entityManager->flush();

            return $this->redirectToRoute('band_list');
    }

}
