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
            echo json_encode($product_data, JSON_UNESCAPED_UNICODE);
            exit;
        }

        $product_data['keywords'] = $this->get_keywords($product_id);
        $product_data['images'] = $this->get_product_images($product_id);
        $assessment_page = intval($this->input->get('a_page'));
        $product_data['assessments'] = $this->get_assessments($product_id, $assessment_page);
        $comment_page = intval($this->input->get('c_page'));
        $product_data['comments'] = $this->get_comments($product_id, $comment_page);

        echo json_encode($product_data, JSON_UNESCAPED_UNICODE);
    }

    private function get_comments($product_id, $page)
    {
        $limit = 10;
        $offset = $page ? ($page - 1) * $limit : 0;

        $sql = "SELECT
                  parent.id, parent.created_at, parent.name, parent.user_portrait, parent.comment,
                  child.reply
                FROM
                  (SELECT
                    parent.id, parent.user_id, parent.parent_id, parent.comment, parent.created_at,
                    u.name, u.portrait_url AS user_portrait
                  FROM
                    product_comments AS parent
                  INNER JOIN
                    users AS u
                  ON
                    parent.user_id = u.id AND parent_id is null AND parent.product_id = ?
                  LIMIT ? OFFSET ?) as parent
                LEFT JOIN
                  (SELECT parent_id, comment AS reply FROM product_comments WHERE parent_id is not null) AS child
                ON
                  parent.id = child.parent_id
                ORDER BY parent.id DESC";
        $query = $this->db->query($sql, [$product_id, $limit, $offset]);
        $result['list'] = $query->result();
        $result['page'] = $page ? $page : 1;

        return $result;
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

    private function get_assessments($product_id, $page)
    {
        $limit = 10;
        $offset = $page ? ($page - 1) * $limit : 0;

        $sql = "SELECT
                  SQL_CALC_FOUND_ROWS
                  u.name, u.portrait_url AS user_portrait,
                  a.created_at, a.score, a.comment, a.image_url
                FROM product_assessments AS a
                INNER JOIN users AS u
                ON a.user_id = u.id AND a.product_id = ?
                ORDER BY a.id DESC
                LIMIT ? OFFSET ?";
        $query = $this->db->query($sql, [$product_id, $limit, $offset]);

        $result['list'] = $query->result();
        $result['page'] = $page ? $page : 1;
        $sql = "SELECT FOUND_ROWS() AS total_row;";
        $query = $this->db->query($sql);
        $total_row = $query->result_array()[0]['total_row'];
        $result['total_row'] = intval($total_row);

        return $result;
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

        $result = $query->result_array();
        if (!$result) {
            return [];
        }
        $result = $result[0];

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
