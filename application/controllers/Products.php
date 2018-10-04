<?php

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo 'Test';
    }

    public function detail($product_id)
    {
        echo $product_id;
    }
}