<?php

namespace AppBundle\Entity;

class Episode implements \JsonSerializable
{
    public const IMG_PATTERN = 'https://ichef.bbci.co.uk/images/ic/480x270/{PID}.jpg';

    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $synopsis;
    /**
     * @var string
     */
    private $image;

    /**
     * Episode constructor.
     * @param string $title
     * @param string $synopsis
     * @param string $image
     */
    public function __construct(string $title, string $synopsis, string $image)
    {
        $this->title = $title;
        $this->synopsis = $synopsis;
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSynopsis(): string
    {
        return $this->synopsis;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return str_replace('{PID}', $this->image, self::IMG_PATTERN);
    }

    public function jsonSerialize()
    {
        return [
            'title' => $this->getTitle(),
            'synopsis' => $this->getSynopsis(),
            'image' => $this->getImage(),
        ];
    }
}
