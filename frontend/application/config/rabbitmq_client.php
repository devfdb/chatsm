<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Config for Rabbit MQ Library
 */
$config['rabbitmq_client'] = array(
    'host' => '192.168.1.113',
    'port' => 5672,
    'user' => 'test',
    'pass' => 'test',
    'vhost' => '/',
    'allowed_methods' => null,
    'non_blocking' => false,
    'timeout' => 1
);