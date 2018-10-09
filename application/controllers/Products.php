<?php

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo '[GET] http://localhost/index.php/products/detail/{:product_id}';
    }

    public function detail($product_id)
    {
        $this->load->database();

        $this->load->model('product');
        $this->load->model('keyword');
        $this->load->model('image');
        $this->load->model('assessment');
        $this->load->model('comment');

        $result = $this->product->get($product_id);
        if (!$result) {
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            return;
        }

        $result['recommend_products'] = $this->product->more_recommend($result, $product_id);

        $result['keyword'] = $this->keyword->get_products_keywords($product_id);
        $result['images'] = $this->image->product_images($product_id);

        $assessment_page = intval($this->input->get('a_page'));
        $result['assessments'] = $this->assessment->product_assessments($product_id, $assessment_page);

        $comment_page = intval($this->input->get('c_page'));
        $result['comments'] = $this->comment->product_comments($product_id, $comment_page);

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
