<?php

declare(strict_types=1);

namespace Devscast\Pexels\Data;

use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * class Collections.
 *
 * @author bernard-ng <bernard@devscast.tech>
 * @template T
 * @psalm-template T
 */
final class Collections
{
    use PageableTrait;

    /** @var array<T> */
    #[Ignore]
    public array $collections = [];
}
