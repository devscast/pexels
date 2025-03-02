<?php

declare(strict_types=1);

namespace Devscast\Pexels\Tests;

use ReflectionClass;
use Devscast\Pexels\Client;
use PHPUnit\Framework\TestCase;
use Devscast\Pexels\Data\Video;
use Devscast\Pexels\Data\Photo;
use Devscast\Pexels\Data\Photos;
use Devscast\Pexels\Data\Videos;
use Devscast\Pexels\Data\Collection;
use Devscast\Pexels\Data\Collections;
use Devscast\Pexels\Data\CollectionMedia;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * Class ClientTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ClientTest extends TestCase
{
    private function getPexels(callable|MockResponse $mock): Client
    {
        $pexels = new Client('your_token');
        $this->setValue($pexels, 'http', new MockHttpClient($mock));

        return $pexels;
    }

    private function getResponse(string $file): MockResponse
    {
        return new MockResponse((string) file_get_contents(__DIR__ . "/responses/{$file}"));
    }

    public function testSearchPhotos(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("search_photos.json"));

        $photos = $pexels->searchPhotos('westie dog');

        $this->assertInstanceOf(Photos::class, $photos);
        $this->assertContainsOnlyInstancesOf(Photo::class, $photos->photos);
    }

    public function testSearchVideos(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("search_videos.json"));

        $videos = $pexels->searchVideos('westie dog');

        $this->assertInstanceOf(Videos::class, $videos);
        $this->assertContainsOnlyInstancesOf(Video::class, $videos->videos);
    }

    public function testPhoto(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("photo.json"));

        $photos = $pexels->photo(33);

        $this->assertInstanceOf(Photo::class, $photos);
    }

    public function testVideo(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("video.json"));

        $videos = $pexels->video(33);

        $this->assertInstanceOf(Video::class, $videos);
    }

    public function testPopularVideos(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("popular_videos.json"));

        $videos = $pexels->popularVideos();

        $this->assertInstanceOf(Videos::class, $videos);
        $this->assertContainsOnlyInstancesOf(Video::class, $videos->videos);
    }

    public function curatedPhotos(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("curated_photos.json"));

        $photos = $pexels->curatedPhotos();

        $this->assertInstanceOf(Photos::class, $photos);
        $this->assertContainsOnlyInstancesOf(Photo::class, $photos->photos);
    }

    public function testFeaturedCollections(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("featured_collections.json"));

        $collections = $pexels->featuredCollections();

        $this->assertInstanceOf(Collections::class, $collections);
        $this->assertContainsOnlyInstancesOf(Collection::class, $collections->collections);
    }

    public function testCollections(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("my_collection.json"));

        $collections = $pexels->collections();

        $this->assertInstanceOf(Collections::class, $collections);
        $this->assertContainsOnlyInstancesOf(Collection::class, $collections->collections);
    }

    public function testCollection(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("collection_media.json"));

        $collections = $pexels->collection("33");

        $this->assertInstanceOf(CollectionMedia::class, $collections);

        /** @var Photo|Video $media */
        foreach ($collections->media as $media) {
            if ('photo' === $media->type) {
                $this->assertInstanceOf(Photo::class, $media);
            }

            if ('video' === $media->type) {
                $this->assertInstanceOf(Video::class, $media);
            }
        }
    }

    private function setValue(object &$object, string $propertyName, mixed $value): void
    {
        $reflectionClass = new ReflectionClass($object);

        if ($reflectionClass->getProperty($propertyName)->isReadOnly()) {
            $mutable = $reflectionClass->newInstanceWithoutConstructor();

            foreach ($reflectionClass->getProperties() as $property) {
                if ($property->isInitialized($object) && $property->name != $propertyName) {
                    $reflectionClass->getProperty($property->name)->setValue($mutable, $property->getValue($object));
                }
            }

            $object = $mutable;
        }

        $reflectionClass->getProperty($propertyName)->setValue($object, $value);
    }
}
