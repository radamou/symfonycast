<?php

namespace KnpU\Tests\Behat;

use KnpU\Domain\Common\BaseRepository;

/**
 * Class used in ApiFeatureContext::processReplacements to lookup entity ids.
 */
class EntityLookup
{
    private $repository;

    private $field;

    public function __construct(BaseRepository $repository, $field)
    {
        $this->repository = $repository;
        $this->field = $field;
    }

    public function get($value)
    {
        if ('last' == $value) {
            // "last" is a special word you can use
            $obj = $this->repository->findLast();

            if (!$obj) {
                throw new \Exception(\sprintf('Cannot find any %s entities', \get_class($this->repository)));
            }
        } else {
            $obj = $this->repository->findOneBy([$this->field => $value]);

            if (!$obj) {
                throw new \Exception(\sprintf('Cannot find %s=%s via %s', $this->field, $value, \get_class($this->repository)));
            }
        }

        return $obj;
    }

    public function __get($value)
    {
        return $this->get($value);
    }
}
