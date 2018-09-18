<?php

namespace AppBundle\Application\Services;

use AppBundle\Infrastructure\Repository\EpisodeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EpisodeSearchService
{
    /**
     * @var EpisodeRepository
     */
    private $episodeRepository;

    /**
     * EpisodeSearchService constructor.
     * @param EpisodeRepository $episodeRepository
     */
    public function __construct(EpisodeRepository $episodeRepository)
    {
        $this->episodeRepository = $episodeRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        $query = $request->get('query');
        if (null === $query || strlen($query) <= 1) {
            return new JsonResponse(['error' => 'query too short'], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($this->episodeRepository->search($query));
    }
}
