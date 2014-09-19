<?php

/*
 * This file is part of the Manhattan Public Bundle
 *
 * (c) James Rickard <james@frodosghost.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Manhattan\PublicBundle\Entity;

/**
 * Manhattan\PublicBundle\Contact
 *
 * This class is used for populating from the Contact form so we can use
 * objects instead of arrays.
 */
class Contact
{
    /**
    * @var string
    */
    private $name;

    /**
    * @var string
    */
    private $company;

    /**
    * @var string
    */
    private $email;

    /**
    * @var string
    */
    private $phone;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    /**
     * Honeypot field to measure time delay for submission
     */
    private $happens;

    /**
     * Honeypot field
     */
    private $knowledge;


    public function __construct()
    {
        $this->subject = 'general';
        $this->happens = new \DateTime();
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Has email
     *
     * @return Boolean
     */
    public function hasEmail()
    {
        return ($this->email !== null && $this->email !== '');
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Has phone
     *
     * @return Boolean
     */
    public function hasPhone()
    {
        return ($this->phone !== null && $this->phone !== '');
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setKnowledge($knowledge)
    {
        $this->knowledge = $knowledge;

        return $this;
    }

    public function getKnowledge()
    {
        return $this->knowledge;
    }

    public function setHappens($happens)
    {
        $this->happens = $happens;

        return $this;
    }

    public function getHappens()
    {
        return $this->happens;
    }

    /**
     * Used to validate new Enquiries to ensure that either Contact field is provided
     *
     * @return boolean
     */
    public function isContactValid()
    {
        return ($this->hasPhone() || $this->hasEmail());
    }

    /**
     * Determines from Honeypot fields is the submission is human or likely bot submission
     *
     * @return boolean
     */
    public function isHuman()
    {
        if (($this->knowledge == null || $this->knowledge == '')) {
            $time = new \DateTime();
            $time->sub(new \DateInterval('PT3S'));

            if ($this->happens < $time) {
                return true;
            }
        }

        return false;
    }

}
