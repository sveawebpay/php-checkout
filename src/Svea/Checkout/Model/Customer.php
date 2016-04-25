<?php

namespace Svea\Checkout\Model;

class Customer
{
    /**
     * @var string $nationalId
     */
    private $nationalId;

    /**
     * @var boolean $isCompany
     */
    private $isCompany;

    /**
     * @var boolean $isMale Optional
     */
    private $isMale;

    /**
     * @var \DateTime $dateOfBirth Optional
     */
    private $dateOfBirth;

    /**
     * @return string
     */
    public function getNationalId()
    {
        return $this->nationalId;
    }

    /**
     * @param string $nationalId
     */
    public function setNationalId($nationalId)
    {
        $this->nationalId = $nationalId;
    }

    /**
     * @return boolean
     */
    public function isIsCompany()
    {
        return $this->isCompany;
    }

    /**
     * @param boolean $isCompany
     */
    public function setIsCompany($isCompany)
    {
        $this->isCompany = $isCompany;
    }

    /**
     * @return boolean
     */
    public function isIsMale()
    {
        return $this->isMale;
    }

    /**
     * @param boolean $isMale
     */
    public function setIsMale($isMale)
    {
        $this->isMale = $isMale;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param \DateTime $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }
}
