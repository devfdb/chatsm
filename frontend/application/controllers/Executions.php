<?php
class Executions extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('Template');
        $this->load->model('process');
        $this->load->model('execution');
    }

    public function executions($process_id)
    {
        $data['execution_table'] = $this->process->process_execution_table($process_id);
        $data['process_name'] = $this->process->process_name($process_id);
        $data['process_id'] = $process_id;
        $this->template->load('layout_admin', 'processes/process_executions', $data);
    }

    public function parse_recursive_for_input($nodes, &$arr_ref, $id)
    {
        foreach ($nodes as $item) {
            $task = $this->process->read_task($item['pcn_task_id']);
            $new_process = array(
                'id' => $item['pcn_id'],
                'task' => array(
                    'name' => $this->process->select_type_name($task['ins_type_id'])['tst_name'],
                    'params' => $this->process->select_params($task['ins_id'])
                ),
                'children' => array()
            );
            $children = $this->process->select_children($id, $item['pcn_id']);
            if ($children != null) {
                $this->parse_recursive_for_input($children, $new_process['children'], $id);
            }
            array_push($arr_ref, $new_process);
        }
    }

    public function parse_to_json_for_input($id)
    {
        $curr_process = $this->process->read($id);
//        header('Content-Type: application/json');
		$pid = $this->session->userdata('project_id');
		$proj_name = $this->project->read($pid)['prj_name'];
        $arr = array(
            'project' => $proj_name,
            'input' => $curr_process['prc_input'].'.csv',
            'processes' => array(),
        );
        $nodes = $this->process->select_parents($id);
        $this->parse_recursive_for_input($nodes, $arr['processes'], $id);

        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    public function parse_to_json_for_input2($id)
    {
        $curr_process = $this->process->read($id);
//        header('Content-Type: application/json');
        $pid = $this->session->userdata('project_id');
        $proj_name = $this->project->read($pid)['prj_name'];
        $arr = array(
            'project' => $proj_name,
            'input' => $this->file->read($curr_process['prc_input'])[0]['fil_filename'],
            'processes' => array(),
        );
        $nodes = $this->process->select_parents($id);
        $this->parse_recursive_for_input($nodes, $arr['processes'], $id);

        header('Content-Type: application/json');
        return json_encode($arr);
    }

    public function parse_recursive_for_view($nodes, &$arr_ref, $id)
    {
        if (count($nodes) > 0) {
            foreach ($nodes as $item) {
                $task = $this->execution->read_task($item['exn_task_id']);
                $new_process = array(
                    'id' => $item['exn_id'],
                    'name' => $task['ins_name'],
                    'data' => array(
                        'instance_id' => $task['ins_id'],
                        'ex_time' => (strtotime($item['exn_stop_time']) - strtotime($item['exn_start_time'])) . ' segundos',
                    ),
                    'children' => array()
                );
                $children = $this->execution->select_children($id, $item['exn_id']);
                if ($children != null) {
                    $this->parse_recursive_for_view($children, $new_process['children'], $id);
                }
                array_push($arr_ref, $new_process);
            }
        } else {
            return array();
        }
    }

    public function parse_to_json_for_view($id)
    {
//        header('Content-Type: application/json');
        $arr = array(
            'input' => array()
        ); # Array vacio que contendra al padre.
        $nodes = $this->execution->select_parents($id);
        $this->parse_recursive_for_view($nodes, $arr['input'], $id);
        echo json_encode($arr);
    }

    public function new_node()
    {
        // Recupera nodo padre
        $tree_input = json_decode(file_get_contents('php://input'), true);
        $parent_data = $tree_input['parent'];
        $child_data = array(
            'name' => $this->task_instance->getInstance($tree_input['new']['instance_id']),
            'id' => $tree_input['new']['instance_id']
        );

        if ($parent_data == null) {
            $data = array(
                'pcn_parent' => null,
                'pcn_task_id' => $child_data['id'],
                'pcn_process_id' => $tree_input['process_id']
            );
        } else {
            $data = array(
                'pcn_parent' => $parent_data['id'],
                'pcn_task_id' => $child_data['id'],
                'pcn_process_id' => $tree_input['process_id']
            );
        }
        $result = $this->process->insert_node($data);
        if ($result) {
            echo json_encode(
                array(
                    'id' => $result,
                    'text' => $child_data['name'],
                    'data' => array(
                        'instance_id' => $child_data['id']
                    ),
                    'children' => array()
                )
            );
        } else {
            echo json_encode(
                array(
                    'output' => 'error'
                )
            );
        }
        // TODO: Agregar nuevo nodo a base de datos

    }
}