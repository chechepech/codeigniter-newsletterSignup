<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Signup_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function add($data = NULL)
    {
        if ($this->db->insert('signups', $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function edit($data = NULL)
    {
        $this->db->where('signup_email', $data['signup_email']);
        if ($this->db->update('signups', $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function delete($data = NULL)
    {
        $this->db->where('signup_email', $data['signup_email']);
        if ($this->db->delete('signups')) {
            return true;
        } else {
            return false;
        }
    }
    public function get_settings($email = NULL)
    {
        $this->db->where('signup_email', $email);
        $query = $this->db->get('signups');
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }
}
