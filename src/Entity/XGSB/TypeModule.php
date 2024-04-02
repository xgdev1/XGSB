<?php

namespace App\Entity\XGSB;

use App\Repository\XGSB\TypeModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeModuleRepository::class)]
class TypeModule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Code = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\OneToMany(targetEntity: Module::class, mappedBy: 'Type', orphanRemoval: true)]
    private Collection $Modules;

    public function __construct()
    {
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

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(string $Code): static
    {
        $this->Code = $Code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

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
            $module->setType($this);
        }

        return $this;
    }

    public function removeModule(Module $module): static
    {
        if ($this->Modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getType() === $this) {
                $module->setType(null);
            }
        }

        return $this;
    }
}
