<?php
/**
 * Created by PhpStorm.
 * User: venya
 * Date: 2018. 10. 5.
 * Time: AM 8:07
 */

class Base_Model extends CI_Model
{
    protected $mapping_name = '';

    private $id;
    private $created_at;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get($value=false, $key=false)
    {
        if ($value === false) {
            return $this->get_all();
        }
        return $this->get_one($value, $key);

    }

    private function get_all()
    {
        $query = $this->db->get($this->mapping_name);
        return $query->result_array();
    }

    private function get_one($value, $key){
        $cond = ($key === false)? 'id' : $key;

        $query = $this->db->get_where($this->mapping_name, [$cond => $value]);
        return $query->result_array();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
}