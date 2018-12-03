<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Component\Contact;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Component\ContactApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\Component\Contact\Address\Create as CreateAddress;
use Wingu\Engine\SDK\Model\Request\Component\Contact\Address\Update as UpdateAddress;
use Wingu\Engine\SDK\Model\Request\Component\Contact\Create;
use Wingu\Engine\SDK\Model\Request\Component\Contact\ExternalLinks\Create as CreateExternalLinks;
use Wingu\Engine\SDK\Model\Request\Component\Contact\ExternalLinks\Update as UpdateExternalLinks;
use Wingu\Engine\SDK\Model\Request\Component\Contact\Update;
use Wingu\Engine\SDK\Model\Request\StringValue;
use Wingu\Engine\SDK\Model\Response\Component\Contact;
use Wingu\Engine\SDK\Model\Response\Component\ContactAddress;
use Wingu\Engine\SDK\Model\Response\Component\ContactExternalLinks;
use Wingu\Engine\SDK\Tests\Api\ApiTest;

class ContactApiTest extends ApiTest
{
    public function testCreateReturnsNewContactComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            201,
            ['Content-Type' => 'application/json'],
            $this->getDataFromFixturesFile('posted_contact_component.json')
        );
        $httpClient->addResponse($response);

        $winguApi = new ContactApi($configurationMock, $httpClient);

        $actualResponse = $winguApi->create(
            new Create(
                'Example',
                'Mr.',
                'Benjamin',
                'Berg',
                '004917225446165',
                '+49 (0)17 22 544 61',
                'benjamin.berg@example.com',
                'www.example.com',
                new CreateAddress(
                    'DE',
                    'Oststadt',
                    '89081',
                    'Kurfuerstendamm',
                    '66'
                ),
                'Daily, 9:00 - 17:00',
                new CreateExternalLinks(
                    'wingude',
                    'wingude',
                    '+Speicher210',
                    'speicher-210-hamburg-2'
                ),
                'Some extra info'
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"companyName":"Example","personalTitle":"Mr.","firstName":"Benjamin","lastName":"Berg","mobile":"004917225446165","phone":"+49 (0)17 22 544 61","email":"benjamin.berg@example.com","website":"www.example.com","address":{"country":"DE","city":"Oststadt","zipCode":"89081","street":"Kurfuerstendamm","streetNumber":"66"},"openingHours":"Daily, 9:00 - 17:00","externalLinks":{"facebookName":"wingude","twitterName":"wingude","googlePlusName":"+Speicher210","yelpName":"speicher-210-hamburg-2"},"extraInfo":"Some extra info"}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('POST', $actualRequest->getMethod());

        $expectedResponse = $this->getExpectedContact();
        self::assertEquals($expectedResponse, $actualResponse);
    }

    public function testUpdatePatchesContactComponent() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new ContactApi($configurationMock, $httpClient);

        $winguApi->update(
            '58778834-e728-49a9-a1c7-aef8732d3797',
            new Update(
                new StringValue('Wingu'),
                new StringValue('Sir'),
                null,
                null,
                null,
                null,
                null,
                new StringValue('https://www.wingu.de'),
                new UpdateAddress(null, null, null, null, null),
                null,
                new UpdateExternalLinks(null, null, null, null),
                new StringValue('Edited extra info')
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"companyName":"Wingu","personalTitle":"Sir","website":"https:\/\/www.wingu.de","address":[],"externalLinks":[],"extraInfo":"Edited extra info"}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    private function getExpectedContact() : Contact
    {
        return new Contact(
            '58778834-e728-49a9-a1c7-aef8732d3797',
            new \DateTime('2018-09-07T09:36:06+0000'),
            'Example',
            'Mr.',
            'Benjamin',
            'Berg',
            'benjamin.berg@example.com',
            '004917225446165',
            '+49 (0)17 22 544 61',
            'www.example.com',
            'Daily, 9:00 - 17:00',
            'Some extra info',
            new ContactAddress(
                '4884dc34-1689-489a-93a9-c04fb74a90eb',
                'DE',
                'Oststadt',
                '89081',
                'Kurfuerstendamm',
                '66'
            ),
            new ContactExternalLinks(
                'fc889bc3-c31f-446c-8b83-828705c6bd0f',
                'https://www.facebook.com/wingude',
                'https://twitter.com/wingude',
                'https://plus.google.com/+Speicher210',
                'http://www.yelp.com/biz/speicher-210-hamburg-2',
                'wingude',
                'wingude',
                '+Speicher210',
                'speicher-210-hamburg-2'
            )
        );
    }
}
