<?php

class Task_instance_parameter extends CI_Model
{
    function __construct()
    {
        $this->userTbl = 'task_instance_parameter';
    }

    public function insert($data)
    {
        $this->db->insert('task_instance_parameter', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function read($id)
    {
        $this->db->select('*');
        $this->db->from('task_instance_parameter');
        $this->db->where('inp_instance_id', $id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0];
        } else {
            return null;
        }
    }

    public function table()
    {
        $this->db->select('*');
        $this->db->from('task_instance_parameter');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function update($id, $data)
    {
        $this->db->where('inp_instance_id', $id);
        $this->db->update('task_instance_parameter', $data);
    }
}