<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EmpleadoRepository;
use App\Repository\ClubRepository;
use App\Entity\Empleado;
use App\Form\Model\EmpleadoDto;
use App\Form\Type\EmpleadoFormType;
use App\Service\Mailer;

class EmpleadoController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/empleados")
     * @Rest\View(serializerGroups={"empleado"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(
        EmpleadoRepository $empleadoRepository
    ) {
        return $empleadoRepository->findAll();
    }

    /**
     * @Rest\Post(path="/empleado")
     * @Rest\View(serializerGroups={"empleado"}, serializerEnableMaxDepthChecks=true)
     */
    public function postAction(
        Request $request, 
        EntityManagerInterface $em
    )
    {
        $empleadoDto = new EmpleadoDto();
        $form = $this->createForm(EmpleadoFormType::class, $empleadoDto);
        $form->handleRequest($request);
        if(!$form->isSubmitted()) {
            return new Response("", Response::HTTP_BAD_REQUEST);
        }
        if($form->isValid()) {
            $empleado = new Empleado();
            $empleado->setNombre($empleadoDto->nombre);
            $empleado->setEmail($empleadoDto->email);
            $empleado->setFechaNacimiento(new \Datetime($empleadoDto->fechaNacimiento));
            $empleado->setPosicion(intval($empleadoDto->posicion));
            $empleado->setTipoEmpleado(intval($empleadoDto->tipoEmpleado));
            $em->persist($empleado);
            $em->flush();
            return $empleado;
        }
        return $form;
    }

    /**
     * @Rest\Post(path="/empleado/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"empleado"}, serializerEnableMaxDepthChecks=true)
     */
    public function editAction(
        int $id,
        Request $request, 
        EntityManagerInterface $em,
        EmpleadoRepository $empleadoRepository,
        ClubRepository $clubRepository,
        Mailer $mailer
    )
    {
        $empleado = $empleadoRepository->find($id);
        if(!$empleado) {
            throw $this->createNotFoundException("No se ha encontrado el empleado");
        }
        $empleadoDto = EmpleadoDto::crearDesdeEmpleado($empleado);
        $form = $this->createForm(EmpleadoFormType::class, $empleadoDto);
        $form->handleRequest($request);
        if(!$form->isSubmitted()) {
            return new Response("", Response::HTTP_BAD_REQUEST);
        }
        if($form->isValid()) {
            $empleado = $empleadoRepository->find($id);
            $empleado->setNombre($empleadoDto->nombre);
            $empleado->setEmail($empleadoDto->email);
            $empleado->setTelefono($empleadoDto->telefono);
            $empleado->setFechaNacimiento(new \Datetime($empleadoDto->fechaNacimiento));
            $empleado->setPosicion(intval($empleadoDto->posicion));
            $empleado->setTipoEmpleado(intval($empleadoDto->tipoEmpleado));
            // set club y salario
            if($empleadoDto->club) {
                $club = $clubRepository->find($empleadoDto->club);
                $empleado->setClub($club);
                $empleado->setSalario($empleado->getTipoEmpleado() == Empleado::TIPO_EMPLEADO_CANTERANO ? 0 : (float)$empleadoDto->salario);
                //$mailer->notificarAlta($empleado); // TODO: configurar mailer
            } else {
                $empleado->setClub(null);
                $empleado->setSalario(null);
            }
            
            $em->persist($empleado);
            $em->flush();
            return $empleado;
        }
        return $form;
    }
    
    
}