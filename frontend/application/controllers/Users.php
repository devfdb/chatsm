<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User Management class created by CodexWorld
 */
class Users extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('user');
    }

    /*
     * User account information
     */
    public function account()
    {
        $data = array();
        if ($this->session->userdata('isUserLoggedIn')) {
            $data['user'] = $this->user->getRows(array('id' => $this->session->userdata('userId')));
            //load the view
            $this->load->view('users/account', $data);
        } else {
            redirect('users/login');
        }
    }

    /*
     * User login
     */
    public function login()
    {
        $data = array();

        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            if($this->session->userdata('isUserLoggedIn')) {
                redirect('dashboard', 'location');
            }
            else {
                $this->load->view('users/user_login', $data);
            }
        } else if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'required');
            if ($this->form_validation->run() == true) {
                $con['returnType'] = 'single';
                $con['conditions'] = array(
                    'usr_mail' => $this->input->post('email'),
                    'usr_pass' => md5($this->input->post('password')),
                );
                $checkLogin = $this->user->getRows($con);
                if ($checkLogin) {

                    if ($this->session->userdata('success_msg')) {
                        $data['success_msg'] = $this->session->userdata('success_msg');
                        $this->session->unset_userdata('success_msg');
                    }
                    if ($this->session->userdata('error_msg')) {
                        $data['error_msg'] = $this->session->userdata('error_msg');
                        $this->session->unset_userdata('error_msg');
                    }

                    $this->session->set_userdata('isUserLoggedIn', TRUE);
                    $this->session->set_userdata('userId', $checkLogin['usr_id']);
                    $this->session->set_userdata('userName', $checkLogin['usr_name']);
                    $this->session->set_userdata('userProfilePhoto', null); # TODO agregar a base de datos direccion relativa de imagen de usuario
                    redirect('dashboard');
                } else {
                    $data['error_msg'] = 'Su usuario o contraseña es incorrecto';
                }
            }

            $this->load->view('users/user_login', $data);

        }
    }

    /*
     * User registration
     */
    public function registration()
    {
        $data = array();
        $userData = array();
        if ($this->input->post('regisSubmit')) {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');

            $userData = array(
                'usr_name' => strip_tags($this->input->post('name')),
                'usr_username' => strip_tags($this->input->post('username')),
                'usr_mail' => strip_tags($this->input->post('email')),
                'usr_pass' => md5($this->input->post('password')),
            );

            if ($this->form_validation->run() == true) {
                 $insert = $this->user->insert($userData);
                if ($insert) {
                    $this->session->set_userdata('success_msg', 'Te has registrado exitosamente, ahora puedes iniciar sesión.');
                    redirect('users/login');
                } else {
                    $data['error_msg'] = 'Algo pasó, probablemente malo. Inténtelo nuevamente.';
                }
            }
        }
        $data['user'] = $userData;
        //load the view
        $this->load->view('users/registration', $data);
    }

    /*
     * User logout
     */
    public function logout()
    {
        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('userId');
        $this->session->unset_userdata('projectId');
        $this->session->unset_userdata('userName');
        $this->session->sess_destroy();
        redirect('users/login/');
    }

    /*
     * Existing email check during validation
     */
    public function email_check($str)
    {
        $con['returnType'] = 'count';
        $con['conditions'] = array('usr_mail' => $str);
        $checkEmail = $this->user->getRows($con);
        if ($checkEmail > 0) {
            $this->form_validation->set_message('email_check', 'El correo que entrego ya fue utilizado anteriormente.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}