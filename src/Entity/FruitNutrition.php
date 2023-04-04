<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class FruitNutrition
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $carbohydrates;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $protein;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $fat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $calories;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $sugar;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fruit", inversedBy="fruitNutritions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fruit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarbohydrates(): ?float
    {
        return $this->carbohydrates;
    }

    public function setCarbohydrates(?float $carbohydrates): self
    {
        $this->carbohydrates = $carbohydrates;

        return $this;
    }

    public function getProtein(): ?float
    {
        return $this->protein;
    }

    public function setProtein(?float $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getFat(): ?float
    {
        return $this->fat;
    }

    public function setFat(?float $fat): self
    {
        $this->fat = $fat;

        return $this;
    }

    public function getCalories(): ?float
    {
        return $this->calories;
    }

    public function setCalories(?float $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    public function getSugar(): ?float
    {
        return $this->sugar;
    }

    public function setSugar(?float $sugar): self
    {
        $this->sugar = $sugar;

        return $this;
    }

    public function getFruit(): ?Fruit
    {
        return $this->fruit;
    }

    public function setFruit(?Fruit $fruit): self
    {
        $this->fruit = $fruit;

        return $this;
    }
}