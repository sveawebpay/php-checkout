<?php

namespace Svea\Checkout\Model;

class PrepopulatedOrderItems
{
    private $nationalId;

    private $lockNationalId;

    private $isCompany;

    private $lockIsCompany;

    private $zipCode;

    private $lockZipCode;

    private $emailAddress;

    private $lockEmailAddress;

    private $phoneNumber;

    private $lockPhoneNumber;

    /**
     * @return mixed
     */
    public function getNationalId()
    {
        return $this->nationalId;
    }

    /**
     * @param mixed $nationalId
     */
    public function setNationalId($nationalId)
    {
        $this->nationalId = $nationalId;
    }

    /**
     * @return mixed
     */
    public function getLockNationalId()
    {
        return $this->lockNationalId;
    }

    /**
     * @param mixed $lockNationalId
     */
    public function setLockNationalId($lockNationalId)
    {
        $this->lockNationalId = $lockNationalId;
    }

    /**
     * @return mixed
     */
    public function getIsCompany()
    {
        return $this->isCompany;
    }

    /**
     * @param mixed $isCompany
     */
    public function setIsCompany($isCompany)
    {
        $this->isCompany = $isCompany;
    }

    /**
     * @return mixed
     */
    public function getLockIsCompany()
    {
        return $this->lockIsCompany;
    }

    /**
     * @param mixed $lockIsCompany
     */
    public function setLockIsCompany($lockIsCompany)
    {
        $this->lockIsCompany = $lockIsCompany;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return mixed
     */
    public function getLockZipCode()
    {
        return $this->lockZipCode;
    }

    /**
     * @param mixed $lockZipCode
     */
    public function setLockZipCode($lockZipCode)
    {
        $this->lockZipCode = $lockZipCode;
    }

    /**
     * @return mixed
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param mixed $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return mixed
     */
    public function getLockEmailAddress()
    {
        return $this->lockEmailAddress;
    }

    /**
     * @param mixed $lockEmailAddress
     */
    public function setLockEmailAddress($lockEmailAddress)
    {
        $this->lockEmailAddress = $lockEmailAddress;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getLockPhoneNumber()
    {
        return $this->lockPhoneNumber;
    }

    /**
     * @param mixed $lockPhoneNumber
     */
    public function setLockPhoneNumber($lockPhoneNumber)
    {
        $this->lockPhoneNumber = $lockPhoneNumber;
    }
}
