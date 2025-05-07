<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Transaction_model');
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user($user_id);
        $data['transactions'] = $this->Transaction_model->get_user_transactions($user_id);
        $this->load->view('wallet', $data);
    }

    public function deposit() {
        $amount = $this->input->post('amount');
        $this->Transaction_model->deposit($this->session->userdata('user_id'), $amount);
        redirect('wallet/index');
    }

    public function transfer() {
        $receiver_id = $this->input->post('receiver_id');
        $amount = $this->input->post('amount');
        $this->Transaction_model->transfer($this->session->userdata('user_id'), $receiver_id, $amount);
        redirect('wallet/index');
    }

    public function reverse($transaction_id) {
        $this->Transaction_model->reverse_transaction($transaction_id);
        redirect('wallet/index');
    }
}