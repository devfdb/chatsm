<?php

class Task_type extends CI_Model
{
    function __construct()
    {
        $this->userTbl = 'task_type';
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

}