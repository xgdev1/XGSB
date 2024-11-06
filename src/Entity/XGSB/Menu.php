<?php

namespace App\Entity\XGSB;

use App\Repository\XGSB\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\OneToMany(targetEntity: Page::class, mappedBy: 'menu')]
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
            $page->setMenu($this);
        }

        return $this;
    }

    public function removePage(Page $page): static
    {
        if ($this->Pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getMenu() === $this) {
                $page->setMenu(null);
            }
        }

        return $this;
    }
}
