<?php

namespace App\Entity\XGSB;

use App\Repository\XGSB\ModuleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateCreation = null;

    #[ORM\Column]
    private ?int $Ordre = null;

    #[ORM\Column(nullable: true)]
    private ?array $parameters = null;

    #[ORM\Column]
    private ?int $ColWidth = null;

    #[ORM\ManyToOne(inversedBy: 'Modules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Page $Page = null;

    #[ORM\ManyToOne(inversedBy: 'Modules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeModule $Type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTimeInterface $DateCreation): static
    {
        $this->DateCreation = $DateCreation;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->Ordre;
    }

    public function setOrdre(int $Ordre): static
    {
        $this->Ordre = $Ordre;

        return $this;
    }

    public function getParameters(): ?array
    {
        return $this->parameters;
    }

    public function setParameters(?array $parameters): static
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getColWidth(): ?int
    {
        return $this->ColWidth;
    }

    public function setColWidth(int $ColWidth): static
    {
        $this->ColWidth = $ColWidth;

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->Page;
    }

    public function setPage(?Page $Page): static
    {
        $this->Page = $Page;

        return $this;
    }

    public function getType(): ?TypeModule
    {
        return $this->Type;
    }

    public function setType(?TypeModule $Type): static
    {
        $this->Type = $Type;

        return $this;
    }
}
