<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

    public function loadOldTable()
    {
        $this->load->library('session');
        $readS = $this->session->userdata('username');
        if (empty($readS)) {
            redirect('http://gauravtestnew.com/index.php/main/login');
        }
        $this->load->model('Main_model');
        $edit = $this->input->get('edit');

        if (!isset($edit)) {
            $data['response'] = $this->Main_model->getUsersList();
            $data['view'] = 1;
            $this->load->view('Timeline', $data);
        } else {
            if ($this->input->post('submit') != NULL) {
                $postData = $this->input->post();
                $this->load->model('Main_model');
                $this->Main_model->updateUser($postData, $edit);
                redirect('user/');
            } else {
                $data['response'] = $this->Main_model->getUserById($edit);
                $data['view'] = 2;
                $this->load->view('Timeline', $data);
            }
        }
    }

    public function index()
    {
        $this->load->library('session');
        $readS = $this->session->userdata('username');
        if (empty($readS)) {
            redirect('http://gauravtestnew.com/index.php/main/login');
        }
        $this->load->model('Main_model');
        $edit = $this->input->get('edit');

        if (!isset($edit)) {
            $data['response'] = $this->Main_model->getPostsList();
            $data['view'] = 1;

            //create name to username map
            $this->load->model('Main_model');
            $user1list = $this->Main_model->getNewUsersList();

            foreach ($user1list as $user1) {
                $namemap[$user1['username']] = $user1['name'];
            }
            $data['namemap'] = $namemap;

            $this->load->view('Timeline', $data);
        } else {
            if ($this->input->post('submit') != NULL) {
                $postData = $this->input->post();
                $this->load->model('Main_model');
                $this->Main_model->updatePost($postData, $edit);
                redirect('user/');
            } else {
                $data['response'] = $this->Main_model->getPostById($edit);
                $data['view'] = 2;
                $this->load->view('Timeline', $data);
            }
        }
    }

    public function unset_session_data()
    {
        //loading session library
        $this->load->library('session');

        //removing session data
        $this->session->unset_userdata('name');
        $this->load->view('session_view');
        //redirect('http://gauravtestnew.com/index.php/main/login');
    }

    public function getProfile()
    {
        $data['profile'] = 1;
        $this->load->model('Main_model');
        $data['userdata'] = $this->Main_model->getUserByUsername($this->session->userdata('username'));
        $this->load->view('Timeline', $data);
    }

    public function getPublicProfile()
    {
        $username = $this->input->get('username');
        $data['profile'] = 2;
        $this->load->model('Main_model');
        $data['userdata'] = $this->Main_model->getUserByUsername($username);
        $this->load->view('Timeline', $data);
    }

    public function deleteUser()
    {
        $this->load->model('Main_model');
        $delete = $this->input->get('delete');

        $this->load->model('Main_model');
        $this->Main_model->deleteUser($delete);

        redirect('user/');
    }

    public function deletePost()
    {
        $this->load->model('Main_model');
        $delete = $this->input->get('delete');

        $this->load->model('Main_model');
        $this->Main_model->deletePost($delete);

        redirect('user/');
    }

    public function addUser()
    {
        $this->load->model('Test_Redis');
        //$this->Test_Redis->setRedisData("key1", "data1");
        $this->load->model('Main_model');
        $data['view'] = 3;
        $data['response'] = $this->Main_model->getUsersList();
        $this->load->view('Timeline', $data);
        if ($this->input->post('submit') != NULL) {
            $postData = $this->input->post();
            $this->load->model('Main_model');
            $this->Main_model->addUser($postData);
            redirect('user/');
        }
    }

    public function createPost()
    {
        $this->load->model('Main_model');
        $postData = $this->input->post();
        $this->Main_model->createPost($postData);
        redirect('user/');
    }
}