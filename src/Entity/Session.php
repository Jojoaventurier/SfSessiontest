<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalNumber = null;

    #[ORM\Column(length: 50)]
    private ?string $sessionName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Training $training = null;



    /**
     * @var Collection<int, Program>
     */
    #[ORM\OneToMany(targetEntity: Program::class, mappedBy: 'session')]
    private Collection $programs;

    /**
     * @var Collection<int, Trainee>
     */
    #[ORM\ManyToMany(targetEntity: Trainee::class, inversedBy: 'sessions')]
    private Collection $trainees;

   

    public function __construct()
    {
        $this->programs = new ArrayCollection();
        $this->trainees = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalNumber(): ?int
    {
        return $this->totalNumber;
    }

    public function setTotalNumber(?int $totalNumber): static
    {
        $this->totalNumber = $totalNumber;

        return $this;
    }

    public function getSessionName(): ?string
    {
        return $this->sessionName;
    }

    public function setSessionName(string $sessionName): static
    {
        $this->sessionName = $sessionName;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): static
    {
        $this->training = $training;

        return $this;
    }

   

    /**
     * @return Collection<int, Program>
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): static
    {
        if (!$this->programs->contains($program)) {
            $this->programs->add($program);
            $program->setSession($this);
        }

        return $this;
    }

    public function removeProgram(Program $program): static
    {
        if ($this->programs->removeElement($program)) {
            // set the owning side to null (unless already changed)
            if ($program->getSession() === $this) {
                $program->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Trainee>
     */
    public function getTrainees(): Collection
    {
        return $this->trainees;
    }

    public function addTrainee(Trainee $trainee): static
    {
        if (!$this->trainees->contains($trainee)) {
            $this->trainees->add($trainee);
        }

        return $this;
    }

    public function removeTrainee(Trainee $trainee): static
    {
        $this->trainees->removeElement($trainee);

        return $this;
    }


    public function numberBooked() {
        $numberBooked = count($this->trainees);
        return $numberBooked;
    }

    public function numberLeft() {
        $numberLeft = $this->totalNumber - count($this->trainees);
        return $numberLeft;
    }

    public function __toString() {
        return $this->sessionName;
    }

    public function request(SessionRepository $sessionRepository) {
        $request = $sessionRepository->requestNull();
        return $request;
    }

}
