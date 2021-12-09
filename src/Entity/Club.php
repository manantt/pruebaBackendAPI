<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 */
class Club
{
    const MAX_JUGADORES = 5;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $escudo;

    /**
     * @ORM\Column(type="float")
     */
    private $limiteSalarial;

    /**
     * @ORM\OneToMany(targetEntity=Empleado::class, mappedBy="club")
     */
    private $empleados;

    public function __construct()
    {
        $this->empleados = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getEscudo(): ?string
    {
        return $this->escudo;
    }

    public function setEscudo(string $escudo): self
    {
        $this->escudo = $escudo;

        return $this;
    }

    public function getLimiteSalarial(): ?float
    {
        return $this->limiteSalarial;
    }

    public function setLimiteSalarial(float $limiteSalarial): self
    {
        $this->limiteSalarial = $limiteSalarial;

        return $this;
    }

    /**
     * @return Collection|Empleado[]
     */
    public function getEmpleados(): Collection
    {
        return $this->empleados;
    }

    public function addEmpleado(Empleado $empleado): self
    {
        if (!$this->empleados->contains($empleado)) {
            $this->empleados[] = $empleado;
            $empleado->setClub($this);
        }

        return $this;
    }

    public function removeEmpleado(Empleado $empleado): self
    {
        if ($this->empleados->removeElement($empleado)) {
            // set the owning side to null (unless already changed)
            if ($empleado->getClub() === $this) {
                $empleado->setClub(null);
            }
        }

        return $this;
    }

    public function getEntrenador(): ?Empleado
    {
        foreach ($this->empleados as $key => $empleado) {
            if($empleado->getTipoEmpleado() == Empleado::TIPO_EMPLEADO_ENTRENADOR) {
                return $empleado;
            }
        }
        return null;
    }

    /**
     * @return Collection|Empleado[]
     */
    public function getJugadores(): Collection
    {
        $jugadores = new ArrayCollection();
        foreach ($this->empleados as $key => $empleado) {
            if($empleado->getTipoEmpleado() == Empleado::TIPO_EMPLEADO_JUGADOR) {
                $jugadores->add($empleado);
            }
        }
        return $jugadores;
    }

    public function aceptaJugadores() : bool 
    {
        return $this->getJugadores()->count() < self::MAX_JUGADORES;
    }

    /**
     * Devuelve el salario total que el club paga a sus empleados
     */
    public function getSalarioTotal() : float {
        $salario = 0;
        foreach ($this->empleados as $key => $empleado) {
            $salario += $empleado->getSalario();
        }
        return $salario;
    }
}
