<?php

class Projects extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('Template');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('user');
        $this->load->model('project');

        $this->url_imagenes = FCPATH."/../repository/";
    }

    public function index()
    {
        $data['project_table'] = $this->project->table();
        $this->template->load('layout_admin', 'projects/project_index', $data);
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

    public function create()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $this->template->load('layout_admin', 'projects/project_create');
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('name', 'nombre', 'trim|required');
            $this->form_validation->set_rules('description', 'descripción', 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible">','</div>');

            if ($this->form_validation->run()) {
                $data = array(
                    'prj_name' => $this->input->post('name'),
                    'prj_description' => $this->input->post('description'),
                    'prj_creator' => $this->session->userdata('userId')
                );
                $result = $this->project->insert($data);
                if ($result == TRUE) {
                    if (!file_exists($this->url_imagenes.$data['prj_name']))
                    {
                        mkdir($this->url_imagenes.$data['prj_name'], 0777, true);
                    }
                    $data['message'] = json_encode(array('title'=> 'Proyecto creado exitosamente', 'type' => 'success' ));
                    $this->template->load('layout_admin', 'projects/project_create', $data);
                } else {
                    $data['message'] = json_encode(array('title'=> 'No se pudo crear el proyecto', 'type' => 'error' ));
                    $this->template->load('layout_admin', 'projects/project_create', $data);
                }
            } else {
                $data['message_display'] = validation_errors();
                $this->template->load('layout_admin', 'projects/project_create', $data);
            }
        }
    }
}