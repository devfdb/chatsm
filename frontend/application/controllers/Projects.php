<?php

class Users extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user');
    }

    public function define()
    {
        $data = array();

        // Verifica que usuario esté autenticado
        // if ($this->session->userdata('isUserLoggedIn')) {
            if ($this->input->server('REQUEST_METHOD') == 'GET') {

                $data['list_projects'] = $this->project->table_select();
                $this->template->load('layout_admin', 'projects/welcome', $data);

            } else if ($this->input->server('REQUEST_METHOD') == 'POST') {


            }
        //} else {
        //    redirect('users/login');
        //}
    }


}