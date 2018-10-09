<?php

class Image extends Base_Model
{
    protected $product_id;
    protected $url;
    protected $capital;

    public function __construct()
    {
        parent::__construct();
        $this->mapping_name = 'product_images';
    }

    public function product_images($product_id)
    {
        $sql = "SELECT url
                FROM product_images
                WHERE product_id = ?";
        $query = $this->db->query($sql, [$product_id]);

        return $this->serialized($query->result());
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getCapital()
    {
        return $this->capital;
    }

    /**
     * @param mixed $capital
     */
    public function setCapital($capital)
    {
        $this->capital = $capital;
    }
}
