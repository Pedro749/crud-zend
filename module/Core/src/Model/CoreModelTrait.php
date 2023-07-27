<?php

namespace Core\Model;

use Zend\Hydrator\ReflectionHydrator;

trait CoreModelTrait
{
    public function exchangeArray(array $data)
    {
        (new ReflectionHydrator())->hydrate($data, $this);
    }

    public function getArrayCopy()
    {
        return (new ReflectionHydrator())->extract($this);
    }
}
