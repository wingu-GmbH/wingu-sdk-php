<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Content;

use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Mock\Client as MockClient;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Api\Content\Category;
use Wingu\Engine\SDK\Api\Generic;
use Wingu\Engine\SDK\Hydrator\Hydrator;
use Wingu\Engine\SDK\Hydrator\SymfonySerializerHydrator;
use Wingu\Engine\SDK\Model\Content\Category as CategoryModel;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

final class CategoryTest extends ApiTest
{
    public function testCategoriesThrowsExceptionWhenResponseIsNot200() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = $this->createMock(Hydrator::class);

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(500, ['Content-Type' => 'application/json'], '{"code": 500, "errors": []}')
        );

        $winguApi = new Category($configurationMock, $httpClient, $requestFactory, $hydrator);

        $this->expectException(Generic::class);
        $this->expectExceptionMessage('Remote server error.');

        $winguApi->categories();
    }

    public function testCategoriesReturnsResult() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/categories.json')
            )
        );

        $winguApi = new Category($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->categories();

        $expected = [
            new CategoryModel(2, 'Sport', 'F47E00'),
            new CategoryModel(3, 'Hobby', 'B90D19'),
        ];

        self::assertCount(2, $actual);
        self::assertEquals($expected, \iterator_to_array($actual));
    }

    public function testCategoriesReturnsResultAndFetchesNextPages() : void
    {
        $configurationMock = new Configuration();
        $requestFactory    = new GuzzleMessageFactory();
        $hydrator          = new SymfonySerializerHydrator();

        $httpClient = new MockClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/categories-pagination-1.json')
            )
        );
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/categories-pagination-2.json')
            )
        );
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                \file_get_contents(__DIR__ . '/Fixtures/categories-pagination-3.json')
            )
        );

        $winguApi = new Category($configurationMock, $httpClient, $requestFactory, $hydrator);
        $actual   = $winguApi->categories();

        $expected = [
            new CategoryModel(1, 'Health and Wellness', 'F91E57'),
            new CategoryModel(2, 'Sport', 'F47E00'),
            new CategoryModel(3, 'Hobby', 'B90D19'),
            new CategoryModel(4, 'Open', '4B6FE0'),
            new CategoryModel(5, 'Tourism', 'EBA600'),
            new CategoryModel(6, 'Entertainment', '00B7AE'),
            new CategoryModel(7, 'Eating & drinking', '0BA100'),
            new CategoryModel(8, 'Retail', '4331CB'),
            new CategoryModel(9, 'Arts, Culture & Education', '5E4360'),
        ];

        self::assertCount(9, $actual);
        self::assertEquals($expected, \iterator_to_array($actual));
        self::assertCount(3, $httpClient->getRequests());
    }
}
