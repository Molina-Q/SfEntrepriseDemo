<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {

        $entreprises = $entrepriseRepository->findBy([], ["raisonSociale" => "ASC"]);
        return $this->render('entreprise/index.html.twig', [
            'controller_name' => 'EntrepriseController',
            'entreprises' => $entreprises,
        ]);
    }

    #[Route('/entreprise/new', name: 'new_entreprise')]
    #[Route('/entreprise/{id}/edit', name: 'edit_entreprise')]
    public function new_edit(Entreprise $entreprise = null, Request $request, EntityManagerInterface $entityManager): Response
    {

        if(!$entreprise) {
            $entreprise = new Entreprise();
        }

        $form = $this->createForm(EntrepriseType::class, $entreprise);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            // $form->getData() holds the submitted data
            // but, the original $entreprise is also updated
            $entreprise = $form->getData();

            // equivalent de prepare() en php natif / PDO
            $entityManager->persist($entreprise);

            // equivalent de execute() en php natif / PDO
            $entityManager->flush();

            return $this->redirectToRoute('app_entreprise');
        }

        return $this->render('entreprise/new.html.twig', [
            'formAddEntreprise' => $form,
            'edit' => $entreprise->getId()
        ]);
    }

    #[Route('/entreprise/{id}/delete', name: 'delete_entreprise')]
    public function delete(Entreprise $entreprise, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($entreprise);
        $entityManager->flush();
        return $this->redirectToRoute('app_entreprise');
    }
    
    // grace au param converter cette methode sera retrouvé 
    #[Route('/entreprise/{id}', name: 'details_entreprise')]
    public function details(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/details.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }
}
