<?php

declare(strict_types=1);

namespace Devscast\Pexels\Data;

use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * class CollectionMedia.
 *
 * @author bernard-ng <bernard@devscast.tech>
 * @template T
 * @psalm-template T
 */
final class CollectionMedia
{
    use PageableTrait;

    /**
     * @var string The id of the collection you are requesting.
     */
    public string $id;

    /**
     * @var array<T>
     * An array of media objects. Each object has an extra type attribute to indicate the type of object.
     */
    #[Ignore]
    public array $media;
}
