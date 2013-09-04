<?php

namespace Manhattan\PublicBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class PublicControllerTest extends WebTestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    public function testHomePage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue(200 === $client->getResponse()->getStatusCode(), 'Correct status code is returned when the page has been set correctly');
    }

    public function testContactForm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact-us');
        $this->assertEquals(1, $crawler->filter('h1:contains("Contact Us")')->count(), 'The "H1" tag contains correct header');

        sleep(4);
        // Enable the profiler for the next request (it does nothing if the profiler is not available)
        $client->enableProfiler();

        $form = $crawler->selectButton('Contact Us')->form(array(
            'contact[name]' => 'Name',
            'contact[phone]' => 'phone',
            'contact[message]' => 'You should see me from the profiler!'
        ));

        $crawler = $client->submit($form);

        $mailCollector = $client->getProfile()->getCollector('swiftmailer');

        // Check that an e-mail was sent
        $this->assertEquals(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertEquals('Contact Us', $message->getSubject());
        $this->assertEquals('webmaster@website.com', key($message->getFrom()));
        $this->assertEquals('webmaster@website.com', key($message->getTo()));
        $this->assertNotNull($message->getBody());

        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('h1:contains("Contact Us")')->count() > 0, 'Displays contact success page.');

        $this->assertEquals(1, $crawler->filter('h3:contains("Thank You. An email has been sent and someone will be in contact with you shortly.")')->count(), 'Displays flash message on success page.');
    }

    public function testSitemapHtml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/sitemap');

        $this->assertTrue(200 === $client->getResponse()->getStatusCode(), 'The Sitemap page displays correctly in html format.');
    }

    public function testSitemapXml()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/sitemap.xml');

        $this->assertTrue(200 === $client->getResponse()->getStatusCode(), 'The Sitemap page displays correctly in xml format.');

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'text/xml; charset=UTF-8'
            )
        );
    }

}
