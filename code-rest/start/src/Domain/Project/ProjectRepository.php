<?php

namespace KnpU\Domain\Project;

use KnpU\Domain\Common\BaseRepository;

class ProjectRepository extends BaseRepository
{
    protected function getClassName(): string
    {
        return 'KnpU\Domain\Project\Project';
    }

    protected function getTableName(): string
    {
        return 'project';
    }

    public function findOneByName($name)
    {
        return $this->findOneBy(['name' => $name]);
    }

    /**
     * @param $limit
     *
     * @return Project[]
     */
    public function findRandom($limit)
    {
        $stmt = $this->createQueryBuilder('p')
            ->setMaxResults($limit)
            ->execute()
        ;

        $projects = $this->fetchAllToObject($stmt);
        \shuffle($projects);

        return \array_slice($projects, 0, $limit);
    }
}
