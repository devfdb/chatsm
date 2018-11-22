<?php

class Processes extends CI_Controller
{
    public $reply;

    function __construct()
    {
        parent::__construct();
        $this->load->library('Template');
        $this->load->library('form_validation');
        $this->load->library('rabbitmq_client');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('user');
        $this->load->model('process');
        $this->load->model('file');
        $this->load->model('execution');

        $this->reply = array();

    }

    public function index()
    {
        $data['process_table'] = $this->process->table();
        $this->template->load('layout_admin', 'processes/process_index', $data);
    }

    public function execute()
    {
        // Recibe JSON desde cliente
        $request = $this->input->post('request');
        $json = file_get_contents('../backend/testdata.json');
        $json = str_replace(array("\r", "\n"), "", $json);
        $self = $this;
        $this->rabbitmq_client->push_with_response('tasks', $json, function ($message) use ($self, $request){
            $receive = json_decode($message);
            echo $receive['result'];
            if($receive['result'] == 'processing')
            {
                $data['exe_id'] = $receive['data']['id_execution'];
                $data['exe_status'] = $receive['result'];
                $data['exe_process_id'] = $request;
                $self->execution->insert($data);
            }
        });
        $this->rabbitmq_client->response;

        header('Content-Type: application/json');
        $arr = array(
            'response' => true,
            'content' => array('type' => 'nonaa')
        );
        echo json_encode($arr);
    }

    public function executions($process_id)
    {
        $project_folder = 'proy';
        $dir = '../repository/' . $project_folder . '/';

        $file_list = [];
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    $file_list[] = array('filename' => $file, 'filetype' => filetype($dir . $file));
                }
                closedir($dh);
            }
        }

        $data['process_table'] = [];

        $data['file_list'] = $file_list;
        $data['process_id'] = $process_id;
        $this->template->load('layout_admin', 'processes/process_executions', $data);
    }


    private function execute_process()
    {

    }

    public function create()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $data['file_list'] = $this->file->table_select();
            $this->template->load('layout_admin', 'processes/process_create', $data);

        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('name', 'nombre', 'trim|required');
            $this->form_validation->set_rules('input_id', 'archivo de entrada', 'trim|required');
            $this->form_validation->set_error_delimiters('<div style="color: red;">', '</div>');

            if ($this->form_validation->run()) {
                $data = array(
                    'prc_name' => $this->input->post('name'),
                    'prc_owner' => $this->session->userdata('userId'),
                    'prc_input' => $this->input->post('input_id')
                );
                $result = $this->process->insert($data);
                if ($result == TRUE) {
                    $data['message'] = json_encode(array('title' => 'Proceso creado exitosamente', 'type' => 'success'));
                    $data['file_list'] = $this->file->table_select();
                    $this->template->load('layout_admin', 'processes/process_create', $data);
                } else {
                    $data['message'] = json_encode(array('title' => 'No se pudo crear el proceso', 'type' => 'error'));
                    $data['file_list'] = $this->file->table_select();
                    $this->template->load('layout_admin', 'processes/process_create', $data);
                }
            } else {
                $data['message_display'] = validation_errors();
                $data['file_list'] = $this->file->table_select();
                $this->template->load('layout_admin', 'processes/process_create', $data);
            }
        }
    }

    public function edit($id)
    {
        $data['file_list'] = $this->file->table_select();
        $data['id'] = $id;
        $this->template->load('layout_admin', 'processes/process_edit', $data);
    }

    public function tree_json()
    {
        header('Content-Type: application/json');
        $arr = array(
            'id' => '5',
            'name' => 'test1',
            'data' => array('instance_id' => '1'),
            'children' => array(
                array(
                'id' => '1',
                'name' => 'test2',
                'data' => array('instance_id' => '3'),
                'children' => array(
                    array(
                    'id' => '2',
                    'name' => 'clean',
                    'data' => array('instance_id' => '4'),
                    'children' => array(),
                    )
                )
                )
            )
        );

        echo json_encode($arr);
    }

    public function define()
    {
        $data = array();

        // Verifica que usuario esté autenticado
        // if ($this->session->userdata('isUserLoggedIn')) {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $data['list_projects'] = $this->project->table_select();
            $data['project_id'] = $this->session->userdata('project_id');
            $this->template->load('layout_admin', 'projects/project_define', $data);

        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('project_id', 'proyecto', 'trim|required');
            if ($this->form_validation->run() == true) {
                $data['list_projects'] = $this->project->table_select();
                $this->session->set_userdata('project_id', $this->input->post('project_id'));
                $data['project_id'] = $this->session->userdata('project_id');
                $this->template->load('layout_admin', 'projects/project_define', $data);

            } else {
                redirect('projects', 'location');
            }

        }
        //} else {
        //    redirect('users/login');
        //}
    }

    public function parse_recursive_for_input($nodes, &$arr_ref, $id)
    {
        foreach($nodes as $item) {
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
            if($children != null) {
                $this->parse_recursive_for_input($children, $new_process['children'], $id);
            }
            array_push($arr_ref, $new_process);
        }
    }

    public function parse_to_json_for_input($id)
    {
        $curr_process = $this->process->read($id);
//        header('Content-Type: application/json');
        $arr = array(
            'project' => 'proy',
            'input' => $curr_process['prc_input'],
            'processes' => array(),
        );
        $nodes = $this->process->select_parents($id);
        $this->parse_recursive_for_input($nodes, $arr['processes'], $id);
        echo json_encode($arr);
    }

    public function parse_recursive_for_view($nodes, &$arr_ref, $id)
    {
        foreach($nodes as $item) {
            $task = $this->process->read_task($item['pcn_task_id']);
            $new_process = array(
                'id' => $item['pcn_id'],
                'name' => $task['ins_name'],
                'data' => array(
                    'instance_id' => $task['ins_id']
                ),
                'children' => array()
            );
            $children = $this->process->select_children($id, $item['pcn_id']);
            if($children != null) {
                $this->parse_recursive_for_view($children, $new_process['children'], $id);
            }
            array_push($arr_ref, $new_process);
        }
    }

    public function parse_to_json_for_view($id)
    {
//        header('Content-Type: application/json');
        $arr = array(
            'input' => array()
        ); # Array vacio que contendra al padre.
        $nodes = $this->process->select_parents($id);
        $this->parse_recursive_for_view($nodes, $arr['input'], $id);
        echo json_encode($arr);
    }


    public function run_process()
    {
        //Todo Completar
        $this->rabbitmq_client->push_with_response('task', $data, function ($message){

        });
        $this->rabbitmq_client->response;
    }

    public function process_listen()
    {
        $this->rabiitmq_client->pull('task',false,function ($message) {

            array_push($this->reply, $message->body);
        });
    }
}