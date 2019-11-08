<?php

namespace KnpU\Domain\Repository;

/**
 * A class that can be used to get any repository from a nickname.
 *
 * Used internally in BaseRepository for relationships
 */
class RepositoryContainer
{
    private $container;

    private $repositoryMap;

    public function __construct(\Pimple $container, array $repositoryMap)
    {
        $this->container = $container;
        $this->repositoryMap = $repositoryMap;
    }

    /**@throws \Exception */
    public function get(string $key): BaseRepository
    {
        if (!isset($this->repositoryMap[$key])) {
            throw new \Exception(\sprintf('Unknown repo name %s', $key));
        }

        $serviceId = $this->repositoryMap[$key];

        return $this->container[$serviceId];
    }
}
