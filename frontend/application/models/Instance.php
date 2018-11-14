<?php
class Instance extends CI_Model
{
    function __construct()
    {
        $this->userTbl = 'task_instance';
    }

    public function insert($data)
    {
        $this->db->insert('task_instance', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function read($data)
    {

    }

    public function update($data, $where)
    {

    }

    public function delete($where)
    {

    }

    public function parse_to_db($data)
    {

    }

    public  function parse_to_form($data)
    {

    }
}