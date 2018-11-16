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

        $this->url_imagenes = FCPATH . "../repository/";
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
        $project_folder = 'proy';                                       // Nombre de directorio de proyecto
        $project_dir = '../repository/' . $project_folder . '/';        // Ruta relativa de directorio del proyecto

        $path_query = $this->input->get('path');

        if ($path_query) {

            // TODO: Subir de directorio (evitar que suba más alla del directorio del proyecto)
            if ($this->endsWith($path_query, '/..')) {
                echo 'DENEGADO POR SEGURIDAD';
                return;

            }

            // TODO: Evitar formación de cadenas infinitas de /./././././././././././.

            if ($this->endsWith($path_query, '/.')) {
                echo 'DENEGADO POR SEGURIDAD';
                return;
            }

            // Ruta relativa de archivo ingresado
            $full_query_path = $project_dir . $this->input->get('path');
            $query_path = $this->input->get('path');
            if (is_dir($full_query_path)) {
                $dir = $query_path . '/';
                $query_path = $query_path . '/';
                $full_query_path = $full_query_path . '/';
            } else {
                $dir = $query_path;
            }
        }else{
            $full_query_path = $project_dir;
            $dir = '';
        }


        $file_list = [];
        if (is_dir($full_query_path)) {
            if ($dh = opendir($full_query_path)) {
                while (($file = readdir($dh)) !== false) {
                    $file_list[] = array('filename' => $file, 'filetype' => filetype($full_query_path . $file));
                }
                closedir($dh);
            }
        }
        $data['current_fulldir'] = 0;
        $data['current_dir'] = $dir;
        $data['list_files'] = $file_list;
        $this->template->load('layout_admin', 'files/file_index', $data);
    }

    public function create()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['project_id'] = $this->session->userdata('project_id');
            $this->template->load('layout_admin', 'files/file_create', $data);
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $upload_config = array(
                'upload_path' => $this->url_imagenes,
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => TRUE
            );
            $this->load->library('upload', $upload_config);

            if ($this->upload->do_upload('userfile'))
            {
                $upload_data = $this->upload->data();
                $project = $this->project->read($this->session->userdata('project_id'));
                $data = array(
                    'fil_filename' => $upload_data['file_name'],
                    'fil_url' => $project['prj_name'].'/'.$upload_data['file_name'],
                    'fil_associated_project_id' => $this->session->userdata('project_id')
                );
                $result = $this->file->insert($data);
                if ($result == TRUE) {
                    $data['project_id'] = $this->session->userdata('project_id');
                    $data['error'] = $this->upload->display_errors();
                    $this->template->load('layout_admin', 'files/file_create', $data);
                } else {
                    $data['project_id'] = $this->session->userdata('project_id');
                    $data['error'] = $this->upload->display_errors();
                    $this->template->load('layout_admin', 'files/file_create', $data);
                }
            } else {
                $data['project_id'] = $this->session->userdata('project_id');
                $data['error'] = $this->upload->display_errors();
                $this->template->load('layout_admin', 'files/file_create', $data);
            }
        }
    }

    public function destroy()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {

        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {

        }
    }
}