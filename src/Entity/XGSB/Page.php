<?php

namespace App\Entity\XGSB;

use App\Repository\XGSB\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column]
    private ?int $Ordre = null;

    #[ORM\Column(nullable: true)]
    private ?array $parameters = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateCreation = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childs')]
    private ?self $parent = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    private Collection $childs;

    #[ORM\ManyToOne(inversedBy: 'Pages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypePage $Type = null;

    #[ORM\OneToMany(targetEntity: Module::class, mappedBy: 'Page', orphanRemoval: true)]
    #[ORM\OrderBy(['Ordre' => 'ASC'])]
    private Collection $Modules;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->childs = new ArrayCollection();
        $this->Modules = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTimeInterface $DateCreation): static
    {
        $this->DateCreation = $DateCreation;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChilds(): Collection
    {
        return $this->childs;
    }

    public function addChild(self $child): static
    {
        if (!$this->childs->contains($child)) {
            $this->childs->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->childs->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getType(): ?TypePage
    {
        return $this->Type;
    }

    public function setType(?TypePage $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getModules(): Collection
    {
        return $this->Modules;
    }

    public function addModule(Module $module): static
    {
        if (!$this->Modules->contains($module)) {
            $this->Modules->add($module);
            $module->setPage($this);
        }

        return $this;
    }

    public function removeModule(Module $module): static
    {
        if ($this->Modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getPage() === $this) {
                $module->setPage(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
