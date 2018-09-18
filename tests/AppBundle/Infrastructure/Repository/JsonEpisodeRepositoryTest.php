<?php

namespace Tests\AppBundle\Infrastructure\Repository;

use AppBundle\Application\Services\DownloaderService;
use AppBundle\Entity\Episode;
use AppBundle\Infrastructure\Repository\JsonEpisodeRepository;
use PHPUnit\Framework\TestCase;

class JsonEpisodeRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function givenAQueryThenReturnRelevantEpisodes()
    {
        $downloaderService = $this->createMock(DownloaderService::class);
        $jsonEpisodeRepository = new JsonEpisodeRepository($downloaderService);
        $jsonEpisodeRepository->setData([
            new Episode('some test title', '', ''),
            new Episode('some teest title', '', ''),
        ]);

        $result = $jsonEpisodeRepository->search('test');
        $this->assertEquals(
            [new Episode('some test title', '', '')],
            $result
        );
    }

    public function givenAJsonThenExtractEpisodes()
    {
        $downloaderService = $this->createMock(DownloaderService::class);
        $downloaderService->expects($this->once())->method('handle')->willReturn(file_get_contents(__DIR__.'/test-data.json'));

        $jsonEpisodeRepository = new JsonEpisodeRepository($downloaderService);
        $jsonEpisodeRepository->load();
        $result = $jsonEpisodeRepository->getData();

        $this->assertCount(3, $result);
        $this->assertEquals(
            new Episode('\'arse that Jack Built, The', 'Ian McMillan goes in search of one of Britain\'s strangest linguistic features.', 'p01hwgzc'),
            $result[0]
        );
    }
}
