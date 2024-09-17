<?php

namespace App\Tests\Web\Traits;

use Symfony\Component\DomCrawler\Crawler;

trait TestRequestTrait
{
    public function post(string $url, array $data): Crawler
    {
        return $this->client->request('POST', $url, [], [], [
            'HTTP_ACCEPT' => 'application/json',
            'CONTENT_TYPE' => 'application/json',
        ], json_encode($data));
    }
}