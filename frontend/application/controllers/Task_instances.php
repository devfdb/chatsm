<?php
/**
 * Created by PhpStorm.
 * User: fdiazb
 * Date: 07-11-2018
 * Time: 16:16
 */
//use PhpAmqpLib\Connection\AMQPStreamConnection;
//use PhpAmqpLib\Message\AMQPMessage;

class Task_instances extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Template');
        $this->load->library('form_validation');
        //$this->load->library('rabbitmq_client');
        $this->load->helper('form');
        $this->load->model('task_instance');
        $this->load->model('task_type');
    }

    public function index()
    {
        //$this->rabbitmq_client->push('hello', 'Hello Worldaaaaaaaaaaaaaaaaaaaaaaaa !');
        $data['instance_table'] = $this->select_task_instance();
        $data['type_table'] = $this->select_task_type();
        $this->template->load('layout_admin', 'instances/instance_index', $data);

    }

    private function select_task_type()
    {
        $types = $this->task_type->table();
        $arr = array();
        foreach($types as $item) {
            $arr[$item['inst_id']] = $item['inst_name'];
        }
        return $arr;
    }

    private function select_task_instance()
    {
        $instances = $this->task_instance->table();
        $arr = array();
        foreach($instances as $item) {
            $arr[$item['ins_id']] = $item;
        }
        return $arr;
    }

    public function create()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['list_types'] = $this->select_task_type();
            $this->template->load('layout_admin', 'instances/instance_create', $data);
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('name', 'nombre', 'trim|required');
            $this->form_validation->set_rules('type_id', 'tipo', 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible">','</div>');

            if ($this->form_validation->run()) {
                $data = array(
                    'ins_name' => $this->input->post('name'),
                    'ins_type_id' => $this->input->post('type_id'),
                    'ins_creator_id' => '1'
                );
                $result = $this->task_instance->insert($data);
                if ($result == TRUE) {
                    $data['message_display'] = 'Ruta insertada exitosamente';
                    $data['list_types'] = $this->select_task_type();
                    $this->template->load('layout_admin', 'instances/instance_create', $data);
                } else {
                    $data['message_display'] = 'Error al insertar ruta';
                    $data['list_types'] = $this->select_task_type();
                    $this->template->load('layout_admin', 'instances/instance_create', $data);
                }
            } else {
                $data['message_display'] = validation_errors();
                $data['list_types'] = $this->select_task_type();
                $this->template->load('layout_admin', 'instances/instance_create', $data);
            }
        }
    }

    public function edit($id)
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $try = $this->task_instance->read();
            
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {

        }
    }

    public function destroy()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {

        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {

        }
    }
}