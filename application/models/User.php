<?php

class User extends Base_Model
{
    protected $name;
    protected $portrait_url;

    public function __construct()
    {
        parent::__construct();
        $this->mapping_name = 'users';
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
    public function getPortraitUrl()
    {
        return $this->portrait_url;
    }

    /**
     * @param mixed $portrait_url
     */
    public function setPortraitUrl($portrait_url)
    {
        $this->portrait_url = $portrait_url;
    }
}
