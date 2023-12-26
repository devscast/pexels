<?php

declare(strict_types=1);

namespace Devscast\Pexels\Tests;

use stdClass;
use Devscast\Pexels\Mapper;
use PHPUnit\Framework\TestCase;

/**
 * Class MapperTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class MapperTest extends TestCase
{
    public function testToObjectMethod(): void
    {
        // Test case: Test toObject method
        $data = ['name' => 'John', 'age' => 30];
        $object = new stdClass();

        $resultObject = Mapper::toObject($object, $data);

        // Assertions for toObject() method
        $this->assertInstanceOf(stdClass::class, $resultObject);
        $this->assertEquals('John', $resultObject->name);
        $this->assertEquals(30, $resultObject->age);
    }

    public function testToArrayMethod(): void
    {
        // Test case: Test toArray method
        $data = new class {
            public string $name;
            public int $age;
        };
        $data->name = 'Alice';
        $data->age = 25;

        $resultArray = Mapper::toArray([], $data);

        // Assertions for toArray() method
        $this->assertIsArray($resultArray);
        $this->assertArrayHasKey('name', $resultArray);
        $this->assertEquals('Alice', $resultArray['name']);
        $this->assertArrayHasKey('age', $resultArray);
        $this->assertEquals(25, $resultArray['age']);
    }
}
