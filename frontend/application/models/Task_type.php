<?php

class Task_type extends CI_Model
{
    function __construct()
    {
        $this->userTbl = 'task_type';
    }

    public function insert($data)
    {
        $this->db->insert('task_type', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function read($id)
    {
        $this->db->select('*');
        $this->db->from('task_type');
        $this->db->where('ins_id', $id);
    }

    public function table()
    {
        $this->db->select('*');
        $this->db->from('task_type');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function update($id, $data)
    {
        $this->db->where('ins_id', $id);
        $this->db->update('task_type', $data);
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