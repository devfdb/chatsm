<?php
class Process extends CI_Model
{
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
        $this->db->where('prc_id', $id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0];
        } else {
            return null;
        }
    }

    public function select_parents($id)
    {
        $this->db->select('*');
        $this->db->from('process_node');
        $this->db->where('pcn_process_id', $id);
        $this->db->where('pcn_parent', null);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function select_children($id, $parent)
    {
        $this->db->select('*');
        $this->db->from('process_node');
        $this->db->where('pcn_process_id', $id);
        $this->db->where('pcn_parent', $parent);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function read_task($id)
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

    public function select_type_name($id)
    {
        $this->db->select('tst_name');
        $this->db->distinct(TRUE);
        $this->db->from('task_type');
        $this->db->where('tst_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array()[0];
            if ($result != null) {
                return $result;
            }
        } else {
            return array();
        }
    }

    public function select_instance_name($id)
    {
        $this->db->select('ins_name');
        $this->db->distinct(TRUE);
        $this->db->from('task_instance');
        $this->db->where('ins_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array()[0];
            if ($result != null) {
                return $result;
            }
        } else {
            return array();
        }
    }

    public function select_params($id)
    {
        $this->db->select('itp_name, inp_parameter_value');
        $this->db->from('task_instance_parameter');
        $this->db->join('task_type_parameter', 'inp_parameter_type_id=itp_id');
        $this->db->where('inp_instance_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            $arr = array();
            foreach ($results as $val){
                $arr[$val['itp_name']] = $val['inp_parameter_value'];
                }
            return $arr;
        } else {
            return array();
        }
    }

    public function table($id)
    {
        $this->db->select('*');
        $this->db->from('process');
        $this->db->where('prc_project_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function process_execution_table($id)
    {
        $this->db->select('*');
        $this->db->from('execution');
        $this->db->where('exe_process_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function process_name($id)   {
        $this->db->select('*');
        $this->db->from('process');
        $this->db->where('prc_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array()[0]['prc_name'];
        } else {
            return "Nombre simple.";
        }
    }

    public function table_select()
    {
        $instances = $this->table();
        $arr = array();
        foreach($instances as $item) {
            $arr[$item['prc_id']] = $item['prc_name'];
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