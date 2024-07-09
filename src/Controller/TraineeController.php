<?php

namespace App\Controller;

use App\Entity\Trainee;
use App\Form\TraineeType;
use App\Repository\SessionRepository;
use App\Repository\TraineeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TraineeController extends AbstractController
{
    #[Route('/trainee', name: 'app_trainee')]
    public function index(TraineeRepository $traineeRepository): Response
    {
        $trainees = $traineeRepository->findAll();
        return $this->render('trainee/index.html.twig', [
            'trainees' => $trainees,
        ]);
    }

    
    #[Route('/trainee/new', name: 'new_trainee')]
    #[Route('/trainee/{id}/edit', name: 'edit_trainee')]
    public function new_edit(Trainee $trainee = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$trainee) {
            $trainee = new Trainee();
        }

        $form = $this->createForm(TraineeType::class, $trainee);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trainee = $form->getData();
            $entityManager->persist($trainee);
            $entityManager->flush();

            return $this->redirectToRoute('app_trainee');
        }

        return $this->render('trainee/new.html.twig', [
            'formAddTrainee' => $form,
            'edit' => $trainee->getId(),
            'trainee' => $trainee
        ]);
    }


    #[Route('/trainee/{id}', name: 'show_trainee')]
    public function show(Trainee $trainee, SessionRepository $sessionRepository): Response
    {
        // $sessions = $sessionRepository->findByTrainee($trainee);
        return $this->render('trainee/show.html.twig', [
            'trainee' => $trainee,
            // 'sessions' => $sessions
        ]);
    }

    #[Route('/trainee/{id}/delete', name: 'delete_trainee')]
    public function delete(Trainee $trainee, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($trainee);
        $entityManager->flush();

        return $this->redirectToRoute('app_trainee');
    }

}
