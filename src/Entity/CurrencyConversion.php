<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyConversionRepository")
 * @Serializer\ExclusionPolicy("all")
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
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @ORM\Column(name="euro", type="decimal", precision=1, nullable=false)
     * @Serializer\Expose()
     */
    private $euroAmount;

    /**
     * @ORM\Column(name="dollar_equivalent", type="float", scale=6, nullable=false)
     * @Serializer\Expose()
     */
    private $dollarEquivalent;

    /**
     * @ORM\Column(name="franc_equivalent", type="float", scale=6, nullable=false)
     * @Serializer\Expose()
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
}
