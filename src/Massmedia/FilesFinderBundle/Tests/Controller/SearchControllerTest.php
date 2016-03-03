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

        $this->filesFinder->expects($this->once())->method('search')
            ->will($this->returnValue(['founded file name']));

        static::$kernel->getContainer()->set('massmedia.file_by_content', $this->filesFinder);

        $crawler = $client->request('POST', '/search', ['search' => 'test']);
    }
}
