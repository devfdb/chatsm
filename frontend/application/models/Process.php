<?php
class Process extends CI_Model
{
    public function insert($data)
    {
        $this->db->insert('process', $data);

        if ($this->db->affected_rows() > 0) {
            $a = $this->db->insert_id();
            return $a;
        } else {
            return null;
        }
    }

    public function insert_node($data)
    {
        $this->db->insert('process_node', $data);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function insert_execution_node($data)
    {
        $this->db->insert('execution_node', $data);

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

    public function replicate_process_tree($id, $parent_id, $exec_id)
    {
        $level_nodes = $this->select_children($id, $parent_id);
        if ($level_nodes) {
            foreach ($level_nodes as $node) {
                $this->create_execution_node($node, $exec_id);
                $this->replicate_process_tree($id, $node['pcn_id'], $exec_id);
            }
        } else {
            return null;
        }
    }

    public function create_execution_node($node, $exec_id)
    {
        $data = array(
            'ejn_parent' => $node['pcn_parent'],
            'ejn_task_id' => $node['pcn_task_id'],
            'ejn_execution_id' => $exec_id
        );
        $this->insert_execution_node($data);

        return null;
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
            else
            {
                return null;
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
            $result = $query->result_array();
            $first_result = $result[0];
            if ($result != null) {
                return $first_result;
            }
            else
            {
                return array();
            }
        }
        else {
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
        if ($id) {
            $this->db->where('prc_project_id', $id);
        }
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

    public function table_select($user_id)
    {
        $instances = $this->table($user_id);
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