<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ClubRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Club;
use App\Form\Model\ClubDto;
use Symfony\Component\HttpFoundation\Response;
use App\Form\Type\ClubFormType;
use App\Service\FileUploader;

class ClubController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/clubs")
     * @Rest\View(serializerGroups={"club"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(
        ClubRepository $clubRepository
    ) {
        return $clubRepository->findAll();
    }

    /**
     * @Rest\Post(path="/club")
     * @Rest\View(serializerGroups={"club"}, serializerEnableMaxDepthChecks=true)
     */
    public function postAction(
        Request $request, 
        EntityManagerInterface $em,
        FileUploader $fileuploader
    )
    {
        $clubDto = new ClubDto();
        $form = $this->createForm(ClubFormType::class, $clubDto);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $club = new Club();
            if($clubDto->base64escudo) {
                $filename = $fileuploader->uploadBase64File($clubDto->base64escudo);
            }
            $club->setEscudo($filename ?? "");
            $club->setNombre($clubDto->nombre);
            $club->setLimiteSalarial($clubDto->limiteSalarial);
            $em->persist($club);
            $em->flush();
            return $club;
        }
        return $form;
    }

    /**
     * @Rest\Post(path="/club/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"club"}, serializerEnableMaxDepthChecks=true)
     */
    public function editAction(
        int $id,
        Request $request, 
        EntityManagerInterface $em,
        ClubRepository $clubRepository,
        FileUploader $fileuploader
    )
    {
        $club = $clubRepository->find($id);
        if(!$club) {
            throw $this->createNotFoundException("No se ha encontrado el club");
        }
        $clubDto = ClubDto::crearDesdeClub($club);
        $form = $this->createForm(ClubFormType::class, $clubDto);
        $form->handleRequest($request);
        if(!$form->isSubmitted()) {
            return new Response("", Response::HTTP_BAD_REQUEST);
        }
        if($form->isValid()) {
            $club = $clubRepository->find($id);
            $club->setNombre($clubDto->nombre);
            if($clubDto->base64escudo) {
                $filename = $fileuploader->uploadBase64File($clubDto->base64escudo);
            }
            $club->setEscudo($filename ?? "");
            $club->setLimiteSalarial($clubDto->limiteSalarial);
            
            $em->persist($club);
            $em->flush();
            return $club;
        }
        return $form;
    }
}