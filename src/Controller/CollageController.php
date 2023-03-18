<?php

namespace App\Controller;

use App\Dto\Request\Collage\CollageSearchRequestDto;
use App\Repository\CollageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: "api/collages")]
class CollageController extends AbstractController
{
    public function __construct(
        private readonly CollageRepository $repository,
        private readonly SerializerInterface $serializer,
    ) {
    }

    #[Route('', name: 'search', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        $searchRequest = $this->serializer->deserialize(
            $request->getContent(),
            CollageSearchRequestDto::class,
            'json'
        );

        return new JsonResponse(
            $this->repository->getSearchResult($searchRequest->getQuery())
        );
    }
}
