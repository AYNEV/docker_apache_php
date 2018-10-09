<?php

class Keyword extends Base_Model
{
    protected $name;

    public function __construct()
    {
        parent::__construct();
        $this->mapping_name = "keywords";
    }

    public function get_products_keywords($product_id)
    {
        $sql = "SELECT k.name AS keywords
                FROM products_keywords AS pk
                LEFT JOIN keywords AS k
                ON pk.keyword_id = k.id
                WHERE pk.product_id = ?";
        $query = $this->db->query($sql, [$product_id]);

        return $this->serialized($query->result());
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
}
