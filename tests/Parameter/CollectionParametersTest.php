<?php

declare(strict_types=1);

namespace Devscast\Pexels\Tests\Parameter;

use PHPUnit\Framework\TestCase;
use Devscast\Pexels\Parameter\CollectionParameters;

/**
 * Class CollectionParametersTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class CollectionParametersTest extends TestCase
{
    public function testValidParameters(): void
    {
        // Test case: Valid parameters provided
        $type = 'photos';
        $page = 2;
        $perPage = 20;
        $sort = 'desc';

        $collectionParams = new CollectionParameters($type, $page, $perPage, $sort);

        $this->assertEquals($type, $collectionParams->type);
        $this->assertEquals($page, $collectionParams->page);
        $this->assertEquals($perPage, $collectionParams->per_page);
        $this->assertEquals($sort, $collectionParams->sort);
    }

    public function testInvalidTypeParameter(): void
    {
        $invalidType = 'invalid_type';

        $this->expectException(\InvalidArgumentException::class);
        new CollectionParameters($invalidType, 1, 15, 'asc');
    }

    public function testInvalidSortParameter(): void
    {
        $invalidSort = 'invalid_sort';

        $this->expectException(\InvalidArgumentException::class);
        new CollectionParameters(null, 1, 15, $invalidSort);
    }

    public function testToArrayMethod(): void
    {
        $collectionParams = new CollectionParameters('photos', 2, 29, 'desc');
        $resultArray = $collectionParams->toArray();

        // Assertions for toArray() method
        $this->assertIsArray($resultArray);
        $this->assertArrayHasKey('page', $resultArray);
        $this->assertArrayHasKey('per_page', $resultArray);
        $this->assertArrayHasKey('type', $resultArray);
        $this->assertArrayHasKey('sort', $resultArray);

        // Verify that null values are filtered out
        $this->assertArrayNotHasKey('type', array_filter($resultArray, fn ($p) => $p === null));
    }
}
