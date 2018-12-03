<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Channel\Beacon;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Speicher210\BusinessHours\BusinessHours;
use Speicher210\BusinessHours\Day\AllDay;
use Speicher210\BusinessHours\Day\Day;
use Speicher210\BusinessHours\Day\Time\TimeInterval;
use Wingu\Engine\SDK\Api\Channel\Beacon\BeaconApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\BooleanValue;
use Wingu\Engine\SDK\Model\Request\Channel\Beacon\BeaconAddress as RequestBeaconAddress;
use Wingu\Engine\SDK\Model\Request\Channel\Beacon\BeaconLocation as RequestBeaconLocation;
use Wingu\Engine\SDK\Model\Request\Channel\Beacon\Coordinates as RequestCoordinates;
use Wingu\Engine\SDK\Model\Request\Channel\Beacon\PrivateBeacon as RequestBeacon;
use Wingu\Engine\SDK\Model\Request\Channel\Beacon\PublicBeaconLocation as RequestPublicBeacon;
use Wingu\Engine\SDK\Model\Request\StringValue;
use Wingu\Engine\SDK\Model\Response\Card\Card;
use Wingu\Engine\SDK\Model\Response\Card\Position;
use Wingu\Engine\SDK\Model\Response\Channel\Beacon\BeaconAddress;
use Wingu\Engine\SDK\Model\Response\Channel\Beacon\BeaconLocation;
use Wingu\Engine\SDK\Model\Response\Channel\Beacon\PrivateBeacon;
use Wingu\Engine\SDK\Model\Response\Channel\Beacon\PublicBeacon;
use Wingu\Engine\SDK\Model\Response\Component\Action;
use Wingu\Engine\SDK\Model\Response\Component\AudioPlaylist;
use Wingu\Engine\SDK\Model\Response\Component\AudioPlaylistMedia as Media;
use Wingu\Engine\SDK\Model\Response\Component\BrandBar;
use Wingu\Engine\SDK\Model\Response\Component\BrandBarBackground;
use Wingu\Engine\SDK\Model\Response\Component\BrandBarImage;
use Wingu\Engine\SDK\Model\Response\Component\BrandBarText;
use Wingu\Engine\SDK\Model\Response\Component\CMS;
use Wingu\Engine\SDK\Model\Response\Component\Contact;
use Wingu\Engine\SDK\Model\Response\Component\ContactAddress;
use Wingu\Engine\SDK\Model\Response\Component\ContactExternalLinks;
use Wingu\Engine\SDK\Model\Response\Component\Coupon;
use Wingu\Engine\SDK\Model\Response\Component\CouponBarcode;
use Wingu\Engine\SDK\Model\Response\Component\Files;
use Wingu\Engine\SDK\Model\Response\Component\FilesFile as File;
use Wingu\Engine\SDK\Model\Response\Component\Image;
use Wingu\Engine\SDK\Model\Response\Component\Image as InnerImage;
use Wingu\Engine\SDK\Model\Response\Component\ImageGallery;
use Wingu\Engine\SDK\Model\Response\Component\ImageGalleryImage as OuterImage;
use Wingu\Engine\SDK\Model\Response\Component\ImageMetadata;
use Wingu\Engine\SDK\Model\Response\Component\ImageMetadata as Metadata;
use Wingu\Engine\SDK\Model\Response\Component\Location;
use Wingu\Engine\SDK\Model\Response\Component\PublicForm;
use Wingu\Engine\SDK\Model\Response\Component\PublicWebhook;
use Wingu\Engine\SDK\Model\Response\Component\Rating;
use Wingu\Engine\SDK\Model\Response\Component\Separator;
use Wingu\Engine\SDK\Model\Response\Component\SurveyMonkey;
use Wingu\Engine\SDK\Model\Response\Component\Video;
use Wingu\Engine\SDK\Model\Response\Content\Deck;
use Wingu\Engine\SDK\Model\Response\Content\Locale;
use Wingu\Engine\SDK\Model\Response\Content\Pack;
use Wingu\Engine\SDK\Model\Response\Content\PrivateContent;
use Wingu\Engine\SDK\Model\Response\Content\PrivateListContent;
use Wingu\Engine\SDK\Model\Response\Content\PublicContent;
use Wingu\Engine\SDK\Model\Response\Coordinates;
use Wingu\Engine\SDK\Tests\Api\ChannelApiTestCase;
use Wingu\Engine\SDK\Tests\Api\Expected\Loader\PrivateComponent;

