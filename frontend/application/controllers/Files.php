<?php

class Files extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Template');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('task_instance');
        $this->load->model('task_type');
        $this->load->model('file');
        $this->load->model('project');

        $this->url_imagenes = FCPATH."/../repository/";
    }


    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    public function index()
    {
        try{
            $path_query = $this->input->get('path');
        } catch (Exception $e)   {
            $path_query = Null;
        }
        if ($path_query) {
            $curr_dir_id = $path_query;
            $data['last_dir'] = $this->file->last_folder_id($path_query, $this->session->userdata('project_id'));
        }
        else {
            $curr_dir_id = $this->file->curr_file_id($this->session->userdata('project_id'));
            $data['last_dir'] = null;
        }
        $file_list = $this->file->table($curr_dir_id, $this->session->userdata('project_id'));

        $data['current_dir'] = $this->file->curr_dir($curr_dir_id, $this->session->userdata('project_id'));
        $data['current_dir_id'] = $curr_dir_id;
        $data['file_list'] = $file_list;
        $this->template->load('layout_admin', 'files/file_index', $data);
    }

    public function create()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['curr_dir_id'] = $this->input->get('path');
            $data['project_id'] = $this->session->userdata('project_id');
            $data['error'] = null;
            $this->template->load('layout_admin', 'files/file_create', $data);
        }
        else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('userfile', 'Archivo', 'required');

            $project = $this->project->read($this->session->userdata('project_id'));
            $relative_route = $this->file->curr_dir_path($this->input->post('dir_id'));
            $upload_config = array(
                'upload_path' => '../repository/' . $relative_route,
                'allowed_types' => "gif|jpg|png|jpeg|pdf|csv|json|pkl|txt",
                'overwrite' => TRUE
            );
            $this->load->library('upload', $upload_config);
            if ($this->form_validation->run() == TRUE) {
                if ($this->upload->do_upload('userfile')) {
                    $upload_data = $this->upload->data();
                    $data = array(
                        'fil_filename' => $upload_data['file_name'],
                        'fil_url' => $relative_route . '/' . $upload_data['file_name'],
                        'fil_associated_project_id' => $this->session->userdata('project_id'),
                        'fil_owner' => $this->session->userdata('userId'),
                        'fil_parent_id' => $this->input->post('dir_id'),
                        'fil_file_format' => $this->file->file_end($upload_data['file_name'])
                    );
                    $result = $this->file->insert($data);
                    if ($result == TRUE) {
                        $data['curr_dir_id'] = str_replace("/", "", $this->input->post('dir_id'));
                        $data['project_id'] = $this->session->userdata('project_id');
                        $this->session->set_flashdata(
                            'message', json_encode(
                                array(
                                    "type" => "success",
                                    "text" => "Inserción Exitosa"
                                )
                            )
                        );
                        redirect('/files/create', 'refresh');
                    }
                    else {
                        $data['project_id'] = $this->session->userdata('project_id');
                        $data['curr_dir_id'] = str_replace("/", "", $this->input->post('dir_id'));
                        $this->session->set_flashdata(
                            'message', json_encode(
                                array(
                                    "type" => "error",
                                    "text" => "Error: Inserción no completada."
                                )
                            )
                        );
                        redirect('/files/create', 'refresh');
                    }
                }
                else {
                    $data['project_id'] = $this->session->userdata('project_id');
                    $data['curr_dir_id'] = str_replace("/", "", $this->input->post('dir_id'));
                    $this->session->set_flashdata(
                        'message', json_encode(
                            array(
                                "type" => "error",
                                "text" => "Error: Tipo de archivo incorrecto"
                            )
                        )
                    );
                    redirect('/files/create', 'refresh');
                }
            }
            else {
                $data['project_id'] = $this->session->userdata('project_id');
                $data['curr_dir_id'] = str_replace("/", "", $this->input->post('dir_id'));
                $this->session->set_flashdata(
                    'message', json_encode(
                        array(
                            "type" => "error",
                            "text" => "Error: No hubo elementos para subir"
                        )
                    )
                );
                redirect('/files/create', 'refresh');
            }
        }
    }

    public function image()
    {

    }
    public function destroy($id)
    {
        echo $id;
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            return true;
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $var = $this->input->post();
            return false;
        }
    }
}