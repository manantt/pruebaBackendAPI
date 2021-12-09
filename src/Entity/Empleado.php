<?php

namespace App\Entity;

use App\Repository\EmpleadoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmpleadoRepository::class)
 */
class Empleado
{
    const TIPO_EMPLEADO_DESCONOCIDO = 0;
    const TIPO_EMPLEADO_JUGADOR = 1;
    const TIPO_EMPLEADO_CANTERANO = 2;
    const TIPO_EMPLEADO_ENTRENADOR = 3;

    const POSICION_PORTERO = 0;
    const POSICION_DEFENSA = 1;
    const POSICION_CENTROCAMPISTA = 2;
    const POSICION_DELANTERO = 3;
    
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
     * @ORM\Column(type="string", length=32)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $salario;

    /**
     * @ORM\Column(type="date")
     */
    private $fechaNacimiento;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $posicion;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $tipoEmpleado;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="empleados")
     * @ORM\JoinColumn(nullable=true)
     */
    private $club;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getSalario(): ?float
    {
        return $this->salario;
    }

    public function setSalario(?float $salario): self
    {
        $this->salario = $salario;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getPosicion(): ?int
    {
        return $this->posicion;
    }

    public function setPosicion(?int $posicion): self
    {
        $this->posicion = $posicion;

        return $this;
    }

    public function getTipoEmpleado(): ?int
    {
        return $this->tipoEmpleado;
    }

    public function setTipoEmpleado(?int $tipoEmpleado): self
    {
        $this->tipoEmpleado = $tipoEmpleado;

        return $this;
    }

    public function isJugador(): ?bool
    {
        return $this->tipoEmpleado == self::TIPO_EMPLEADO_JUGADOR;
    }

    public function isCanterano(): ?bool
    {
        return $this->tipoEmpleado == self::TIPO_EMPLEADO_CANTERANO;
    }

    public function isEntrenador(): ?bool
    {
        return $this->tipoEmpleado == self::TIPO_EMPLEADO_ENTRENADOR;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }
}
