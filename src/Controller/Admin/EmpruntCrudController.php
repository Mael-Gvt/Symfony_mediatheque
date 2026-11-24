<?php

namespace App\Controller\Admin;

use App\Entity\Emprunt;
use App\Enum\StatutReservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class EmpruntCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Emprunt::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('exemplaire')
                ->setFormTypeOption('choice_label', 'codeInventaire'),
            AssociationField::new('utilisateur')
                ->setFormTypeOption('choice_label', 'email'),
            DateTimeField::new('dateReservation', 'Date de réservation'),
            ChoiceField::new('statutReservation', 'Statut de réservation')
                ->setChoices(array_combine(
                    array_map(
                        static fn (StatutReservation $statut): string => $statut->voirStatut(),
                        StatutReservation::cases(),
                    ),
                    StatutReservation::cases(),
                )),
            DateTimeField::new('dateEmprunt', "Date d'emprunt"),
            DateTimeField::new('dateRetourPrevu', 'Date de retour prévue'),
            DateTimeField::new('dateRetourReelle', 'Date de retour réelle'),
        ];
    }
}
