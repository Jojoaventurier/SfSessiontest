<?php

namespace App\Controller;

use App\Entity\Unit;
use App\Entity\Session;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProgramController extends AbstractController
{
    // fonction pour éditer un programme affilié à une session spécifique 
    #[Route('/program/session/{id}', name: 'edit_program')]
    public function edit(Session $session, ProgramRepository $programRepository): Response
    {   
        $form = $this->createForm(ProgramType::class);
        $programs = $programRepository->findBySession($session);

        return $this->render('program/edit.html.twig', [
            'programs' => $programs,
            'session' => $session,
            'form' => $form
        ]);
    }


}
