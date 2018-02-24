<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyConversionRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class CurrencyConversion
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @ORM/Column(name="euro", type="decimal", precision=1, nullable=false)
     * @Serializer\Expose()
     */
    private $euroAmount;

    /**
     * @ORM/Column(name="dollar_equivalent", type="decimal", precision=6, nullable=false)
     * @Serializer\Expose()
     */
    private $dollarEquivalent;

    /**
     * @ORM/Column(name="franc_equivalent", type="decimal", precision=6, nullable=false)
     * @Serializer\Expose()
     */
    private $francEquivalent;

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
    }
}
