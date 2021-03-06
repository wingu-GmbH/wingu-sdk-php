<?php

declare(strict_types=1);

namespace Wingu\Engine\SDK\Tests\Api\Channel\Nfc;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Wingu\Engine\SDK\Api\Channel\Nfc\NfcApi;
use Wingu\Engine\SDK\Api\Configuration;
use Wingu\Engine\SDK\Model\Request\BooleanValue;
use Wingu\Engine\SDK\Model\Request\Channel\Nfc\PrivateNfc as RequestNfc;
use Wingu\Engine\SDK\Model\Request\StringValue;
use Wingu\Engine\SDK\Model\Response\Card\Card;
use Wingu\Engine\SDK\Model\Response\Card\Position;
use Wingu\Engine\SDK\Model\Response\Channel\Nfc\PrivateNfc;
use Wingu\Engine\SDK\Model\Response\Channel\Nfc\PublicNfc;
use Wingu\Engine\SDK\Model\Response\Component\Action;
use Wingu\Engine\SDK\Model\Response\Component\AudioPlaylist;
use Wingu\Engine\SDK\Model\Response\Component\AudioPlaylistMedia as Media;
use Wingu\Engine\SDK\Model\Response\Component\BrandBar;
use Wingu\Engine\SDK\Model\Response\Component\BrandBarBackground;
use Wingu\Engine\SDK\Model\Response\Component\BrandBarImage;
use Wingu\Engine\SDK\Model\Response\Component\BrandBarText;
use Wingu\Engine\SDK\Model\Response\Component\Contact;
use Wingu\Engine\SDK\Model\Response\Component\ContactAddress;
use Wingu\Engine\SDK\Model\Response\Component\ContactExternalLinks;
use Wingu\Engine\SDK\Model\Response\Component\Coupon;
use Wingu\Engine\SDK\Model\Response\Component\CouponBarcode;
use Wingu\Engine\SDK\Model\Response\Component\Files;
use Wingu\Engine\SDK\Model\Response\Component\FilesFile as File;
use Wingu\Engine\SDK\Model\Response\Component\Html;
use Wingu\Engine\SDK\Model\Response\Component\Image;
use Wingu\Engine\SDK\Model\Response\Component\Image as InnerImage;
use Wingu\Engine\SDK\Model\Response\Component\ImageGallery;
use Wingu\Engine\SDK\Model\Response\Component\ImageGalleryImage as OuterImage;
use Wingu\Engine\SDK\Model\Response\Component\ImageMetadata;
use Wingu\Engine\SDK\Model\Response\Component\ImageMetadata as Metadata;
use Wingu\Engine\SDK\Model\Response\Component\Location;
use Wingu\Engine\SDK\Model\Response\Component\PrivateWebhook;
use Wingu\Engine\SDK\Model\Response\Component\Rating;
use Wingu\Engine\SDK\Model\Response\Component\Separator;
use Wingu\Engine\SDK\Model\Response\Component\SurveyMonkey;
use Wingu\Engine\SDK\Model\Response\Component\Text;
use Wingu\Engine\SDK\Model\Response\Component\Video;
use Wingu\Engine\SDK\Model\Response\Content\Deck;
use Wingu\Engine\SDK\Model\Response\Content\Locale;
use Wingu\Engine\SDK\Model\Response\Content\Pack;
use Wingu\Engine\SDK\Model\Response\Content\PrivateContent;
use Wingu\Engine\SDK\Model\Response\Content\PrivateListContent;
use Wingu\Engine\SDK\Model\Response\Coordinates;
use Wingu\Engine\SDK\Tests\Api\ChannelApiTestCase;
use Wingu\Engine\SDK\Tests\Api\Expected\Loader\PrivateComponent;

final class NfcApiTest extends ChannelApiTestCase
{
    use PrivateComponent;

