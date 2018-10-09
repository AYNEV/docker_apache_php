<?php

class Product extends Base_Model
{
    protected $name;
    protected $price;
    protected $is_discount;
    protected $discounted_price;
    protected $discounted_rate;
    protected $description;
    protected $artist_id;
    protected $category_id;

    public function __construct()
    {
        parent::__construct();
        $this->mapping_name = 'products';
    }

    public function find_by($value, $key)
    {
        $sql = "SELECT
                  p.name, p.price, p.discounted_price, p.description, p.artist_id, p.category_id, p.is_discount,
                  u.name AS artist, u.portrait_url AS artist_portrait,
                  c.name AS category
                FROM
                  products AS p
                INNER JOIN
                  artist as a
                INNER JOIN
                  users as u
                INNER JOIN
                  categories AS c
                ON
                  p.artist_id = a.id AND a.user_id = u.id AND p.category_id = c.id
                WHERE p.id = ?";
        $query = $this->db->query($sql, [$value]);

        $result = $query->result_array();
        if (!$result) {
            return [];
        }
        $result = $result[0];

        $result['discounted_rate'] = 0;
        $price = $result['price'];
        $calc_cond = $result['is_discount'] and $price > 0;
        if($calc_cond) {
            $discounted_price = $result['discounted_price'];
            $result['discounted_rate'] = floor(($price - $discounted_price) / $price * 100);
        }

        return $result;
    }

    public function more_recommend($product_data, $product_id)
    {
        $sql = "SELECT p.id, p.name, i.url
                FROM products AS p
                INNER JOIN product_images AS i
                ON p.id = i.product_id AND p.artist_id = ? AND i.capital = 1 AND p.id != ?
                ORDER BY p.likes DESC
                LIMIT 4 OFFSET 0";

        $artist_id = $product_data['artist_id'];
        $query = $this->db->query($sql, [$artist_id, $product_id]);
        $result['by_artist'] = $query->result();

        $sql = "SELECT p.id, p.name, i.url
                FROM products AS p
                INNER JOIN product_images AS i
                ON p.id = i.product_id AND p.category_id = ? AND i.capital = 1 AND p.id != ?
                ORDER BY p.likes DESC
                LIMIT 10 OFFSET 0";
        $category_id = $product_data['category_id'];
        $query = $this->db->query($sql, [$category_id, $product_id]);
        $result['by_category'] = $query->result();

        return $result;
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
