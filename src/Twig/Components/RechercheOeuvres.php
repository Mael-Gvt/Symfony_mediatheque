<?php

namespace App\Twig\Components;

use App\Repository\OeuvreRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class RechercheOeuvres
{
    use DefaultActionTrait;

    #[LiveProp(writable: true, url: true)]
    public string $titre = '';

    public function __construct(
        private OeuvreRepository $oeuvreRepository
    )
    {
    }
    public function getOeuvres(): array{
        if ($this->titre === '') {
            return $this->oeuvreRepository->findAll();
        } else {
            return $this->oeuvreRepository->rechercheParTitre($this->titre);
        }
    }
}
