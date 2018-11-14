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
        $this->load->helper('form');
        $this->load->model('instance');
    }

    public function index()
    {
        //$this->rabbitmq_client->push('hello', 'Hello Worldaaaaaaaaaaaaaaaaaaaaaaaa !');
        $this->load->view('instances/instance_create');

    }

    public function create()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['list_types'] = array(
                'small'         => 'Small Shirt',
                'med'           => 'Medium Shirt'
            );
            $this->template->load('layout_admin', 'instances/instance_create', $data);

        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('name', 'nombre', 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible">','</div>');

            if ($this->form_validation->run()) {
                $data = array(
                    'ins_name' => $this->input->post('name'),
                );
                $result = $this->instance->insert($data);
                if ($result == TRUE) {
                    $data['message_display'] = 'Ruta insertada exitosamente';
                    $this->template->load('layout_admin', 'instances/instance_create', $data);
                } else {
                    $data['message_display'] = 'Error al insertar ruta';
                    $this->template->load('layout_admin', 'instances/instance_create', $data);
                }
            } else {
                $data['message_display'] = validation_errors();
                $this->template->load('layout_admin', 'instances/instance_create', $data);
            }
        }
    }

    public function edit()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {

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