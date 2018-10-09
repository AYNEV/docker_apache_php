<?php

class Artist extends Base_Model
{
    protected $user_id;

    public function __construct()
    {
        parent::__construct();
        $this->mapping_name = 'artist';
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
}
