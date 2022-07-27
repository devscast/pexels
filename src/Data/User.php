<?php

declare(strict_types=1);

namespace Devscast\Pexels\Data;

use Devscast\Pexels\MappableTrait;

/**
 * class User.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class User
{
    use MappableTrait;

    /**
     * @var int The id of the user.
     */
    public int $id;

    /**
     * @var string The name of the user.
     */
    public string $name;

    /**
     * @var string The URL of the user's Pexels profile.
     */
    public string $url;
}
