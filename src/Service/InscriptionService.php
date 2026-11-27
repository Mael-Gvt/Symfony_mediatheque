<?php

namespace App\Service;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionService
{
    public function __construct(
        private UtilisateurRepository $utilisateurRepository,
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher,
        private EmailService $emailService
        )
    {

    }

    public function inscrireUtilisateur(
        string $nom,
        string $prenom,
        string $email,
        string $mdp
    ): bool
    {
        if ($this->utilisateurRepository->findOneBy(['email' => $email])) {
            return false;
        }

        // créer un nouvel utilisateur
        $utilisateur = new Utilisateur();
        
        $utilisateur->setNom($nom);
        $utilisateur->setPrenom($prenom);
        $utilisateur->setEmail($email);
        $mdpHashe = $this->passwordHasher->hashPassword($utilisateur, $mdp);
        $utilisateur->setMdp($mdpHashe);
        $utilisateur->setDateCreation(new \DateTimeImmutable());
        $utilisateur->setDateModification(new \DateTimeImmutable());
        $utilisateur->setRoles(['ROLE_USER']);

        // enregistrer le nouvel utilisateur dans la bdd
        $this->em->persist($utilisateur);
        $this->em->flush();

        // envoyer l'email après la création du compte
        $this->emailService->envoyerEmailBienvenue($utilisateur->getEmail());
        return true;
    }
}

