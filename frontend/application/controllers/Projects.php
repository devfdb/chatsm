<?php

class Projects extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('Template');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('user');
        $this->load->model('project');

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


}