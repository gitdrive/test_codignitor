<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends CI_Controller {
    //functions
    function login()
    {
        //http://localhost/tutorial/codeigniter/main/login
        $data['title'] = 'CodeIgniter Simple Login Form With Sessions';
        $this->load->view("login", $data);
    }
    function login_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if($this->form_validation->run())
        {
            //true
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            //model function
            $this->load->model('main_model');
            if($this->main_model->can_login($username, $password))
            {
                $session_data = array(
                    'username'     =>     $username
                );
                $this->session->set_userdata($session_data);
                redirect('/user');
            }
            else
            {
                $this->session->set_flashdata('error', 'Invalid Username and Password');
                redirect(site_url().'/main/login');
            }
        }
        else
        {
            //false
            $this->login();
        }
    }

    function register_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if($this->form_validation->run())
        {
            //true
            $data['username'] = $this->input->post('username');
            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $data['phone'] = $this->input->post('phone');
            $data['password'] = $this->input->post('password');

            $this->load->model('main_model');
            if($this->main_model->can_register($data['username']))
            {
                $this->main_model->registerUser($data);
                redirect('main/login');
            }
            else
            {
                $this->session->set_flashdata('error', 'Username already exist');
                redirect('/main/register');
            }
        }
        else
        {
            $this->register();
        }
    }
//    function enter(){
//        if($this->session->userdata('username') != '')
//        {
//            echo '<h2>Welcome - '.$this->session->userdata('username').'</h2>';
//            echo '<label><a href="'.base_url
//
//                ().'main/logout">Logout</a></label>';
//        }
//        else
//        {
//            redirect('http://gauravtestnew.com/index.php/main/login');
//        }
//    }
    function logout()
    {
        $this->session->unset_userdata('username');
        //$readS=$this->session->userdata('username');
        redirect('/main/login');
    }

    public function register(){
        $this->load->view('register_form');
    }
}