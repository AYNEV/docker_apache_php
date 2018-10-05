<?php

class Product extends Base_Model
{
    private $name;
    private $price;
    private $is_discount;
    private $discounted_price;
    private $discounted_rate;
    private $description;
    private $artist_id;
    private $category_id;

    public function __construct()
    {
        parent::__construct();
        $this->mapping_name = 'products';
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getisDiscount()
    {
        return $this->is_discount;
    }

    /**
     * @param mixed $is_discount
     */
    public function setIsDiscount($is_discount)
    {
        $this->is_discount = $is_discount;
    }

    /**
     * @return mixed
     */
    public function getDiscountedPrice()
    {
        return $this->discounted_price;
    }

    /**
     * @param mixed $discounted_price
     */
    public function setDiscountedPrice($discounted_price)
    {
        $this->discounted_price = $discounted_price;
    }

    /**
     * @return mixed
     */
    public function getDiscountedRate()
    {
        return $this->discounted_rate;
    }

    /**
     * @param mixed $discounted_rate
     */
    public function setDiscountedRate($discounted_rate)
    {
        $this->discounted_rate = $discounted_rate;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getArtistId()
    {
        return $this->artist_id;
    }

    /**
     * @param mixed $artist_id
     */
    public function setArtistId($artist_id)
    {
        $this->artist_id = $artist_id;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }
}
