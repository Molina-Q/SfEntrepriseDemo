<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Employe;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    public function index(EmployeRepository $employeRepository): Response
    {

        // $entreprises = $entityManager->getRepository(Entreprise::class)->findAll();
        $employes = $employeRepository->findBy([], ["nom" => "ASC"]);
        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
        ]);
    }

    // grace au param converter cette methode sera retrouvé 
    #[Route('/employe/{id}', name: 'details_employe')]
    public function details(Employe $employe): Response
    {
        return $this->render('employe/details.html.twig', [
            'employe' => $employe,
        ]);
    }
}
