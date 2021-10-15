<?php

namespace App\Entity;

use App\Repository\CvRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CvRepository::class)
 */
class Cv
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Identity::class, inversedBy="Cvs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $identity;

    /**
     * @ORM\ManyToMany(targetEntity=Heading::class, mappedBy="cvs")
     */
    private $headings;

    public function __construct()
    {
        $this->headings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIdentity(): ?Identity
    {
        return $this->identity;
    }

    public function setIdentity(?Identity $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * @return Collection|Heading[]
     */
    public function getHeadings(): Collection
    {
        return $this->headings;
    }

    public function addHeading(Heading $heading): self
    {
        if (!$this->headings->contains($heading)) {
            $this->headings[] = $heading;
            $heading->addCv($this);
        }

        return $this;
    }

    public function removeHeading(Heading $heading): self
    {
        if ($this->headings->removeElement($heading)) {
            $heading->removeCv($this);
        }

        return $this;
    }
}
