<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Satellites
 *
 * @ORM\Table(name="satellites")
 * @ORM\Entity
 */
class Satellites
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=false)
     */
    private $domain;

    /**
     * @var string
     *
     * @ORM\Column(name="recovery_link", type="text", length=65535, nullable=false)
     */
    private $recoveryLink;

    /**
     * @var string
     *
     * @ORM\Column(name="flight_date_label_translation_key", type="string", length=255, nullable=false)
     */
    private $flightDateLabelTranslationKey;

    /**
     * @var string|null
     *
     * @ORM\Column(name="visa_type_key_name", type="string", length=255, nullable=true)
     */
    private $visaTypeKeyName;


}
