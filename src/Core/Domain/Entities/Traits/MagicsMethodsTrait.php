<?php

namespace Core\Domain\Entities\Traits;

use Exception;

trait MagicsMethodsTrait
{
    public function __get($property)
    {
        if (! isset($this->{$property})) {
            $className = get_class($this);

            throw new Exception("Property $property not found in class $className");
        }

        return $this->{$property};
    }
}