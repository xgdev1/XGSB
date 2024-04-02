<?php

namespace App\Entity\XGSB;

use App\Repository\XGSB\TypePageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypePageRepository::class)]
class TypePage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Code = null;

    #[ORM\Column]
    private ?bool $isSpecial = null;

    #[ORM\OneToMany(targetEntity: Page::class, mappedBy: 'Type', orphanRemoval: true)]
    private Collection $Pages;

    public function __construct()
    {
        $this->Pages = new ArrayCollection();
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

    public function isIsSpecial(): ?bool
    {
        return $this->isSpecial;
    }

    public function setIsSpecial(bool $isSpecial): static
    {
        $this->isSpecial = $isSpecial;

        return $this;
    }

    /**
     * @return Collection<int, Page>
     */
    public function getPages(): Collection
    {
        return $this->Pages;
    }

    public function addPage(Page $page): static
    {
        if (!$this->Pages->contains($page)) {
            $this->Pages->add($page);
            $page->setType($this);
        }

        return $this;
    }

    public function removePage(Page $page): static
    {
        if ($this->Pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getType() === $this) {
                $page->setType(null);
            }
        }

        return $this;
    }
}
