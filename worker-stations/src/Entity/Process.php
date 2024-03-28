<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\BalanceProcessesController;
use App\Controller\CreateProcessController;
use App\Controller\DeleteProcessController;
use App\Repository\ProcessRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProcessRepository::class)]
#[ApiResource(
    operations:[
        new Get(
        ),
        new Patch(
            name: 'rebalance',
            uriTemplate: '/processes/rebalance',
            controller: BalanceProcessesController::class,
        ),
        new GetCollection(),
        new Post(
            name: 'new process',
            uriTemplate: '/process/new',
            controller: CreateProcessController::class
        ),
        new Delete(
            uriTemplate:'/process/{id}',
            controller: DeleteProcessController::class
        )
    ]
)]
class Process
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $MemoryReq = null;

    #[ORM\Column]
    private ?int $CPUReq = null;

    #[ORM\ManyToOne(inversedBy: 'processes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?WorkStation $workstationId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMemoryReq(): ?int
    {
        return $this->MemoryReq;
    }

    public function setMemoryReq(int $MemoryReq): static
    {
        $this->MemoryReq = $MemoryReq;

        return $this;
    }

    public function getCPUReq(): ?int
    {
        return $this->CPUReq;
    }

    public function setCPUReq(int $CPUReq): static
    {
        $this->CPUReq = $CPUReq;

        return $this;
    }

    public function getWorkstationId(): ?WorkStation
    {
        return $this->workstationId;
    }

    public function setWorkstationId(?WorkStation $workstationId): static
    {
        $this->workstationId = $workstationId;

        return $this;
    }
}
