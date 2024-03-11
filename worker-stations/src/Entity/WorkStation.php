<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\WorkStationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: WorkStationRepository::class)]
class WorkStation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $total_mem = null;

    #[ORM\Column]
    private ?int $total_cpu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalMem(): ?int
    {
        return $this->total_mem;
    }

    public function setTotalMem(int $total_mem): static
    {
        $this->total_mem = $total_mem;

        return $this;
    }

    public function getTotalCpu(): ?int
    {
        return $this->total_cpu;
    }

    public function setTotalCpu(int $total_cpu): static
    {
        $this->total_cpu = $total_cpu;

        return $this;
    }
}
