<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use App\Controller\CreateWorkStationController;
use App\Repository\WorkStationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WorkStationRepository::class)]
#[ApiResource(operations:[
    new Get(
        uriTemplate: '/workstation/{id}'
    ),
    new GetCollection(
        uriTemplate: '/workstations'
    ),
    new Post(
        name: 'new station',
        uriTemplate: '/workstation/new',
        controller: CreateWorkStationController::class,
        normalizationContext:['groups' => ['req']]
    ),
    new Delete(
        uriTemplate:'workstation/{id}',
    )
])]
class WorkStation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups('req')]
    #[Assert\NotNull]
    #[ApiProperty(
        openapiContext:[
            'type' => 'integer',
            'example' => '200'
        ]
    )]
    #[ORM\Column]
    private ?int $TotalMemory = null;

    #[Groups('req')]
    #[Assert\NotNull]
    #[ApiProperty(
        openapiContext:[
            'type' => 'integer',
            'example' => '100'
        ]
    )]
    #[ORM\Column]
    private ?int $TotalCPU = null;

    #[Assert\Blank]
    #[ApiProperty(
        openapiContext:[
            'type' => 'null'
        ]
    )]
    #[ORM\OneToMany(targetEntity: Process::class, mappedBy: 'workstationId')]
    private Collection $processes;

    public function __construct()
    {
        $this->processes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalMemory(): ?int
    {
        return $this->TotalMemory;
    }

    public function setTotalMemory(int $TotalMemory): static
    {
        $this->TotalMemory = $TotalMemory;

        return $this;
    }

    public function getTotalCPU(): ?int
    {
        return $this->TotalCPU;
    }

    public function setTotalCPU(int $TotalCPU): static
    {
        $this->TotalCPU = $TotalCPU;

        return $this;
    }

    /**
     * @return Collection<int, Process>
     */
    public function getProcesses(): Collection
    {
        return $this->processes;
    }

    public function addProcess(Process $process): static
    {
        if (!$this->processes->contains($process)) {
            $this->processes->add($process);
            $process->setWorkstationId($this);
        }

        return $this;
    }

    public function removeProcess(Process $process): static
    {
        if ($this->processes->removeElement($process)) {
            // set the owning side to null (unless already changed)
            if ($process->getWorkstationId() === $this) {
                $process->setWorkstationId(null);
            }
        }

        return $this;
    }
}
