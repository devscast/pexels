<?php

declare(strict_types=1);

namespace Devscast\Pexels\Tests\Parameter;

use PHPUnit\Framework\TestCase;
use Devscast\Pexels\Parameter\PopularVideosParameters;

/**
 * Class PopularVideosParametersTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class PopularVideosParametersTest extends TestCase
{
    public function testValidParameters(): void
    {
        // Test case: Valid parameters provided
        $minWidth = 320;
        $minHeight = 240;
        $minDuration = 10;
        $maxDuration = 60;
        $page = 2;
        $perPage = 20;

        $params = new PopularVideosParameters($minWidth, $minHeight, $minDuration, $maxDuration, $page, $perPage);

        // Assertions for constructor with valid parameters
        $this->assertEquals($minWidth, $params->min_width);
        $this->assertEquals($minHeight, $params->min_height);
        $this->assertEquals($minDuration, $params->min_duration);
        $this->assertEquals($maxDuration, $params->max_duration);
        $this->assertEquals($page, $params->page);
        $this->assertEquals($perPage, $params->per_page);
    }

    // Add similar test methods for specific parameter validations (null, negative values, etc.)

    public function testDefaultValues(): void
    {
        // Test case: No parameters provided (all defaults to null)
        $params = new PopularVideosParameters();

        $this->assertNull($params->min_width);
        $this->assertNull($params->min_height);
        $this->assertNull($params->min_duration);
        $this->assertNull($params->max_duration);
    }

    public function testToArrayMethod(): void
    {
        // Test case: Valid parameters provided
        $minWidth = 320;
        $minHeight = 240;
        $minDuration = 10;
        $maxDuration = 60;
        $page = 2;
        $perPage = 20;

        $params = new PopularVideosParameters($minWidth, $minHeight, $minDuration, $maxDuration, $page, $perPage);
        $resultArray = $params->toArray();

        // Assertions for toArray() method
        $this->assertIsArray($resultArray);
        $this->assertArrayHasKey('min_width', $resultArray);
        $this->assertArrayHasKey('min_height', $resultArray);
        $this->assertArrayHasKey('min_duration', $resultArray);
        $this->assertArrayHasKey('max_duration', $resultArray);

        // Verify that null values are filtered out
        $this->assertArrayNotHasKey('min_duration', array_filter($resultArray, fn ($p) => $p === null));
    }
}
