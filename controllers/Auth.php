<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function register() {
        $this->load->view('register');
    }

    public function save_register() {
        $this->load->model('User_model');
        $username = $this->input->post('username');
        $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        $this->User_model->create_user($username, $password);
        redirect('auth/login');
    }

    public function login() {
        $this->load->view('login');
    }

    public function check_login() {
        $this->load->model('User_model');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $user = $this->User_model->get_user_by_username($username);

        if ($user && password_verify($password, $user->password_hash)) {
            $this->session->set_userdata('user_id', $user->id);
            redirect('wallet/index');
        } else {
            echo 'Login inválido';
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}