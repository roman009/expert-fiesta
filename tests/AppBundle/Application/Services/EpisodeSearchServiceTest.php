<?php

namespace Tests\AppBundle\Application\Services;

use AppBundle\Application\Services\EpisodeSearchService;
use AppBundle\Infrastructure\Repository\EpisodeRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EpisodeSearchServiceTest extends TestCase
{
    /**
     * @test
     */
    public function givenAnInvalidRequestThenReturnBadRequest()
    {
        $episodeRepository = $this->createMock(EpisodeRepository::class);
        $episodeSearchService = new EpisodeSearchService($episodeRepository);

        $request = new Request();

        $response = $episodeSearchService->handle($request);
        $this->assertEquals(new JsonResponse(['error' => 'query too short'], Response::HTTP_BAD_REQUEST), $response);
    }

    /**
     * @test
     */
    public function givenAProperRequestThenCallSearchRepository()
    {
        $episodeRepository = $this->createMock(EpisodeRepository::class);
        $episodeRepository->expects($this->once())->method('search')->willReturn([]);

        $episodeSearchService = new EpisodeSearchService($episodeRepository);

        $request = new Request(['query' => 'some query']);

        $response = $episodeSearchService->handle($request);
        $this->assertEquals(new JsonResponse([]), $response);
    }
}
