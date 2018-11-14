<?php
/**
 * Created by PhpStorm.
 * User: fdiazb
 * Date: 07-11-2018
 * Time: 16:16
 */
//use PhpAmqpLib\Connection\AMQPStreamConnection;
//use PhpAmqpLib\Message\AMQPMessage;

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Template');

    }

    public function index()
    {
        $data['title'] = 'My foo page';
        $this->template->load('layout_admin', 'instances/instance_create', $data);
    }
}