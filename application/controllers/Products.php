<?php

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        echo '[GET] http://localhost/index.php/products/detail/{:product_id}';
    }

    public function detail($product_id)
    {
        $product_data = $this->primitive_product_data($product_id);

        if (!$product_data) {
            return null;
        }

        $product_data['keywords'] = $this->get_keywords($product_id);
        $product_data['images'] = $this->get_product_images($product_id);
        $product_data['assessments'] = $this->get_assessments($product_id);

        echo json_encode($product_data, JSON_UNESCAPED_UNICODE);
    }

    private function serialized($values)
    {
        $result = [];
        foreach ($values as $key => $value) {
            foreach ($value as $k => $v) {
                $result[] = $v;
            }
        }

        return $result;
    }

    private function get_assessments($product_id)
    {
        $sql = "SELECT
                  u.name, u.portrait_url AS user_portrait,
                  a.created_at, a.score, a.comment, a.image_url
                FROM product_assessments AS a
                INNER JOIN users AS u
                ON a.user_id = u.id AND a.product_id = ?
                ORDER BY a.id DESC";
        $query = $this->db->query($sql, [$product_id]);

        return $query->result();
    }

    private function get_product_images($product_id)
    {
        $sql = "SELECT url
                FROM product_images
                WHERE product_id = ?";
        $query = $this->db->query($sql, [$product_id]);

        return $this->serialized($query->result());
    }

    private function get_keywords($product_id)
    {
        $sql = "SELECT k.name AS keywords
                FROM products_keywords AS pk
                LEFT JOIN keywords AS k
                ON pk.keyword_id = k.id
                WHERE pk.product_id = ?";
        $query = $this->db->query($sql, [$product_id]);

        return $this->serialized($query->result());
    }

    private function primitive_product_data($product_id)
    {
        $sql = "SELECT
                  p.name, p.price, p.discounted_price, p.description,
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
        $query = $this->db->query($sql, [$product_id]);

        $result = $query->result_array()[0];

        $price = $result['price'];
        $discounted_price = $result['discounted_price'];
        if($price == $discounted_price) {
            $result['discounted_rate'] = 0;
        } else {
            $result['discounted_rate'] = floor(($price - $discounted_price) / $price * 100);
        }


        return $result;
    }
}
