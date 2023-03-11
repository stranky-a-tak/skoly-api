<?php

namespace App\Controller;

use App\Repository\CollageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CollageController extends AbstractController
{
    public function __construct(private CollageRepository $collageRepository)
    {
    }

    #[Route('/collages', name: 'app_collage', methods: ['POST'])]
    public function search(Request $request): JsonResponse
    {
        $content = json_decode($request->getContent());
        $collage = $this->collageRepository->getSearchResult($content->search);

        return new JsonResponse($collage);
    }
}
