<?php

declare(strict_types=1);

namespace Devscast\Pexels;

/**
 * class Mapper.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class Mapper
{
    public static function toObject(object $object, array $data): object
    {
        foreach ($data as $k => $v) {
            $object->{$k} = $v;
        }

        return $object;
    }

    public static function toArray(array $array, object $data): array
    {
        $reflection = new \ReflectionClass($data);
        foreach ($reflection->getProperties() as $property) {
            $array[$property->getName()] = $property->getValue($data);
        }

        return $array;
    }
}
