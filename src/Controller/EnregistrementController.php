<?php

namespace App\Controller;

use App\Service\InscriptionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EnregistrementController extends AbstractController
{
    #[Route('/enregistrement', name: 'app_enregistrement')]
    public function enregistrement(Request $request, InscriptionService $inscriptionService): Response
    {
        // on vérifie si la méthode est bien POST et on récupère les données saisies dans les champs
        if ($request->isMethod('POST')) {
            $email = trim($request->request->get('email'));
            $mdp = trim($request->request->get('mdp'));
            $nom = trim($request->request->get('nom'));
            $prenom = trim($request->request->get('prenom'));

            // vérifier token csrf
        if (!$this->isCsrfTokenValid(
            'register',
            $request->request->get('_csrf_token')
        )) {
            throw $this->createAccessDeniedException('Token CSRF invalide');
        }

            // vérifier les champs
            if ($email === '' || $mdp === '' || $nom === '' || $prenom === '') {
                $this->addFlash('error', 'Tous les champs sont obligatoires.');
                return $this->redirectToRoute('app_enregistrement');
            }

             // Appeler le service pour effectuer l'inscription
            $inscriptionReussie = $inscriptionService->inscrireUtilisateur(
                $nom,
                $prenom,
                $email,
                $mdp
            );

            $this->addFlash('success', 'Votre compte a été créé.');

            return $this->redirectToRoute('app_login');
        }

         return $this->render('enregistrement/enregistrement.html.twig');
    }
}
