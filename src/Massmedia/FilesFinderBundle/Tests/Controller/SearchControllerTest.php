<?php

namespace Massmedia\FilesFinderBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchControllerTest extends WebTestCase
{

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $filesFinder;


    /**
     * Generate files to search
     */
    public function setUp()
    {

        $this->client = static::createClient();
        $this->filesFinder = $this->getMockBuilder('Massmedia\FilesFinderBundle\Services\FilesFinder')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testSearchIndex()
    {

        $crawler = $this->client->request('GET', '/search');

        $this->assertEquals(1, $crawler->filter('input[name="form[search]"]')->count());
    }

    public function testSearchResultFounded()
    {
        $client = static::createClient();

        $foundedFileName = 'founded file name';
        $this->filesFinder->expects($this->once())->method('search')
            ->with($this->isType('string'), $this->equalTo($foundedFileName))
            ->will($this->returnValue([$foundedFileName]));

        $client->getContainer()->set('massmedia.files_finder', $this->filesFinder);
        $crawler = $client->request('POST', '/search', [
            'form' => [
                'search' => $foundedFileName,
                '_token' => $client->getContainer()->get('form.csrf_provider')->generateCsrfToken('form'),
            ]
        ]);

        $this->assertEquals(1, $crawler->filter("#results:contains(\"$foundedFileName\")")->count());
    }

    public function testSearchResultNoFounded()
    {
        $client = static::createClient();
        $foundedFileName = 'founded file name';

        $this->filesFinder->expects($this->once())->method('search')
            ->with($this->isType('string'), $this->equalTo($foundedFileName))
            ->will($this->returnValue([]));

        $client->getContainer()->set('massmedia.files_finder', $this->filesFinder);
        $crawler = $client->request('POST', '/search', [
            'form' => [
                'search' => $foundedFileName,
                '_token' => $client->getContainer()->get('form.csrf_provider')->generateCsrfToken('form'),
            ]
        ]);

        $this->assertEquals(1, $crawler->filter('#no_files')->count());
    }
}
