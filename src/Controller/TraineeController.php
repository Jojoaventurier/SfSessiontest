<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TraineeController extends AbstractController
{
    #[Route('/stagiaire', name: 'app_trainee')]
    public function index(EntityManager $entityManager): Response
    {
        $trainees = $entityManager->getRepository(Trainee::class)->findAll();
        return $this->render('trainee/index.html.twig', [
            'trainees' => $trainees,
        ]);
    }
}
