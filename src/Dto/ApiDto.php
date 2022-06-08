<?php

namespace App\Dto;

class ApiDto
{
    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var string|null
     */
    private ?string $priceUsd;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPriceUsd(): ?string
    {
        return $this->priceUsd;
    }

    /**
     * @param string|null $priceUsd
     */
    public function setPriceUsd(?string $priceUsd): void
    {
        $this->priceUsd = $priceUsd;
    }

}