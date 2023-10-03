<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:"satellites")]
#[ORM\Entity]
class Satellite
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    private int $id;

    #[ORM\Column(name: "domain", type: "string", length: 255, nullable: false)]
    private string $domain;

    #[ORM\Column(name: "recovery_link", type: "text", length: 65535, nullable: false)]
    private string $recoveryLink;

    #[ORM\Column(name: "flight_date_label_translation_key", type: "string", length: 255, nullable: false)]
    private string $flightDateLabelTranslationKey;

    #[ORM\Column(name: "visa_type_key_name", type: "string", length: 255, nullable: true)]
    private ?string $visaTypeKeyName;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    public function getRecoveryLink(): string
    {
        return $this->recoveryLink;
    }

    public function setRecoveryLink(string $recoveryLink): void
    {
        $this->recoveryLink = $recoveryLink;
    }

    public function getFlightDateLabelTranslationKey(): string
    {
        return $this->flightDateLabelTranslationKey;
    }

    public function setFlightDateLabelTranslationKey(string $flightDateLabelTranslationKey): void
    {
        $this->flightDateLabelTranslationKey = $flightDateLabelTranslationKey;
    }

    public function getVisaTypeKeyName(): ?string
    {
        return $this->visaTypeKeyName;
    }

    public function setVisaTypeKeyName(?string $visaTypeKeyName): void
    {
        $this->visaTypeKeyName = $visaTypeKeyName;
    }
}
