<?php

namespace App\Entity\XGSB;

use App\Repository\XGSB\SectionPageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionPageRepository::class)]
class SectionPage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $BGColor = null;

    #[ORM\ManyToOne(inversedBy: 'SectionsPages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Page $Page = null;

    #[ORM\OneToMany(targetEntity: Module::class, mappedBy: 'sectionPage')]
    private Collection $modules;

    #[ORM\Column(nullable: true)]
    private ?int $Ordre = null;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getBGColor(): ?string
    {
        return $this->BGColor;
    }

    public function setBGColor(string $BGColor): static
    {
        $this->BGColor = $BGColor;

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

    /**
     * @return Collection<int, Module>
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): static
    {
        if (!$this->modules->contains($module)) {
            $this->modules->add($module);
            $module->setSectionPage($this);
        }

        return $this;
    }

    public function removeModule(Module $module): static
    {
        if ($this->modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getSectionPage() === $this) {
                $module->setSectionPage(null);
            }
        }

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->Ordre;
    }

    public function setOrdre(?int $Ordre): static
    {
        $this->Ordre = $Ordre;

        return $this;
    }
}
