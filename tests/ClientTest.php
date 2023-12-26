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
use Devscast\Pexels\Data\Collections;
use Devscast\Pexels\Data\CollectionMedia;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
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
        $reflection = new ReflectionClass($pexels);

        $http = $reflection->getProperty('http');
        $http->setAccessible(true);
        $http->setValue($pexels, new MockHttpClient($mock));

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
    }

    public function testSearchVideos(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("search_videos.json"));

        $videos = $pexels->searchVideos('westie dog');

        $this->assertInstanceOf(Videos::class, $videos);
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
    }

    public function curatedPhotos(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("curated_photos.json"));

        $photos = $pexels->curatedPhotos();

        $this->assertInstanceOf(Photos::class, $photos);
    }

    public function testFeaturedCollections(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("featured_collections.json"));

        $collections = $pexels->featuredCollections();

        $this->assertInstanceOf(Collections::class, $collections);
    }

    public function testCollections(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("my_collection.json"));

        $collections = $pexels->collections();

        $this->assertInstanceOf(Collections::class, $collections);
    }

    public function testCollection(): void
    {
        $pexels = $this->getPexels(fn ($method, $url, $options) => $this->getResponse("collection_media.json"));

        $collections = $pexels->collection("33");

        $this->assertInstanceOf(CollectionMedia::class, $collections);
    }
}
