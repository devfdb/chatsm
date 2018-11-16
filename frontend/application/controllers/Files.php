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
            $data['list_types'] = $this->select_task_type();
            $this->template->load('layout_admin', 'instances/instance_create', $data);
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('name', 'nombre', 'trim|required');
            $this->form_validation->set_rules('type_id', 'tipo', 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible">', '</div>');

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