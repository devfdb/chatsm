<?php
class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Template');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('task_instance');
        $this->load->model('project');
        $this->load->model('execution');

    }

    public function index()
    {
        $data['projects'] = $this->project->countProjects($this->session->userdata('userId'));
        $data['executions'] = $this->execution->countExecutedProcesses($this->session->userdata('userId'));
        $data['instances'] = $this->task_instance->countTaskInstances($this->session->userdata('userId'));
        $this->template->load('layout_admin', 'layout/dashboard', $data);
    }
}