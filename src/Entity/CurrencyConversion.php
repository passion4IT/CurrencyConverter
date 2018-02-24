<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyConversionRepository")
 */
class CurrencyConversion
{
    /**
     * @var \Ramsey\Uuid\Uuid
     *
     * @ORM\Id
     * @ORM\Column(type="string", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Doctrine\ORM\Id\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(name="euro", type="decimal", precision=1, nullable=false)
     */
    private $euroAmount;

    /**
     * @ORM\Column(name="dollar_equivalent", type="float", scale=6, nullable=false)
     */
    private $dollarEquivalent;

    /**
     * @ORM\Column(name="franc_equivalent", type="float", scale=6, nullable=false)
     */
    private $francEquivalent;

    /**
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     */
    private $timestamp;

    /**
     * CurrencyConversion constructor.
     * @param $euroAmount
     * @param $dollarEquivalent
     * @param $francEquivalent
     */
    public function __construct($euroAmount, $dollarEquivalent, $francEquivalent)
    {
        $this->id = Uuid::uuid4();
        $this->euroAmount = $euroAmount;
        $this->dollarEquivalent = $dollarEquivalent;
        $this->francEquivalent = $francEquivalent;
        $this->timestamp = new \DateTime();
    }

    /**
     * @return Uuid
     */
    public function getId():string
    {
        return $this->id;
    }

    /**
     * @return decimal
     */
    public function getEuroValue():int
    {
        return $this->euroAmount;
    }

    /**
     * @return double value
     */
    public function getUSDEquivalent():float
    {
        return $this->dollarEquivalent;
    }

    /**
     * @return double value
     */
    public function getFrancEquivalent():float
    {
        return $this->francEquivalent;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp():\DateTime
    {
        return $this->timestamp;
    }
}
