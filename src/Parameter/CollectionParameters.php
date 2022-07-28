<?php

declare(strict_types=1);

namespace Devscast\Pexels\Parameter;

use Webmozart\Assert\Assert;

/**
 * class CollectionParameters.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CollectionParameters extends Parameters
{
    /**
     * @var string|null
     *
     * The type of media you are requesting.
     * If not given or if given with an invalid value, all media will be returned.
     * Supported values are photos and videos.
     */
    public readonly ?string $type;

    public function __construct(?string $type = null, int $page = 1, int $per_page = 15)
    {
        parent::__construct($page, $per_page);
        Assert::nullOrOneOf($type, ['photos', 'videos']);

        $this->type = $type;
    }
}
