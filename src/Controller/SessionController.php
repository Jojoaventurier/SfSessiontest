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
    // fonction pour afficher la liste des sessions enregistrées en BDD
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findAll();
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    // fonction pour ajouter ou modifier une session 
    #[Route('/session/new', name: 'new_session')]
    #[Route('/session/{id}/edit', name: 'edit_session')]
    public function new_edit(Session $session = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$session) { // si pas de session on récupère une session
            $session = new Session();
        }

        $form = $this->createForm(SessionType::class, $session); // création du formulaire qu'on stocke dans la variable $form

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { // si le formulaire est soumis et validé

            $session = $form->getData(); // on récupère les données du formulaire qu'on stocke dans une variable $session
            $entityManager->persist($session); // on prépare la requête d'ajout à la BDD
            $entityManager->flush(); // on exécute la requête

            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/new.html.twig', [ // vue retournée pour l'affichage
            'formAddSession' => $form,
            'edit' => $session->getId(), // on récupère l'id de la session à éditer
            'session' => $session
        ]);
    }

    // fonction pour supprimer une session de la BDD (attention, on perds les stagiaires inscrits et les modules programmés pour la session)
    #[Route('/session/{id}/delete', name: 'delete_session')]
    public function delete(Session $session, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($session); // préparation de la requête
        $entityManager->flush(); // execution de la requête

        return $this->redirectToRoute('app_session');
    }

    // fonction pour afficher les détailes d'une session
    #[Route('/session/{id}', name: 'show_session')]
    public function show(Session $session, SessionRepository $sessionRepository, ProgramRepository $programRepository): Response
    {   
        $programs = $programRepository->findBySession($session); // stock le programme correspondant à la session
        $trainees = $sessionRepository->getTraineesNotRegistered($session); // stocke les stagiaires non inscrits à la session
        return $this->render('session/show.html.twig', [
            'session' => $session, 
            'trainees' => $trainees,  
            'programs' => $programs
        ]);
    }
    // fonction pour inscrire un stagiaire à une session
    #[Route('/session/{session}/add/{trainee}', name: 'register_trainee')]
    public function register(Session $session, Trainee $trainee, EntityManagerInterface $entityManager) {

         $session->addTrainee($trainee); //on ajoute un stagiaire à la collection Trainees de la Session
         $trainee->addSession($session);// on a joute une session à la collection Session du stagiaire

         $entityManager->persist($trainee); // on prépare la requête pour ajout à la BDD
         $entityManager->persist($session); // idem
         $entityManager->flush(); // on exécute les deux requêtes demandées

         return $this->redirectToRoute('app_session');
    }

    // fonction pour désinscrire un stagiaire d'une session
    #[Route('/session/{session}/remove/{trainee}', name: 'unregister_trainee')]
    public function unregister(Session $session, Trainee $trainee, EntityManagerInterface $entityManager) {

         $session->removeTrainee($trainee);
         $trainee->removeSession($session);

         $entityManager->flush();

         return $this->redirectToRoute('app_session');
    }

    
}
