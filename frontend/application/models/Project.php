<?php
class Project extends CI_Model
{
    function __construct()
    {
        $this->userTbl = 'task_instance';
    }

    public function insert($data)
    {
        $this->db->insert('project', $data);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function read($id)
    {
        $this->db->select('*');
        $this->db->from('project');
        $this->db->where('prj_id', $id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0];
        } else {
            return null;
        }
    }

    public function table($userId)
    {
        $this->db->select('*');
        $this->db->from('project');
        $this->db->where('prj_owner', $userId);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function table_select($userId)
    {
        $instances = $this->table($userId);
        $arr = array();
        foreach($instances as $item) {
            $arr[$item['prj_id']] = $item['prj_name'];
        }
        return $arr;
    }

    public function update($id, $data)
    {
        $this->db->where('prj_id', $id);
        $this->db->update('project', $data);
        return $this->read($id);
    }


    public function delete($id)
    {
        $this->db->where('prj_id', $id);
        $this->db->delete('project');

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function parse_to_db($data)
    {

    }

    public  function parse_to_form($data)
    {

    }
}