    public function testNfcReturnsPublicNfc() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                $this->getDataFromFixturesFile('full_public_nfc.json')
            )
        );

        $winguApi = new NfcApi($configurationMock, $httpClient);
        $actual   = $winguApi->nfc('9a8798c6-0000-4000-a000-000000000001');

        $expected = new PublicNfc(
            '44da7d7e-0000-4000-a000-000000000011',
            'NFC 11',
            'https://wingu-sdk-test.de/nfc/0b852b82-c4b1-433d-9ddb-4f3175bb735d'
        );

        self::assertEquals($expected, $actual);
    }

    public function testMyNfcReturnsPrivateNfc() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                $this->getDataFromFixturesFile('full_private_nfc.json')
            )
        );

        $winguApi = new NfcApi($configurationMock, $httpClient);
        $actual   = $winguApi->myNfc('44da7d7e-0000-4000-a000-000000000001');

        $expected = new PrivateNfc(
            '44da7d7e-0000-4000-a000-000000000001',
            'NFC 1',
            true,
            new PrivateContent(
                '12d1da34-0000-4000-a000-000000000001',
                [
                    new Pack(
                        'c2863ebc-30bb-4de4-8dd9-ec6f0e60fc45',
                        new Deck(
                            'ea45b0c8-0000-4000-a000-000000000001',
                            'Deck 1 title',
                            'Deck description 1',
                            [
                                new Card(
                                    'ed926f82-bb9a-465e-9519-2569ddfa6944',
                                    new Position(0),
                                    new BrandBar(
                                        '9e8f2944-b313-486d-b69a-1f396de39aea',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        new BrandBarBackground('44f843'),
                                        new BrandBarText('wingu brand 1', 'left', '04b1f0'),
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
                                    'a8651426-ecc3-4a6e-958d-b36537c953c9',
                                    new Position(1),
                                    new Text(
                                        '221d0dbc-300e-4e9f-a8c0-280da8d2780b',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        "# Welcome!\n_Welcome in our coffee._\n## Website\nCheck out our [website](https://www.wingu.de)!  \n### Congratulations!\nYou won a **free** coffee! You can choose between:  \n1.  Gold  \n2.  Space Gray\n3.  Silver.\n\nIf you prefer you can even choose from an unordered list:\n\n*   Gold\n*   Space Gray\n*   Silver",
                                        'markdown'
                                    )
                                ),
                                new Card(
                                    'fb9b6b58-0f25-444f-87a4-ad8f99ccb259',
                                    new Position(2),
                                    new Html(
                                        '366fe217-5583-4492-8133-98d0ae08e11c',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n    <meta charset=\"utf-8\">\n    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->\n    <title>wingu HTML CMS</title>\n\n    <style type=\"text/css\">\n        .my_class {\n            color: #00b3ee;\n        }\n    </style>\n</head>\n<body>\n    <h1>Hello, world!</h1>\n    <table width=\"100%\">\n        <thead>\n            <tr>\n                <td>Col 1</td>\n                <td>Col 2</td>\n            </tr>\n        </thead>\n        <tbody>\n            <tr>\n                <td>var 1</td>\n                <td>var 2</td>\n            </tr>\n        </tbody>\n    </table>\n\n    <div class=\"my_class\">I am a nice HTML CMS component</div>\n    <img src=\"data:image/png;base64,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cQdqDJyDbMqwOGeZljJkaqsG+No56Kp4dpYcLm5c1DmKPTMylpX5JNQe74spu7H/PUUUavKcEg+poRjYifdU+dprRz44s+bInuMMbm9gHP/Q7daWuJ7M/o35Pm5y+3ok5ygaUsB4MqESeWoVj33DczDac75h4VjbWWONJmDLMaPRj3JcCEar2jveXRu1i/UxumgObu9pvgobmHRL70jO0ZGem+QccMQnNjk2JZkcexooIiIiCjURERGFmoiIiEJNREREoSYiIgo1ERERhZqIiIhCTURERKEmIiKiUBMREYWaiIiIQk1EREShJiIiolATERGFmoiIiEJNREREoSYiIqJQExERUaiJiIhCTURERKEmIiKiUBMREVGoiYiIQk1EREShJiIiolATERFRqImIiCjUREREoSYiIqJQExERUaiJiIgo1ERERKEmIiJynArxXmdBRETUUhMREVGoiYiIKNREREQUaiIiolATERFRqImIiCjUREREFGoiIqJQ0ykQERGFmoiIiEJNREREoSYiIqJQExERhZqIiIhCTURERKEmIiKiUBMREVGoiYiIQk1EREShJiIiolATERFRqImIiEJNREREoSYiIqJQExERUaiJiIgo1ERERKEmIiIyJf3/AQBNpzZbcVlQ8AAAAABJRU5ErkJggg==\">\n\n    <script type=\"application/javascript\">\n        alert('I should never run !!!!');\n    </script>\n</body>\n</html>\n"
                                    )
                                ),
                                new Card(
                                    'b444a9a6-5e3f-4163-90d0-5db4c9a5b126',
                                    new Position(3),
                                    new Video(
                                        'c8e57713-394c-4907-960f-417b22e38dc0',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        'youtube',
                                        'zfQdPcO--DA',
                                        'Video description'
                                    )
                                ),
                                new Card(
                                    '45fe4907-ee15-4075-8acc-e4c3ad7d6239',
                                    new Position(4),
                                    new ImageGallery(
                                        '9c8c409d-f0e2-4a1b-b45e-3ad18babec96',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        [
                                            new OuterImage(
                                                '4b512c62-2471-474b-8436-e9fce8542c46',
                                                0,
                                                new InnerImage(new Metadata('jpg', 864, 576), 'sample', 'cloudinary'),
                                                'caption'
                                            ),
                                        ]
                                    )
                                ),
                                new Card(
                                    '2359f21f-a537-4818-a23e-a87e6b2e037c',
                                    new Position(5),
                                    new SurveyMonkey(
                                        '677e7e0f-f62d-499b-89ef-4b5bde2802e5',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        'Take the IQ survey',
                                        'You will probably fail',
                                        'https://de.surveymonkey.com/r/5FBK8Z3'
                                    )
                                ),
                                new Card(
                                    '28a61904-d794-48fc-8fd0-083686e77a9c',
                                    new Position(6),
                                    new Contact(
                                        '8f757d19-22d9-49ac-b48d-2b08b7abad5a',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
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
                                            '18faf1a7-cb8f-42f7-8c90-397892dfc239',
                                            'DE',
                                            'Oststadt',
                                            '89081',
                                            'Kurfuerstendamm',
                                            '66'
                                        ),
                                        new ContactExternalLinks(
                                            '3ed7de54-82f5-4878-a2b1-cb037109fb79',
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
                                    'a3c2eceb-8f97-4e47-af4d-a2b1c15162dd',
                                    new Position(7),
                                    new Coupon(
                                        '5f6e0341-31d4-4d04-8edd-6c409a7fa6c2',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        '-20 %',
                                        'Get you cheap stuff here !',
                                        'Disclaimer',
                                        new CouponBarcode('EAN_13', '4000161100348'),
                                        null
                                    )
                                ),
                                new Card(
                                    '8e895618-4a1f-4bfc-8b5f-af1fa722e228',
                                    new Position(8),
                                    $this->getExpectedFormComponent()
                                ),
                                new Card(
                                    'e3034969-c23a-482a-90c4-1c02aee3863c',
                                    new Position(9),
                                    new Location(
                                        'f2d9c2e9-be24-48c5-8177-958b6e31edad',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        new Coordinates(10.233362, 53.614503),
                                        602
                                    )
                                ),
                                new Card(
                                    'd19f1f08-0754-4d49-b18f-dc3005d7218c',
                                    new Position(10),
                                    new AudioPlaylist(
                                        '7ff353a4-4b3e-4246-9e37-5f70c6f7d781',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        'Best of',
                                        [
                                            new Media(
                                                '483c009e-7555-44f1-acad-a2f8482ac5cb',
                                                0,
                                                'http://www.example.com/audioplaylist/audio_media.mp3',
                                                'David Guetta - Wing it',
                                                39,
                                                null
                                            ),
                                            new Media(
                                                'b55d59a0-9954-42c1-a0b8-f0a55e89ecdc',
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
                                    '8200fecb-05eb-4ffd-8a17-25f9862dd4d3',
                                    new Position(11),
                                    new Action(
                                        '4c370fe8-cc14-4593-bb8f-d8bef8264afe',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        'Speicher me',
                                        'open-url',
                                        'http://www.sp210.com/'
                                    )
                                ),
                                new Card(
                                    'f8cca409-1e25-475e-a69a-fffe9c92f6ce',
                                    new Position(12),
                                    new Separator(
                                        'e5bebec7-7d71-4e4d-9e7b-ac83bc87ae3e',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        'wave',
                                        '04b1f0'
                                    )
                                ),
                                new Card(
                                    '04096fc4-a8b2-46d9-936c-617824ebccd6',
                                    new Position(13),
                                    new Rating(
                                        'b7dc7594-e5db-4f0c-ac1a-234d1127cb57',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        'Rate me !'
                                    )
                                ),
                                new Card(
                                    'a78bde18-786a-42df-89be-f73a48715299',
                                    new Position(14),
                                    new PrivateWebhook(
                                        '296c7079-0539-4de1-b98f-85c9fe811c88',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        'Trigger me',
                                        'https://httpbin.org/status/200',
                                        'Success message!'
                                    )
                                ),
                                new Card(
                                    '79cf3230-8658-4b85-b8d9-a3a8caac7e7f',
                                    new Position(15),
                                    new Files(
                                        'a81700f1-83d1-4d1c-be86-37410b6a8d0a',
                                        new \DateTime('2018-05-18T08:22:41+0000'),
                                        [
                                            new File(
                                                '2d6a4c22-32e0-4c0a-bdae-cf0821d6b378',
                                                0,
                                                'http://www.example.com/files/wingu_presentation.pdf',
                                                'wingu presentation',
                                                900641
                                            ),
                                        ]
                                    )
                                ),
                            ],
                            'Legal note1'
                        ),
                        new Locale('angielski', 'en'),
                        new \DateTimeImmutable('2018-05-18T08:22:41+0000')
                    ),
                ]
            ),
            true,
            null,
            true,
            $this->getExpectedFunctioningHours(),
            'https://wingu-sdk-test.de/nfc/44da7d7e-0000-4000-a000-000000000001'
        );

        self::assertEquals($expected, $actual);
    }

    public function testPayloadReturnsNfcId() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                '{"id":"9a8798c6-0000-4000-a000-000000000004"}'
            )
        );

        $winguApi = new NfcApi($configurationMock, $httpClient);
        $actual   = $winguApi->payload('https://wingu-sdk-test.de/nfc/7a4b84eb-ae3f-4246-8a67-d16fbdd82595');

        self::assertSame('9a8798c6-0000-4000-a000-000000000004', $actual);
    }

    public function testMyNfcsReturnsResult() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $httpClient->addResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                $this->getDataFromFixturesFile('private_nfcs_list.json')
            )
        );

        $nfcApi = new NfcApi($configurationMock, $httpClient);
        $actual = $nfcApi->myNfcs();

        $expected = [
            $this->getExpectedMinimalPrivateListNfc(),
            $this->getExpectedFullPrivateListNfc(),
        ];

        self::assertCount(2, $actual);
        self::assertEquals($expected, \iterator_to_array($actual));
    }

    public function testPatchMyNfcUpdatesPrivateNfc() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new NfcApi($configurationMock, $httpClient);

        $winguApi->updateMyNfc(
            '44da7d7e-0000-4000-a000-000000000001',
            new RequestNfc(
                new StringValue(null),
                new StringValue('New NFC name'),
                null,
                new BooleanValue(false)
            )
        );

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame(
            '{"content":null,"name":"New NFC name","published":"0"}',
            $actualRequest->getBody()->getContents()
        );
        self::assertSame('PATCH', $actualRequest->getMethod());
    }

    public function testDeleteMyNfcRemovesPrivateNfc() : void
    {
        $configurationMock = new Configuration();

        $httpClient = self::createClient();
        $response   = new Response(
            204,
            ['Content-Type' => 'application/json']
        );
        $httpClient->addResponse($response);

        $winguApi = new NfcApi($configurationMock, $httpClient);

        $winguApi->deleteMyNfc('44da7d7e-0000-4000-a000-000000000013');

        /** @var RequestInterface $actualRequest */
        $actualRequest = $httpClient->getLastRequest();
        self::assertSame('', $actualRequest->getBody()->getContents());
        self::assertSame('DELETE', $actualRequest->getMethod());
    }

    private function getExpectedMinimalPrivateListNfc() : PrivateNfc
    {
        return new PrivateNfc(
            '44da7d7e-0000-4000-a000-000000000001',
            'NFC 1',
            true,
            null,
            true,
            null,
            true,
            null,
            'https://wingu-sdk-test.de/nfc/bfa952d5-1ac6-462f-8122-7a14619a7b9c'
        );
    }

    private function getExpectedFullPrivateListNfc() : PrivateNfc
    {
        return new PrivateNfc(
            '44da7d7e-0000-4000-a000-000000000002',
            'NFC 2',
            true,
            new PrivateListContent('12d1da34-0000-4000-a000-000000000009', 'Deck 9 title'),
            true,
            'My note',
            true,
            $this->getExpectedFunctioningHours(),
            'https://wingu-sdk-test.de/nfc/ad793979-3669-4c66-830b-d5ab4d9d4e23'
        );
    }
}
