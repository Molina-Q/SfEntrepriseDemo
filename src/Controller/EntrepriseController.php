<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    // grace au param converter cette methode sera retrouvé 
    #[Route('/entreprise/{id}', name: 'details_entreprise')]
    public function details(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/details.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }
}
