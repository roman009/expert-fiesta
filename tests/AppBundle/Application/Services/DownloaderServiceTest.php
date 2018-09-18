<?php

namespace Tests\AppBundle\Application\Services;

use AppBundle\Application\Services\DownloaderService;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;

class DownloaderServiceTest extends TestCase
{
    /**
     * @test
     */
    public function givenAUrlThanIsCachedThenReturnCachedValue()
    {
        $cache = $this->createMock(CacheInterface::class);
        $cache->expects($this->once())->method('has')->willReturn(true);
        $cache->expects($this->once())->method('get')->willReturn('content');

        $downloaderService = new DownloaderService($cache);
        $result = $downloaderService->handle('some url');

        $this->assertSame('content', $result);
    }
}