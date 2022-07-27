<?php

declare(strict_types=1);

namespace Devscast\Pexels;

/**
 * trait MappingTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait MappableTrait
{
    public static function fromArray(array $data): self
    {
        /** @var self $object */
        $object = Mapper::toObject(new self(), $data);

        return $object;
    }

    public function toArray(): array
    {
        return Mapper::toArray([], $this);
    }
}
