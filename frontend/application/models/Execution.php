<?php

class Execution extends CI_Model
{
    public function insert($data)
    {
        $this->db->insert('execution', $data);
        if ($this->db->affected_rows() > 0) {
            $a = $data['exe_id'];
            return $a;
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

    public function update($id, $json)
    {

        $this->db->where('exe_id', $id);
        $this->db->update('execution', array('exe_status' => 'terminado', 'exe_output' => $json));

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function update_execution_table($data, $id)
    {
        foreach($data as $item) {
            echo $item;
            $this->update_execution_row($item, $id);
            $this->update_execution_table($item->children, $id);
        }
    }

    public function update_execution_row($data, $id)
    {
        $this->db->where('ejn_id', $data->id);
        $this->db->where('ejn_execution_id', $id);
        # TODO pasar output en el json para usar esta linea $this->db->update('execution_node', array('ejn_output' => $data->output));
    }

    public function delete($where)
    {

    }

    public function countExecutedProcesses($user)    {
        return 1;
    }
}