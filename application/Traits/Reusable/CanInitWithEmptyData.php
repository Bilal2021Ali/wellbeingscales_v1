<?php

namespace Traits\Reusable;

use ReflectionProperty;
use Throwable;

trait CanInitWithEmptyData
{
    public static function initWithEmptyData(): self
    {
        $properties = array_keys(self::properties());

        $data = [];
        foreach ($properties as $property) {
            try {
                $reflector = new ReflectionProperty(self::class, $property);

                if ($reflector->getType()->getName() === 'array') {
                    $data[$property] = [];
                } else {
                    $data[$property] = null;
                }
            } catch (Throwable $exception) {
                log_message('error', $exception->getMessage());
            }

        }

        return new self($data);
    }

    public static function properties(): array
    {
        return get_class_vars(__CLASS__);
    }
}