<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProgramController extends AbstractController
{
    #[Route('/program/session/{id}', name: 'app_program')]
    public function index(Session $session, ProgramRepository $programRepository): Response
    {   
        $session_id = $session->getId();
        
        $program = $programRepository->findBy($session_id);

        return $this->render('program/index.html.twig', [
            'program' => $program,
        ]);
    }
}
