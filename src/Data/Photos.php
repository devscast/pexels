<?php

declare(strict_types=1);

namespace Devscast\Pexels\Data;

use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * class Photos.
 *
 * @author bernard-ng <bernard@devscast.tech>
 * @template T
 * @psalm-template T
 */
final class Photos
{
    use PageableTrait;

    /** @var array<T> An array of Photo objects. */
    #[Ignore]
    public array $photos = [];
}
