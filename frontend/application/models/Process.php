<?php
class Process extends CI_Model
{
    function __construct()
    {
    }

    public function insert($data)
    {
        $this->db->insert('process', $data);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function read($id)
    {
        $this->db->select('*');
        $this->db->from('process');
        $this->db->where('ins_id', $id);

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
        $this->db->from('process');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function table_select()
    {
        $instances = $this->table();
        $arr = array();
        foreach($instances as $item) {
            $arr[$item['prj_id']] = $item['prj_name'];
        }
        return $arr;
    }

    public function update($id, $data)
    {
        $this->db->where('ins_id', $id);
        $this->db->update('process', $data);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
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