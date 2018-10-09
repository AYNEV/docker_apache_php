<?php

class Comment extends Base_Model
{
    protected $user_id;
    protected $parent_id;
    protected $product_id;
    protected $comment;

    public function __construct()
    {
        parent::__construct();
        $this->mapping_name = 'product_comments';
    }

    public function product_comments($product_id, $page)
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
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param mixed $parent_id
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
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
}
