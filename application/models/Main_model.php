<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main_model extends CI_Model
{

    // Get all user list
    function getUsersList()
    {
        $this->db->select('*');
        $this->db->order_by('name', 'asc');
        $this->db->limit(10, 0);
        $q = $this->db->get('users');
        $result = $q->result_array();
        return $result;
    }

    function getNewUsersList()
    {
        $this->db->select('*');
        $q = $this->db->get('user1');
        $result = $q->result_array();
        return $result;
    }

    function getFriendssList($username1)
    {
        $this->db->select('*');
        $this->db->where('username1', $username1);
        $q = $this->db->get('friends');
        $result = $q->result_array();
        return $result;
    }

    function getLikesCount($id)
    {
        $this->db->select('count(*) as c');
        $this->db->where('post_id', $id);
        $q = $this->db->get('Likes');
        $result = $q->result_array();
        return $result[0];
    }

    function getFollowersList($username1)
    {
        $this->db->select('*');
        $this->db->where('username2', $username1);
        $q = $this->db->get('friends');
        $result = $q->result_array();
        return $result;
    }

    function getFriendsReqReceList($username1)
    {
        $this->db->select('*');
        $this->db->where('username1', $username1);
        $q = $this->db->get('friend_request_received');
        $result = $q->result_array();
        return $result;
    }

    function getFriendsReqSentList($username1)
    {
        $this->db->select('*');
        $this->db->where('username1', $username1);
        $q = $this->db->get('friend_request_sent');
        $result = $q->result_array();
        return $result;
    }

    function getPostsList()
    {
        $this->db->select('*');
        $this->db->order_by('id', 'desc');
        $q = $this->db->get('timeline');
        $result = $q->result_array();
        return $result;
    }

    // Get user by id
    function getUserById($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $q = $this->db->get('users');
        $result = $q->result_array();
        return $result;
    }

    function getNotifsForUser($username)
    {
        $this->db->select('*');
        $this->db->order_by('id', 'desc');
        $this->db->where('username', $username);
        $q = $this->db->get('notifications');
        $result = $q->result_array();
        return $result;
    }

    function getPostById($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $q = $this->db->get('timeline');
        $result = $q->result_array();
        return $result;
    }

    function getUserByUsername($username)
    {
        $this->db->select('*');
        $this->db->where('username', $username);
        $q = $this->db->get('user1');
        $result = $q->result_array();
        return $result;
    }

    // Update record by id
    function updateUser($postData, $id)
    {
        $name = trim($postData['txt_name']);
        $uname = trim($postData['txt_uname']);
        $email = trim($postData['txt_email']);
        if ($name != '' && $email != '') {

            // Update
            $value = array('name' => $name, 'email' => $email, 'username' => $uname);
            $this->db->where('id', $id);
            $this->db->update('users', $value);
        }
    }

    function updatePost($postData, $id)
    {
        $post = trim($postData['txt_name']);
        if ($postData != '') {
            $value = array('text' => $post);
            $this->db->where('id', $id);
            $this->db->update('timeline', $value);
        }
    }

    function addFriend($username1, $username2)
    {
        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set("Asia/Kolkata");
        }
        $timesnow = time();
        $timestamp = date("F d, Y h:i:sa", $timesnow);
        if ($username1 != '' && $username2 != '') {
            $value = array('username1' => $username1, 'username2' => $username2, 'creation_date' => $timestamp);
            $this->db->insert('friends', $value);

            $value2 = array('username' => $username2, 'username2' => $username1);
            $this->db->insert('notifications', $value2);
        }
    }

    function removeFriend($username1, $username2)
    {
        $value = array('username1' => $username1);
        $value = array('username2' => $username2);
        $this->db->delete('friends', $value);

        $value2 = array('username' => $username2, 'username2' => $username1);
        $this->db->delete('notifications', $value2);
    }

    function addUser($postData)
    {
        $name = trim($postData['txt_name1']);
        $uname = trim($postData['txt_uname1']);
        $email = trim($postData['txt_email1']);
        if ($name != '' && $email != '') {

            // Add
            $value = array('name' => $name, 'email' => $email, 'username' => $uname);
            $this->db->insert('users', $value);
        }
    }

    function registerUser($postData)
    {

        $username = trim($postData['username']);
        $name = trim($postData['name']);
        $email = trim($postData['email']);
        $phone = trim($postData['phone']);
        $password = trim($postData['password']);

        if ($name != '' && $username != '' && $password != '') {
            $value = array('username' => $username, 'name' => $name, 'email' => $email,
                'phone' => $phone);
            $this->db->insert('user1', $value);
        }

        if ($username != '' && $password != '') {
            $value = array('username' => $username, 'password' => $password);
            $this->db->insert('users_login', $value);
        }
        $this->addFriend('riya', $username);
    }

    function deleteUser($id)
    {
        $value = array('id' => $id);
        $this->db->delete('users', $value);
    }

    function deletePost($id)
    {
        $value = array('id' => $id);
        $this->db->delete('timeline', $value);

        $value2 = array('post_id' => $id);
        $this->db->delete('Likes', $value2);
    }

    function can_login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('users_login');
        //SELECT * FROM users WHERE username = '$username' AND password = '$password'
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function can_register($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users_login');
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    function likePost($username, $id)
    {
        $this->db->where('username', $username);
        $this->db->where('post_id', $id);
        $query = $this->db->get('Likes');
        if ($query->num_rows() == 0) {
            $value = array('username' => $username, 'post_id' => $id);
            $this->db->insert('Likes', $value);
        }
    }

    function unlikePost($username, $id)
    {
        $this->db->where('username', $username);
        $this->db->where('post_id', $id);
        $query = $this->db->get('Likes');
        if ($query->num_rows() > 0) {
            $value = array('username' => $username, 'post_id' => $id);
            $this->db->delete('Likes', $value);
        }
    }

    function isLikedPost($username, $id)
    {
        $this->db->where('username', $username);
        $this->db->where('post_id', $id);
        $query = $this->db->get('Likes');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function createPost($postData)
    {
        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set("Asia/Kolkata");
        }
        $text = trim($postData['textarea']);
        $username = $this->session->userdata('username');
        $timesnow = time();
        $timestamp = date("F d, Y h:i:sa", $timesnow);

        if ($text != '') {
            $value = array('text' => $text, 'username' => $username, 'timestamp' => $timestamp);
            $this->db->insert('timeline', $value);
        }
    }
}