final class BeaconApiTest extends ChannelApiTestCase
{
    use PrivateComponent;

    public function testBeaconReturnsPublicBeacon() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                $this->getDataFromFixturesFile('full_public_beacon.json')
            )
        );

        $winguApi = new BeaconApi($configurationMock, $httpClient);
        $actual   = $winguApi->beacon('02a554ab-34bc-48b7-87ad-754037b8b09b');

        $expected = new PublicBeacon(
            '8c798a67-0000-4000-a000-000000000101',
            'Beacon 11100',
            '2e422b9f-4955-4f1d-95d1-e57626ad1b26',
            11,
            100,
            new PublicContent(
                '12d1da34-0000-4000-a000-000000000012',
                new Pack(
                    'a5668669-833b-4e13-bc9c-9bc1ce1b82dc',
                    new Deck(
                        'ea45b0c8-0000-4000-a000-000000000012',
                        'Deck 12 title',
                        'Deck description 12',
                        [
                            new Card(
                                '470048cc-729e-4c3c-85d0-a55a3961c40f',
                                new Position(0),
                                new BrandBar(
                                    'b97919cb-5822-4eed-b192-a8f4b3a7c9ef',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    new BrandBarBackground('a5f433'),
                                    new BrandBarText('wingu brand 12', 'left', '04b1f0'),
                                    new BrandBarImage(
                                        new Image(
                                            new ImageMetadata('jpg', 30, 30),
                                            'sample',
                                            'cloudinary'
                                        ),
                                        'left'
                                    )
                                )
                            ),
                            new Card(
                                '4906e40b-03fb-416f-bd67-79b8eb67580b',
                                new Position(1),
                                new CMS(
                                    '38f76932-7727-462a-bc3d-48f05f8ef99b',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    "# Welcome!\n_Welcome in our coffee._\n## Website\nCheck out our [website](https://www.wingu.de)!  \n### Congratulations!\nYou won a **free** coffee! You can choose between:  \n1.  Gold  \n2.  Space Gray\n3.  Silver.\n\nIf you prefer you can even choose from an unordered list:\n\n*   Gold\n*   Space Gray\n*   Silver",
                                    'markdown'
                                )
                            ),
                            new Card(
                                'c9d33791-ce2d-4442-836c-6097a4b83304',
                                new Position(2),
                                new Video(
                                    '7563e1ec-25f8-4c26-8687-676411e8deb7',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    'youtube',
                                    'zfQdPcO--DA',
                                    'Video description'
                                )
                            ),
                            new Card(
                                '69f2e756-d57b-4f5b-a649-6b9959c13f8c',
                                new Position(3),
                                new ImageGallery(
                                    'ffd2f9c2-626a-4b39-a572-2eb66c116ab6',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    [
                                        new OuterImage(
                                            'd91ce1b8-807b-44e5-a00f-3e418bda6bb2',
                                            0,
                                            new InnerImage(new Metadata('jpg', 864, 576), 'sample', 'cloudinary'),
                                            'caption'
                                        ),
                                    ]
                                )
                            ),
                            new Card(
                                '3aaac6af-9c77-4b26-bb36-d04f91e63d05',
                                new Position(4),
                                new SurveyMonkey(
                                    'ffab5a60-708f-496c-81f2-9f4f9cb43d98',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    'Take the IQ survey',
                                    'You will probably fail',
                                    'https://de.surveymonkey.com/r/5FBK8Z3'
                                )
                            ),
                            new Card(
                                '59177800-a7a5-42cd-b45f-4bf3126673af',
                                new Position(5),
                                new Contact(
                                    '31059377-c060-40c7-abd4-32a39a46b60c',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
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
                                        '12eb2e6d-8d0a-471b-943d-1f21e57a209b',
                                        'DE',
                                        'Oststadt',
                                        '89081',
                                        'Kurfuerstendamm',
                                        '66'
                                    ),
                                    new ContactExternalLinks(
                                        'eb99db15-b276-4362-a455-4e1e4027de58',
                                        'https://www.facebook.com/wingude',
                                        'https://twitter.com/wingude',
                                        'https://plus.google.com/+Speicher210',
                                        'http://www.yelp.com/biz/speicher-210-hamburg-2',
                                        'wingude',
                                        'wingude',
                                        '+Speicher210',
                                        'speicher-210-hamburg-2'
                                    )
                                )
                            ),
                            new Card(
                                'f3a24585-ade8-43bf-8f8b-efd0df4273c0',
                                new Position(6),
                                new Coupon(
                                    'd8901a40-9c6c-4dbd-b3ae-0ebf0a776fb6',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    '-20 %',
                                    'Get you cheap stuff here !',
                                    'Disclaimer',
                                    new CouponBarcode('EAN_13', '4000161100348'),
                                    null
                                )
                            ),
                            new Card(
                                '5b50d0bf-e997-43e2-8bee-d7bc31e545e4',
                                new Position(7),
                                new PublicForm(
                                    '4955bb4f-6365-4de8-a91b-74e36d8ff73d',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    'Form component survey'
                                )
                            ),
                            new Card(
                                '63dda990-fecf-4f87-a705-d51e1a0ff4f2',
                                new Position(8),
                                new Location(
                                    '8d708833-50ae-4c08-b15e-047573bb35dd',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    new Coordinates(9.946769, 53.702252),
                                    495
                                )
                            ),
                            new Card(
                                '53372e94-7fff-46d3-8805-6af9745bdaac',
                                new Position(9),
                                new AudioPlaylist(
                                    '63ce064a-188e-420f-90a9-1aaf386d2696',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    'Best of',
                                    [
                                        new Media(
                                            'e0646731-1b0c-42a8-aea6-115a7b51420b',
                                            0,
                                            'http://www.example.com/audioplaylist/audio_media.mp3',
                                            'David Guetta - Wing it',
                                            39,
                                            null
                                        ),
                                        new Media(
                                            '5f9f4d1f-8df2-47e0-a2a0-dbd8121c64a4',
                                            1,
                                            'http://www.example.com/audioplaylist/audio_media.mp3',
                                            'Boom Face - Boom shakalaka',
                                            39,
                                            null
                                        ),
                                    ]
                                )
                            ),
                            new Card(
                                '83abad15-cd39-4d37-98f6-8e934e06d93d',
                                new Position(10),
                                new Action(
                                    'f9badb26-ce53-48a6-ac22-2969fbd1c810',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    'Speicher me',
                                    'open-url',
                                    'http://www.sp210.com/'
                                )
                            ),
                            new Card(
                                'ff2881a3-b894-4d6b-8d6e-0a53ddbe75e0',
                                new Position(11),
                                new Separator(
                                    '160c6c2b-fdf3-44ba-8ddb-4dcdcf126081',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    'wave',
                                    '04b1f0'
                                )
                            ),
                            new Card(
                                'e70d581d-300b-4ae4-9916-ba1700aea803',
                                new Position(12),
                                new Rating(
                                    '7cb74acf-b76f-4b06-88fe-c379fcf3320a',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    'Rate me !'
                                )
                            ),
                            new Card(
                                '5d1f11c4-c8ce-4474-8909-2c1ddf71ee8d',
                                new Position(13),
                                new PublicWebhook(
                                    'f54d0b96-bc51-4e41-88df-a752170be0d3',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    'Trigger me'
                                )
                            ),
                            new Card(
                                '2dd32478-850e-44ca-9b1b-257c155092fa',
                                new Position(14),
                                new Files(
                                    '41f6a6b6-4b04-4312-ae22-f69ce83cbc08',
                                    new \DateTime('2018-05-18T08:22:46+0000'),
                                    [
                                        new File(
                                            'a6d116da-0231-4432-8452-8553e786dda8',
                                            0,
                                            'http://www.example.com/files/wingu_presentation.pdf',
                                            'wingu presentation',
                                            900641
                                        ),
                                    ]
                                )
                            ),
                        ],
                        'Legal note12'
                    ),
                    new Locale('angielski', 'en'),
                    new \DateTimeImmutable('2018-05-18T08:22:46+0000')
                )
            ),
            new BeaconLocation(new BeaconAddress('Germany'), new Coordinates(10.285146, 53.519232))
        );

        self::assertEquals($expected, $actual);
    }

    public function testMyBeaconReturnsPrivateBeacon() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                $this->getDataFromFixturesFile('full_private_beacon.json')
            )
        );

        $winguApi = new BeaconApi($configurationMock, $httpClient);
        $actual   = $winguApi->myBeacon('30b30e6b-5bb1-439d-916e-a724cc4268ed');

        $expectedFunctioningHours = new BusinessHours(
            [
                new AllDay(Day::WEEK_DAY_MONDAY),
                new Day(
                    Day::WEEK_DAY_WEDNESDAY,
                    [
                        TimeInterval::fromString('08:00', '12:00'),
                        TimeInterval::fromString('13:00', '18:00'),
                    ]
                ),
                new AllDay(Day::WEEK_DAY_FRIDAY),
            ],
            new \DateTimeZone('Europe/Berlin')
        );

        $expected = new PrivateBeacon(
            '30b30e6b-5bb1-439d-916e-a724cc4268ed',
            'Beacon 3',
            true,
            new PrivateContent(
                '12d1da34-0000-4000-a000-000000000002',
                [
                    new Pack(
                        'd6fe8ae6-4c2a-4058-bbd1-09752e62bcee',
                        new Deck(
                            'ea45b0c8-0000-4000-a000-000000000002',
                            'Deck 2 title',
                            'Deck description 2',
                            [
                                new Card(
                                    'd8060c59-7de8-4817-a1a8-39df21668c67',
                                    new Position(0),
                                    $this->getExpectedBrandBarComponent()
                                ),
                                new Card(
                                    'f0c1f2aa-83fd-4304-a285-f603a6bd6db3',
                                    new Position(1),
                                    $this->getExpectedCmsComponent()
                                ),
                                new Card(
                                    '2250cddf-95b7-49b9-b580-28818fd92ef5',
                                    new Position(2),
                                    $this->getExpectedHtmlComponent()
                                ),
                                new Card(
                                    '90d3a9ab-8213-4f27-9dc6-edb07089e489',
                                    new Position(3),
                                    $this->getExpectedVideoComponent()
                                ),
                                new Card(
                                    'df013a1d-1572-4cf3-bae1-effb6ceddc72',
                                    new Position(4),
                                    $this->getExpectedImageGalleryComponent()
                                ),
                                new Card(
                                    '73acde90-182d-455e-bd2b-476a58365af8',
                                    new Position(5),
                                    $this->getExpectedSurveyMonkeyComponent()
                                ),
                                new Card(
                                    '8f083e36-7837-4259-9d09-bba720e9382e',
                                    new Position(6),
                                    $this->getExpectedContactComponent()
                                ),
                                new Card(
                                    'c215118c-c697-49e9-9ef0-790f91432c76',
                                    new Position(7),
                                    $this->getExpectedCouponComponent()
                                ),
                                new Card(
                                    'a37a67b1-f08d-4322-904c-99f981a70100',
                                    new Position(8),
                                    $this->getExpectedFormComponent()
                                ),
                                new Card(
                                    '4ccb04cb-2c47-41b3-8c6f-00e0fe7659f0',
                                    new Position(9),
                                    $this->getExpectedLocationComponent()
                                ),
                                new Card(
                                    '73218a3e-d2ec-487a-89e8-7f2258efde2c',
                                    new Position(10),
                                    $this->getExpectedAudioPlaylistComponent()
                                ),
                                new Card(
                                    '251dda04-292b-411a-8508-e17268d11791',
                                    new Position(11),
                                    $this->getExpectedActionComponent()
                                ),
                                new Card(
                                    '0bacfa03-c556-40b4-b659-ec6ebb9ce638',
                                    new Position(12),
                                    $this->getExpectedSeparatorComponent()
                                ),
                                new Card(
                                    '49402427-cdd2-4efe-a56c-2f8f4514bca7',
                                    new Position(13),
                                    $this->getExpectedRatingComponent()
                                ),
                                new Card(
                                    'b0921b7d-95f3-4b07-a82f-600afbb38472',
                                    new Position(14),
                                    $this->getExpectedWebhookComponent()
                                ),
                                new Card(
                                    '7dde0b47-f484-408c-be35-06d11e05322d',
                                    new Position(15),
                                    $this->getExpectedFilesComponent()
                                ),
                            ],
                            'Legal note2'
                        ),
                        new Locale('angielski', 'en'),
                        new \DateTimeImmutable('2018-05-18T08:22:41+0000')
                    ),
                ]
            ),
            true,
            'My note',
            false,
            $expectedFunctioningHours,
            '3f104004-b288-4501-80c2-4ac30a02355b',
            3,
            3,
            'https://wingu-sdk-test.de/jEdFNYY',
            new BeaconLocation(new BeaconAddress(null), null)
        );

        self::assertEquals($expected, $actual);
    }

    public function testEddystoneReturnsBeaconId() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                '{"id":"8c798a67-0000-4000-a000-000000000017"}'
            )
        );

        $winguApi = new BeaconApi($configurationMock, $httpClient);
        $actual   = $winguApi->eddystone('https://wingu-sdk-test.de/78d9c5a7-18e2-4039-bd58-e8c608c3290a');

        self::assertSame('8c798a67-0000-4000-a000-000000000017', $actual);
    }

    public function testMyBeaconsReturnsResult() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                $this->getDataFromFixturesFile('private_beacons_list.json')
            )
        );

        $beaconApi = new BeaconApi($configurationMock, $httpClient);
        $actual    = $beaconApi->myBeacons();

        $expected = [
            $this->getExpectedMinimalPrivateListBeacon(),
            $this->getExpectedFullPrivateListBeacon(),
            $this->getExpectedPrivateListBeaconWithEmptyTitle(),
        ];

        self::assertCount(3, $actual);

        /** @var PrivateBeacon[] $actualBeacons */
        $actualBeacons = \iterator_to_array($actual);
        self::assertEquals($expected, $actualBeacons);

        // Assert nullable fields.
        self::assertNull($actualBeacons[0]->content());
        self::assertNull($actualBeacons[0]->functioningHours());
        self::assertNull($actualBeacons[0]->note());
        self::assertNull($actualBeacons[0]->location()->coordinates());
        self::assertNull($actualBeacons[0]->location()->address()->formattedAddress());

        /** @var PrivateListContent $actualBeaconWithEmptyContentTitle */
        $actualBeaconWithEmptyContentTitle = $actualBeacons[2]->content();
        self::assertNull($actualBeaconWithEmptyContentTitle->title());
    }

    public function testPostBeaconLocationUpdatesPublicBeaconLocation() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new BeaconApi($configurationMock, $httpClient);

        $winguApi->updateBeaconLocation(
            '14683274-a9f0-46e8-8c04-ebc40e0d52cb',
            new RequestPublicBeacon(
                new RequestCoordinates(10.285146, 53.519232),
                new \DateTimeImmutable('2018-09-12 10:22:20', new \DateTimeZone('America/Argentina/Cordoba'))
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"coordinates":{"longitude":10.285146,"latitude":53.519232},"locationAcquiredDateTime":"2018-09-12T10:22:20-03:00"}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('POST', $actualRequest->getMethod());
    }

    public function testPatchMyBeaconUpdatesPrivateBeacon() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new BeaconApi($configurationMock, $httpClient);

        $winguApi->updateMyBeacon(
            '009b12e0-9426-45fd-9476-561540139ec1',
            new RequestBeacon(
                new RequestBeaconLocation(null, null),
                new StringValue(null),
                new StringValue('New beacon name'),
                null,
                new BooleanValue(false)
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"content":null,"name":"New beacon name","published":"0","location":{"coordinates":null,"address":null}}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    public function testPatchMyBeaconWithLocationUpdatesPrivateBeaconLocation() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new BeaconApi($configurationMock, $httpClient);

        $winguApi->updateMyBeacon(
            '009b12e0-9426-45fd-9476-561540139ec1',
            new RequestBeacon(
                new RequestBeaconLocation(
                    new RequestCoordinates(10.285146, 53.519232),
                    new RequestBeaconAddress('imaginary address')
                ),
                null,
                new StringValue('New beacon with a location')
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"name":"New beacon with a location","location":{"coordinates":{"longitude":10.285146,"latitude":53.519232},"address":{"formattedAddress":"imaginary address"}}}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    public function testDeleteMyBeaconRemovesPrivateBeacon() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new BeaconApi($configurationMock, $httpClient);

        $winguApi->deleteMyBeacon('8c798a67-0000-4000-a000-000000000007');

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('', $actualRequest->getBody()->getContents());
        self::assertSame('DELETE', $actualRequest->getMethod());
    }

    private function getExpectedMinimalPrivateListBeacon() : PrivateBeacon
    {
        return new PrivateBeacon(
            '30b30e6b-5bb1-439d-916e-a724cc4268ed',
            'Beacon 3',
            true,
            null,
            true,
            null,
            true,
            null,
            '3f104004-b288-4501-80c2-4ac30a02355b',
            3,
            3,
            null,
            new BeaconLocation(new BeaconAddress(null), null)
        );
    }

    private function getExpectedFullPrivateListBeacon() : PrivateBeacon
    {
        return new PrivateBeacon(
            '8c798a67-0000-4000-a000-000000000001',
            'Beacon 1100',
            true,
            new PrivateListContent('12d1da34-0000-4000-a000-000000000003', 'Deck 3 title'),
            true,
            'My note',
            true,
            $this->getExpectedFunctioningHours(),
            '2e422b9f-4955-4f1d-95d1-e57626ad1b26',
            1,
            100,
            'https://wingu-sdk-test.de/jEdFNYY',
            new BeaconLocation(new BeaconAddress('Germany'), new Coordinates(9.922292, 53.56581))
        );
    }

    private function getExpectedPrivateListBeaconWithEmptyTitle() : PrivateBeacon
    {
        return new PrivateBeacon(
            '8c798a67-0000-4000-a000-000000000002',
            'Beacon 1101',
            true,
            new PrivateListContent('12d1da34-0000-4000-a000-000000000002', null),
            true,
            'My note',
            true,
            $this->getExpectedFunctioningHours(),
            '2e422b9f-4955-4f1d-95d1-e57626ad1b26',
            1,
            101,
            null,
            new BeaconLocation(new BeaconAddress('Germany'), new Coordinates(9.858576, 53.618839))
        );
    }
}
