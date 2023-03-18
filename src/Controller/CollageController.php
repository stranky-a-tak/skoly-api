<?php

namespace App\Controller;

use App\Repository\CollageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CollageController extends AbstractController
{
    public function __construct(
        private readonly CollageRepository $repository,
        private readonly NormalizerInterface $serializer,
    ) {
    }

    #[Route('/collages', name: 'collages')]
    public function index(): JsonResponse
    {
        $jsonData = $this->serializer->normalize($this->repository->findAll(), 'json');
        return new JsonResponse($jsonData);
    }
}
