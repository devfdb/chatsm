<?php
class Files extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Template');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('task_instance');
        $this->load->model('task_type');
        $this->load->model('file');

    }

    public function index()
    {
        $data['list_files'] = $this->file->table();
        $this->template->load('layout_admin', 'files/files_table', $data);
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

    public function edit()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->template->load('layout_admin', 'instances/instance_edit', $data);
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