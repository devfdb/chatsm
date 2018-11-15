<?php
class File extends CI_Model
{
    function __construct()
    {
    }

    public function insert($data)
    {
        $this->db->insert('file', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function read($id)
    {
        $this->db->select('*');
        $this->db->from('file');
        $this->db->where('file_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function table()
    {
        $this->db->select('*');
        $this->db->from('file');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function update($id, $data)
    {
        $this->db->where('file_id', $id);
        $this->db->update('file', $data);
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