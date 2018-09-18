<?php

namespace AppBundle\Application\Services;

use Psr\SimpleCache\CacheInterface;

class DownloaderService
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * DownloaderService constructor.
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $url
     * @return string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function handle(string $url): string
    {
        $cacheKey = md5($url);
        if (!$this->cache->has($cacheKey)) {
            $contents = file_get_contents($url);
            $this->cache->set($cacheKey, $contents, 5 * 60);
        } else {
            $contents = $this->cache->get($cacheKey);
        }

        return $contents;
    }
}
