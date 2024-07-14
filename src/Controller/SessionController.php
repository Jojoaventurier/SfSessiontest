<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Trainee;
use App\Form\SessionType;
use App\Repository\ProgramRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findAll();
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    #[Route('/session/new', name: 'new_session')]
    #[Route('/session/{id}/edit', name: 'edit_session')]
    public function new_edit(Session $session = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$session) {
            $session = new Session();
        }

        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/new.html.twig', [
            'formAddSession' => $form,
            'edit' => $session->getId(),
            'session' => $session
        ]);
    }

    #[Route('/session/{id}/delete', name: 'delete_session')]
    public function delete(Session $session, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($session);
        $entityManager->flush();

        return $this->redirectToRoute('app_session');
    }

    #[Route('/session/{id}', name: 'show_session')]
    public function show(Session $session, SessionRepository $sessionRepository, ProgramRepository $programRepository): Response
    {   
        $programs = $programRepository->findBySession($session);
        $trainees = $sessionRepository->getTraineesNotRegistered($session);
        return $this->render('session/show.html.twig', [
            'session' => $session,
            'trainees' => $trainees,
            'programs' => $programs
        ]);
    }

    #[Route('/session/{session}/add/{trainee}', name: 'register_trainee')]
    public function register(Session $session, Trainee $trainee, EntityManagerInterface $entityManager) {

         $session->addTrainee($trainee);
         $trainee->addSession($session);

         $entityManager->persist($trainee);
         $entityManager->persist($session);
         $entityManager->flush();

         return $this->redirectToRoute('app_session');
    }

    #[Route('/session/{session}/remove/{trainee}', name: 'unregister_trainee')]
    public function unregister(Session $session, Trainee $trainee, EntityManagerInterface $entityManager) {

         $session->removeTrainee($trainee);
         $trainee->removeSession($session);

        //  $entityManager->remove($trainee);
        //  $entityManager->remove($session);
        //  $entityManager->flush();

         return $this->redirectToRoute('app_session');
    }

    
}
