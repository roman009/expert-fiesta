<?php

namespace AppBundle\Infrastructure\Repository;

interface EpisodeRepository
{
    public function load();
    public function search(string $query, int $limit = 20): array;
}
