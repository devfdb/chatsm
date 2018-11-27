<?php

class Execution extends CI_Model
{
    public function insert($data)
    {
        $this->db->insert('execution', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function read($id)
    {
        $this->db->select('*');
        $this->db->from('execution');
        $this->db->where('exe_id', $id);

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
        $this->db->from('execution');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function update($id)
    {

        $this->db->where('exe_id', $id);
        $this->db->update('execution', array('exe_status' => 'terminado'));

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function delete($where)
    {

    }

    public function countExecutedProcesses($user)    {
        return 1;
    }
}