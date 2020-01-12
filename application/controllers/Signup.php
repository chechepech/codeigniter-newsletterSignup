<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Signup extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Signup_model');       
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    }

    public function index()
    {
        // Set validation rules
        $this->form_validation->set_rules('signup_email', $this->lang->line('signup_emailemail'), 'required|trim|valid_email|min_length[1]|max_length[100]|is_unique[signups.signup_email]');
        $this->form_validation->set_rules('signup_emailopt1', $this->lang->line('signup_emailopt1'), 'min_length[1]|max_length[1]');
        $this->form_validation->set_rules('signup_emailopt2', $this->lang->line('signup_emailopt2'), 'min_length[1]|max_length[1]');

        // Begin validation
        if ($this->form_validation->run() == FALSE) {
            $data['signup_email'] = array('name' => 'signup_email', 'class' => 'form-control', 'id' => 'signup_email', 'value' => set_value('signup_email', ''), 'maxlength' => '100', 'size' => '35', 'placeholder' => $this->lang->line('signup_email'));
      $data['signup_opt1'] = array('name' => 'signup_opt1', 'id' => 'signup_opt1', 'value' => '1', 'checked' => FALSE, 'style' => 'margin:10px');      
      $data['signup_opt2'] = array('name' => 'signup_opt2', 'id' => 'signup_opt2', 'value' => '1', 'checked' => FALSE, 'style' => 'margin:10px');   

            $this->load->view('common/header');
            $this->load->view('nav/top_nav', $data);
            $this->load->view('signup/signup', $data);
            $this->load->view('common/footer');
        } else {
            //validate input post checkbox 
            $opt1=empty($this->input->post('signup_opt1',TRUE)) ? '0' : $this->input->post('signup_opt1',TRUE);
            $opt2=empty($this->input->post('signup_opt2',TRUE)) ? '0' : $this->input->post('signup_opt2',TRUE);
            $data = array('signup_email' => $this->input->post('signup_email', TRUE),
                'signup_opt1' => $opt1,
                'signup_opt2' => $opt2,
                'signup_active' => 1);

            if ($this->Signup_model->add($data)) {
                echo $this->lang->line('signup_success');
                redirect(base_url('signup/settings/'.str_replace('@', '/', $data['signup_email'])));
            } else {
                echo $this->lang->line('signup_error');
            }
        }
    }

    public function settings()
    {
        // Set validation rules
        
        $this->form_validation->set_rules('signup_email', $this->lang->line('signup_email'), 'required|valid_email|min_length[1]|max_length[50]');
        $this->form_validation->set_rules('signup_opt1', $this->lang->line('signup_opt1'), 'min_length[1]|max_length[1]');
        $this->form_validation->set_rules('signup_opt2', $this->lang->line('signup_opt2'), 'min_length[1]|max_length[1]');
        $this->form_validation->set_rules('signup_unsub', $this->lang->line('signup_unsub'), 'min_length[1]|max_length[1]');

        // Begin validation
        if ($this->form_validation->run() == false) {
            //http://127.0.0.1/news/signup/settings/hola/hola.com
            $query = $this->Signup_model->get_settings($this->uri->segment(3) . '@' . $this->uri->segment(4));
            if ($query->num_rows() == 1) {
                foreach ($query->result() as $row) {
                    $signup_opt1 = $row->signup_opt1;
                    $signup_opt2 = $row->signup_opt2;
                }
            } else {
                redirect('signup');
            }

            $data['signup_email'] = array('name' => 'signup_email', 'class' => 'form-control', 'id' => 'signup_email', 'value' => set_value('signup_email', $this->uri->segment(3) . '@' . $this->uri->segment(4)), 'maxlength' => '100', 'size' => '35', 'placeholder' => $this->lang->line('signup_email'));
            $data['signup_opt1']  = array('name' => 'signup_opt1', 'id' => 'signup_opt1', 'value' => '1', 'checked' => ($signup_opt1 == 1) ? true : false, 'style' => 'margin:10px');
            $data['signup_opt2']  = array('name' => 'signup_opt2', 'id' => 'signup_opt2', 'value' => '1', 'checked' => ($signup_opt2 == 1) ? true : false, 'style' => 'margin:10px');
            $data['signup_unsub'] = array('name' => 'signup_unsub', 'id' => 'signup_unsub', 'value' => '1', 'checked' => false, 'style' => 'margin:10px');

            $this->load->view('common/header');
            $this->load->view('nav/top_nav', $data);
            $this->load->view('signup/settings', $data);
            $this->load->view('common/footer');
        } else {

            if ($this->input->post('signup_unsub') == 1) {
                $data = array('signup_email' => $this->input->post('signup_email'));
                if ($this->Signup_model->delete($data)) {
                    echo $this->lang->line('unsub_success');
                    redirect('/');
                } else {
                    echo $this->lang->line('unsub_error');
                }
            } else {
                //validate input post checkbox 
                $opt1=empty($this->input->post('signup_opt1',TRUE)) ? '0' : $this->input->post('signup_opt1',TRUE);
                $opt2=empty($this->input->post('signup_opt2',TRUE)) ? '0' : $this->input->post('signup_opt2',TRUE);
                $data = array('signup_email' => $this->input->post('signup_email'),
                    'signup_opt1' => $opt1,
                    'signup_opt2' => $opt2);
                if ($this->Signup_model->edit($data)) {
                    echo $this->lang->line('setting_success');
                    redirect(base_url('signup/settings/'.str_replace('@', '/', $data['signup_email'])),'refresh');
                } else {
                    echo $this->lang->line('setting_error');
                }
            }
        }
    }
}
