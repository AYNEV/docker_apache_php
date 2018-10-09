<?php

class Category extends Base_Model
{
    protected $name;

    public function __construct()
    {
        parent::__construct();
        $this->mapping_name = 'categories';
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
