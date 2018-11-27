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

    public function table($parent_id, $project_id)
    {
        $this->db->select('*');
        $this->db->from('file');
        $this->db->where('fil_parent_id', $parent_id);
        $this->db->where('fil_associated_project_id', $project_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function curr_file_id($project_id)
    {
        $this->db->select('fil_id');
        $this->db->from('file');
        $this->db->where('fil_associated_project_id', $project_id);
        $this->db->where('fil_parent_id IS NULL', null);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0]['fil_id'];
        } else {
            return null;
        }
    }

    public function curr_dir($dir_id, $project_id)
    {
        $this->db->select('fil_filename');
        $this->db->from('file');
        $this->db->where('fil_associated_project_id', $project_id);
        $this->db->where('fil_parent_id IS NULL', null);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0]['fil_filename'];
        } else {
            return array();
        }
    }

    public function last_folder_id($dir_id)
    {
        $this->db->select('fil_parent_id');
        $this->db->from('file');
        $this->db->where('fil_id', $dir_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0]['fil_parent_id'];
        } else {
            return array();
        }
    }

    public function curr_dir_path($dir_id)
    {
        $this->db->select('fil_url');
        $this->db->from('file');
        $this->db->where('fil_id', $dir_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0]['fil_url'];
        } else {
            return array();
        }
    }

    public function table_select()
    {
        $instances = $this->table();
        $arr = array();
        foreach($instances as $item) {
            $arr[$item['fil_id']] = $item['fil_filename'];
        }
        return $arr;
    }

    public function update($id, $data)
    {
        $this->db->where('file_id', $id);
        $this->db->update('file', $data);
    }



    public function parse_to_db($data)
    {

    }

    public  function parse_to_form($data)
    {

    }

    public function file_end($var)
    {
        $images = array('png', 'jpg', 'gif', 'jpeg');
        $other = array('pdf', 'json', 'csv');
        $type = explode('.', $var);
        $step = (string)(count($type)-1);
        $stype = $type[$step];
        if (in_array($stype, $images)) {
            return 'image';
        } else {
            foreach ($other as $format) {
                if ($stype == $format) {
                    return $format;
                }
            }
        }
    }
}