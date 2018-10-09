<?php

class Assessment extends Base_Model
{
    protected $user_id;
    protected $product_id;
    protected $score;
    protected $comment;
    protected $image_url;

    public function __construct()
    {
        parent::__construct();
        $this->mapping_name = 'product_assessments';
    }

    public function product_assessments($product_id, $page)
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

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
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
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * @param mixed $image_url
     */
    public function setImageUrl($image_url)
    {
        $this->image_url = $image_url;
    }
}
