<?php

namespace Manhattan\PublicBundle\Tests\Entity;

use Manhattan\PublicBundle\Entity\Contact;

/**
 * ContactTest
 *
 * @author James Rickard <james@frodosghost.com>
 */
class ContactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test happens field
     */
    public function testTimeAfterSubmission()
    {
        $contact = new Contact();

        $this->assertFalse($contact->isHuman(), '->isHuman() returns false because function is called within 5 seconds of being called.');

        // This is a sleep function. I used this because the function it time based. Don't hurt me.
        sleep(4);
        $this->assertTrue($contact->isHuman(), '->isHuman() returns true after waiting 3 seconds of being called.');
    }

    public function testKnowledge()
    {
        $contact = new Contact();
        $contact->setKnowledge('test');

        $this->assertFalse($contact->isHuman(), '->isHuman() returns false because function is called within 3 seconds of being called.');

        // This is a sleep function. I used this because the function it time based. Don't hurt me.
        sleep(4);
        $this->assertFalse($contact->isHuman(), '->isHuman() returns false because the hidden honeypot field has content.');
    }

}
