<?php

namespace App\Dto;

class BaseDto
{
    public static function fromArray(array $properties): static
    {
        return new static(...$properties);
    }

}