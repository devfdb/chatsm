<?php

class Task_instance extends CI_Model
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

    public function read($id)
    {
        $this->db->select('*');
        $this->db->from('task_instance');
        $this->db->where('ins_id', $id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0];
        } else {
            return null;
        }
    }

    public function table($project_id)
    {
        $this->db->select('*');
        $this->db->from('task_instance');
        $this->db->where('ins_project_id', $project_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function update($id, $data)
    {
        $this->db->where('ins_id', $id);
        $this->db->update('task_instance', $data);
        return $this->read($id);
    }

    public function delete($id)
    {
        $this->db->where('ins_id', $id);
        $this->db->delete('task_instance');

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function parse_to_db($data)
    {

    }

    public function parse_to_form($data)
    {

    }
    public function countTaskInstances($user)    {
        return 1;
    }
    public function getInstance($id)    {
        $this->db->select('ins_name');
        $this->db->from('task_instance');
        $this->db->where('ins_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0]['ins_name'];
        } else {
            return null;
        }
    }
}