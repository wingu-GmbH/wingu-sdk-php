<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Card;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Card;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\Card as RequestCard;
use Wingu\Engine\SDK\Model\Response\Card\Card as ResponseCard;
use Wingu\Engine\SDK\Model\Response\Card\Position;
use Wingu\Engine\SDK\Model\Response\Component\Files;
use Wingu\Engine\SDK\Model\Response\Component\FilesFile;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class CardTest extends ApiTest
{
    public function testAddCardToDeckAttachesCardToDeck() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_card.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new Card($configurationMock, $httpClient);

        $actualResponse = $winguApi->addCardToDeck(
            new RequestCard(
                'ea45b0c8-0000-4000-a000-000000000006',
                'a1a57fee-a9e6-4c32-ad66-da25a5a4382f',
                12
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"deck":"ea45b0c8-0000-4000-a000-000000000006","component":"a1a57fee-a9e6-4c32-ad66-da25a5a4382f","positionSort":12}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedPostedCard();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testDeleteMyCardRemovesPrivateCard() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new Card($configurationMock, $httpClient);

        $winguApi->deleteMyCard('1aaeece0-8152-4961-adbe-c6b37e23ddd7');

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('', $actualRequest->getBody()->getContents());
        self::assertSame('DELETE', $actualRequest->getMethod());
    }

    private function getExpectedPostedCard() : ResponseCard
    {
        return new ResponseCard(
            '589001e0-a279-4077-bc8e-eb263c4030fa',
            new Position(12),
            new Files(
                'a1a57fee-a9e6-4c32-ad66-da25a5a4382f',
                new \DateTime('2018-06-07T10:12:43+0000'),
                [
                    new FilesFile(
                        '3e65a29f-bcec-4de3-96f2-e747e38e75a6',
                        0,
                        'http://www.example.com/wingu-dev-components/files/wingu_presentation.pdf',
                        'wingu presentation',
                        900641
                    ),
                ]
            )
        );
    }
}
