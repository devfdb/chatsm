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
        $this->load->model('file');


        $this->base_path = FCPATH."/../repository/";
    }

    public function index()
    {
        $user = $this->session->userdata('userId');
        $data['project_table'] = $this->project->table($user);
        $this->template->load('layout_admin', 'projects/project_index', $data);
    }

    public function shared()
    {
        $user = $this->session->userdata('userId');
        $data['project_table'] = $this->project->cross($user);
        $this->template->load('layout_admin', 'projects/project_shared', $data);
    }

    public function invite()
    {
        $this->template->load('layout_admin', 'projects/project_invite');
    }

    public function define()
    {
        $data = array();
        $user = $this->session->userdata('userId');
        // Verifica que usuario esté autenticado
        // if ($this->session->userdata('isUserLoggedIn')) {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['list_projects'] = $this->project->table_select($user);
            $data['project_id'] = $this->session->userdata('project_id');
            $data['project_name'] = $this->session->userdata('project_name');
            $this->template->load('layout_admin', 'projects/project_define', $data);
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('project_id', 'proyecto', 'trim|required');
            if ($this->form_validation->run() == true) {
                $data['list_projects'] = $this->project->table_select($user);
                $this->session->set_userdata('project_id', $this->input->post('project_id'));
                $this->session->set_userdata('project_name', $this->project->retrieve_project_name($this->input->post('project_id'), $this->session->userdata('userId')));
                $data['project_id'] = $this->session->userdata('project_id');
                $data['project_name'] = $this->session->userdata('project_name');
                $data['message'] = json_encode(array('title'=> 'Proyecto seleccionado', 'type' => 'success' ));
                redirect('dashboard', 'location');
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
                    'prj_owner' => $this->session->userdata('userId')
                );
                $result = $this->project->insert($data);
                if ($result == TRUE) {
                    if (!file_exists($this->base_path.$data['prj_name']))
                    {
                        mkdir($this->base_path.$data['prj_name'], 0777, true);
                        mkdir($this->base_path.$data['prj_name'].'/input', 0777, true);
                        mkdir($this->base_path.$data['prj_name'].'/output', 0777, true);

                    }
                    $data['message'] = json_encode(array('title'=> 'Proyecto creado exitosamente', 'type' => 'success' ));

                    $base_folder = array(
                        'fil_filename' => $this->input->post('name'),
                        'fil_url' => $this->input->post('name'),
                        'fil_owner' => $this->session->userdata('userId'),
                        'fil_associated_project_id' => $this->project->retrieve_project_id($this->input->post('name'), $this->session->userdata('userId')),
                        'fil_file_format' => 'folder'
                    );
                    $this->file->insert($base_folder);

                    $input_folder = array(
                        'fil_filename' => 'input',
                        'fil_url' => $this->input->post('name').'/input',
                        'fil_parent_id' => $this->file->curr_file_id($this->project->retrieve_project_id($this->input->post('name'), $this->session->userdata('userId'))),
                        'fil_owner' => $this->session->userdata('userId'),
                        'fil_associated_project_id' => $this->project->retrieve_project_id($this->input->post('name'), $this->session->userdata('userId')),
                        'fil_file_format' => 'folder'
                    );
                    $this->file->insert($input_folder);

                    $output_folder = array(
                        'fil_filename' => 'output',
                        'fil_url' => $this->input->post('name').'/output',
                        'fil_parent_id' => $this->file->curr_file_id($this->project->retrieve_project_id($this->input->post('name'), $this->session->userdata('userId'))),
                        'fil_owner' => $this->session->userdata('userId'),
                        'fil_associated_project_id' => $this->project->retrieve_project_id($this->input->post('name'), $this->session->userdata('userId')),
                        'fil_file_format' => 'folder'
                    );
                    $this->file->insert($output_folder);

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

    public function edit($id)
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['project'] = $this->project->read($id);
            if(!$data['project']) redirect('/projects/index', 'location');
            else $this->template->load('layout_admin', 'projects/project_edit', $data);
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('name', 'nombre', 'trim|required');
            $this->form_validation->set_rules('description', 'descripción', 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible">','</div>');

            if ($this->form_validation->run()) {
                $data = array(
                    'prj_name' => $this->input->post('name'),
                    'prj_description' => $this->input->post('description'),
                );
                $result = $this->project->update($id, $data);
                if ($result == TRUE) {
                    $data['message'] = json_encode(array('title'=> 'Proyecto actualizado exitosamente', 'type' => 'success' ));
                    $data['project'] = $this->project->read($id);
                    $this->template->load('layout_admin', 'projects/project_edit', $data);
                } else {
                    $data['message'] = json_encode(array('title'=> 'Error al actualizar proyecto', 'type' => 'error' ));
                    $data['project'] = $this->project->read($id);
                    $this->template->load('layout_admin', 'projects/project_edit', $data);
                }
            } else {
                $data['message_display'] = validation_errors();
                $data['project'] = $this->project->read($id);
                $this->template->load('layout_admin', 'projects/project_edit', $data);
            }
        }
    }

    public function destroy($id)
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['project'] = $this->project->read($id);
            if(!$data['project']) redirect('/projects/index', 'location');
            else $this->template->load('layout_admin', 'projects/project_destroy', $data);
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $result = $this->project->delete($id);
            if ($result == TRUE) {
                $data['message'] = json_encode(array('title'=> 'Proyecto eliminado exitosamente', 'type' => 'success' ));
                $this->index();
            } else {
                $data['message'] = json_encode(array('title'=> 'Error al eliminar proyecto', 'type' => 'success' ));
                $this->index();
            }
        }
    }
}