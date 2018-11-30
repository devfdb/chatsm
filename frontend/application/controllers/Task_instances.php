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
        $this->load->helper('form');
        $this->load->model('task_instance');
        $this->load->model('task_instance_parameter');
        $this->load->model('task_type');
        $this->load->model('task_type_parameter');
        $this->load->model('user');
    }

    public function index()
    {
        //$this->rabbitmq_client->push('hello', 'Hello Worldaaaaaaaaaaaaaaaaaaaaaaaa !');
        $data['instance_table'] = $this->select_task_instance($this->session->userdata('project_id'));
        $data['type_table'] = $this->select_task_type();
        $data['user_table'] = $this->show_users();
        $this->template->load('layout_admin', 'instances/instance_index', $data);

    }

    private function select_task_type_parameter($id)
    {
        $params = $this->task_type_parameter->read($id);
        $arr = array();

        if ($params) {
            array_push($arr, $params);
        }
        return $arr;
    }

    private function select_task_type()
    {
        $types = $this->task_type->table();
        $arr = array();

        if ($types) {
            foreach ($types as $item) {
                array_push($arr, array(
                    'key' => $item['tst_id'],
                    'value' => $item['tst_name']
                ));
            }
        }
        return $arr;
    }

    private function select_task_instance($project_id)
    {
        $instances = $this->task_instance->table($project_id);
        $arr = array();

        if ($instances) {
            foreach ($instances as $item) {
                $arr[$item['ins_id']] = $item;
            }
        }
        return $arr;
    }

    public function show_users()
    {
        $users = $this->user->getRows();
        $arr = array();

        if ($users) {
            foreach ($users as $item) {
                $arr[$item['usr_id']] = $item['usr_username'];
            }
        }
        return $arr;

    }

    public function create()
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['list_types'] = $this->select_task_type();
            $this->template->load('layout_admin', 'instances/instance_create', $data);
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
//            $this->form_validation->set_rules('name', 'nombre', 'trim|required');
//            $this->form_validation->set_rules('type_id', 'tipo', 'trim|required');
//            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible">','</div>');

//            if ($this->form_validation->run()) {
            if (true) {
                $inst = json_decode(file_get_contents('php://input'), true);

                $data = array(
                    'ins_name' => $inst['name'],
                    'ins_type_id' => $inst['type_id'],
                    'ins_owner' => $this->session->userdata('userId'),
                    'ins_project_id' => $this->session->userdata('project_id')
                );
                $result = $this->task_instance->insert($data);

                foreach ($inst['parameters'][0] as $parameter) {
                    $param_entry = array(
                        'inp_instance_id' => $result,
                        'inp_parameter_type_id' => $parameter['itp_id'],
                        'inp_parameter_value' => $parameter['value']
                    );
                    $this->task_instance_parameter->insert($param_entry);
                }
                // So, data adds the instance itself
                // TODO: Agregar parámetros para instancia.
                // TODO: Los datos para ingresar están en $inst['parameters']


//                foreach (parameter in $inst['params'])
//                $param = array(
//                  'inp_instance_id' => $result['ins_id'],
//                    'inp_parameter_type_id' => $inst[],
//                    'inp_parameter_value' => $inst[],
//                );
                if ($result == TRUE) {
                    $data['message'] = json_encode(array('title' => 'Instancia creada exitosamente', 'type' => 'success'));
                    $data['list_types'] = $this->select_task_type();
                    $this->template->load('layout_admin', 'instances/instance_create', $data);
                } else {
                    $data['message'] = json_encode(array('title' => 'No se pudo crear la instancia', 'type' => 'error'));
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

    public function edit($id)
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['instance'] = $this->task_instance->read($id);
            $data['list_types'] = $this->select_task_type();

            if (!$data['instance']) redirect('/task-instances/index', 'location');
            else $this->template->load('layout_admin', 'instances/instance_edit', $data);

        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('name', 'nombre', 'trim|required');
            $this->form_validation->set_rules('type_id', 'tipo', 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible">', '</div>');

            if ($this->form_validation->run()) {
                $data = array(
                    'ins_name' => $this->input->post('name'),
                    'ins_type_id' => $this->input->post('type_id'),
                );
                $result = $this->task_instance->update($id, $data);
                if ($result == TRUE) {
                    $data['message'] = json_encode(array('title' => 'Instancia actualizada exitosamente', 'type' => 'success'));
                    $data['instance'] = $this->task_instance->read($id);
                    $data['list_types'] = $this->select_task_type();
                    $this->template->load('layout_admin', 'instances/instance_edit', $data);
                } else {
                    $data['message'] = json_encode(array('title' => 'Error al actualizar instancia', 'type' => 'error'));
                    $data['instance'] = $this->task_instance->read($id);
                    $data['list_types'] = $this->select_task_type();
                    $this->template->load('layout_admin', 'instances/instance_edit', $data);
                }
            } else {
                $data['message_display'] = validation_errors();
                $data['instance'] = $this->task_instance->read($id);
                $data['list_types'] = $this->select_task_type();
                $this->template->load('layout_admin', 'instances/instance_edit', $data);
            }
        }
    }

    public function destroy($id)
    {
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $data['instance'] = $this->task_instance->read($id);

            if (!$data['instance']) redirect('/task-instances/index', 'location');
            else $this->template->load('layout_admin', 'instances/instance_destroy', $data);

        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $result = $this->task_instance->delete($id);
            if ($result == TRUE) {
                $data['message'] = json_encode(array('title' => 'Instancia eliminada exitosamente', 'type' => 'error'));
                $this->index();
            } else {
                $data['message'] = json_encode(array('title' => 'Error al eliminar instancia', 'type' => 'error'));
                $this->index();
            }
        }
    }

    public function get_instances_of_project()
    {
        $project_id = $this->session->userdata('project_id');
        $instances = $this->task_instance->table($project_id);
        $arr = array();
        if ($instances) {
            foreach ($instances as $item) {
                array_push($arr, array(
                    'key' => $item['ins_id'],
                    'value' => $item['ins_name']
                ));
            }
        }
        echo json_encode($arr);
    }

    public function get_task_types()
    {
        $arg = $this->select_task_type();
        echo json_encode($arg);
    }

    public function get_task_parameters($id)
    {
        $arg = $this->select_task_type_parameter($id);
        echo json_encode($arg);
    }
}