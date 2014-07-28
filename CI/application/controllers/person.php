<?php

class person extends CI_controller
{
   function __construct()
    {	
	   parent::__construct();
	   $this->load->helper(array('form', 'url'));
       $this->load->library('form_validation');
       $this->load->library('session');
       $this->load->library('encrypt');
       $this->load->library('table');
       $this->load->model('person_model');
	     $this->load->library('pagination');
  }

   function index()
   {
   	  if (!$this->session->userdata('Username'))
   	  	{
   	  		$this->load->view('login');
   	  	}
   	  else
   	    {
   	    	$this->load->view('person_center');
   	    }	
   }
   function person_center_menu()
   {
      $this->load->view('person_center_menu');
   }

   function change_password()
   {
       if (!$this->session->userdata('Username'))
   	   {
   	   	  $this->load->view('login');
   	   }
   	   else
   	   {
          if ($this->form_validation->run('change_password'))
           {
              $Username = $this->session->userdata('Username');
              $data['Username'] = $Username;
             if ($this->person_model->change_password($Username,$data))
               {
                 $NewPassword = $data['Password'];
                 $this->session->set_userdata('Password',$NewPassword);
                 $this->load->view('form_success');
               }
              else
              {
                 $data['error'] = "修改密码失败";
                 $this->load->view('error_handle',$data);
              } 
           }
          else 
          {
             $this->load->view('change_password');
          }
   	   }   
   }

   function profile()
   {
   	   if (!$this->session->userdata('Username'))
   	   {
   	   	  $this->load->view('login');
   	   }
   	   else
   	   {
   	   	  $Username = $this->session->userdata('Username');
          if ($this->person_model->profile($Username,$data))
            {
                $this->load->view('person_profile',$data);
            }
          else
            {
            	$data["error"] = "person_model出错";
            	$this->load->view('error_handle',$data);
          	};
       }
   }

   function myquestions()
   {
      if (!$this->session->userdata('Username'))
   	   {
   	   	  $this->load->view('login');
   	   }
   	   else
   	   {
   	   	  $Username = $this->session->userdata('Username');
          
          if ($this->person_model->myquestions($Username,$data))
            {
                $config['base_url'] = 'http://localhost/index.php/person/person_myquestions';
                $config['total_rows'] = $this->db->get('q2a_questions')->num_rows();
                $config['per_page'] = 10;
                $config['num_links'] = 20;
                $this->pagination->initialize($config);
                $this->load->view('person_myquestions',$data);
            }
          else
            {
            	$data["error"] = "person_model出错";
            	$this->load->view('error_handle',$data);
          	};
       }
   }

   function myanswers()
   {
       if (!$this->session->userdata('Username'))
   	   {
   	   	  $this->load->view('login');
   	   }
   	   else
   	   {
   	   	  $Username = $this->session->userdata('Username');
          $data['Username'] = $Username;
          if ($this->person_model->myanswers($Username,$data))
            {
                $config['base_url'] = 'http://localhost/index.php/person/person_myanswers';
                $config['total_rows'] = $this->db->get('q2a_answers')->num_rows();
                $config['per_page'] = 10;
                $config['num_links'] = 20;
                $this->pagination->initialize($config);
                $this->load->view('person_myanswers',$data);
            }
          else
            {
            	$data["error"] = "person_model出错";
            	$this->load->view('error_handle',$data);
          	};
       }
   }
   
   function login_off()
    {
        $data['error_username'] = "";
        $data['error_password'] = "";
        $this->session->sess_destroy();
        $this->load->view('login',$data);
    }
};

?>