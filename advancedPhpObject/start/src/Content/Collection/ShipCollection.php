<?php

namespace App\Content\Collection;

use App\Content\Entity\AbstractShip;

class ShipCollection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * @var AbstractShip[]
     */
    private $ships;

    public function __construct(array $ships)
    {
        $this->ships = $ships;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->ships);
    }

    public function offsetGet($offset)
    {
        return $this->ships[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->ships[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->ships[$offset]);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->ships);
    }

    public function removeBrokenShips(): self
    {
        foreach ($this->ships as $key => $ship) {
            if (!$ship->isFunctional()) {
                $this->offsetUnset($key);
            }
        }

        return $this;
    }

    public function count(): int
    {
        return \count($this->ships);
    }
}
