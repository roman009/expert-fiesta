<?php

namespace AppBundle\Infrastructure\Repository;

use AppBundle\Application\Services\DownloaderService;
use AppBundle\Entity\Episode;

class JsonEpisodeRepository implements EpisodeRepository
{
    public const SOURCE_URL = 'https://rmp.files.bbci.co.uk/technical-test/source-data.json';

    /**
     * @var array
     */
    private $data;
    /**
     * @var DownloaderService
     */
    private $downloaderService;

    /**
     * JsonEpisodeRepository constructor.
     * @param DownloaderService $downloaderService
     */
    public function __construct(DownloaderService $downloaderService)
    {
        $this->downloaderService = $downloaderService;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function load(): array
    {
        if (null !== $this->data) {
            return $this->data;
        }

        $jsonFile = $this->downloaderService->handle(self::SOURCE_URL);

        $episodes = json_decode($jsonFile, true)['atoz']['tleo_titles'];

        return array_map(function (array $elem) {
            return new Episode($elem['title'], $elem['programme']['short_synopsis'], isset($elem['programme']['image']) ? $elem['programme']['image']['pid'] : '');
        }, $episodes);
    }

    /**
     * @param string $query
     * @param int $limit
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function search(string $query, int $limit = 20): array
    {
        $this->data = $this->load();
        $found = 0;

        return array_values(array_filter($this->data, function (Episode $episode) use ($query, $limit, &$found) {
            if ($found > $limit) {
                return false;
            }
            $match = stripos($episode->getTitle(), $query) !== false;
            if ($match) {
                $found++;
                return true;
            }

            return false;
        }));
    }
}
