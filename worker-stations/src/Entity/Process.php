<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProcessRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: ProcessRepository::class)]
class Process
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $mem_required = null;

    #[ORM\Column]
    private ?int $cpu_required = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMemRequired(): ?int
    {
        return $this->mem_required;
    }

    public function setMemRequired(int $mem_required): static
    {
        $this->mem_required = $mem_required;

        return $this;
    }

    public function getCpuRequired(): ?int
    {
        return $this->cpu_required;
    }

    public function setCpuRequired(int $cpu_required): static
    {
        $this->cpu_required = $cpu_required;

        return $this;
    }
}
