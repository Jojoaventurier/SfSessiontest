<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProgramController extends AbstractController
{
    #[Route('/program/session/{id}', name: 'edit_program')]
    public function edit(Session $session, ProgramRepository $programRepository): Response
    {   
        $form = $this->createForm(ProgramType::class);
        $programs = $programRepository->findBySession($session);

        return $this->render('program/edit.html.twig', [
            'programs' => $programs,
            'session' => $session,
            'formAddProgram' => $form
        ]);
    }
}
