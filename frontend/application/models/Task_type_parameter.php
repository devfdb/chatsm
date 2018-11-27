<?php

class Task_type_parameter extends CI_Model
{
    function __construct()
    {
        $this->userTbl = 'task_type_parameter';
    }

    public function insert($data)
    {
        $this->db->insert('task_type_parameter', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function read($id)
    {
        $this->db->select('*');
        $this->db->from('task_type_parameter');
        $this->db->where('itp_type_id', $id);

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
        $this->db->from('task_type_parameter');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function update($id, $data)
    {
        $this->db->where('itp_id', $id);
        $this->db->update('task_type_parameter', $data);
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