<meta content="text/html; charset=utf-8" http-equiv="Content-Type">	
<?php
class Form extends CI_Controller {
 
 function __construct()
 {
    parent::__construct();
	$this->load->database();
	$this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('encrypt');
    $this->load->model('Form_model');
 }
 
 function index()
 {
 	if (!$this->session->userdata('Username'))
 	{
     $Username = $this->input->post('username',TRUE);
	 $Password = $this->input->post('password',TRUE);

	 $data['error_username'] = "";
	 $data['error_password'] = "";
	 if ($Username !==FALSE && $Password !==FALSE)
	   {
          $query = $this->db->get_where('user',array('username' => $Username));
		 if ($query->num_rows() > 0)
		 {
		     $row = $query->row_array();
		     $CheckPassword = $this->encrypt->decode($row['password']);
		     if ($CheckPassword === $Password)
		      {
			  	$id = $row['uid'];
			  	$data = array( 'lastlogin' => date("d-m-y G:i"),
			  		           'numloginfail' => '0',
			  		           'lastloginfail' => '0');

			  	$this->db->update('user',$data,array('Username' => $Username));
			  	$query = $this->db->get_where('user_profile',array('Username' => $Username));
			  	$row = $query->row_array();
			  	$Realname = $row['realname'];
			    $newdata = array(
				                  'Username' => $Username,
								  'Password' => $Password,
								  'Realname' => $Realname
				                 );						 
		        $this->session->set_userdata($newdata);				   
			    $this->load->view('homepage');
				return;  
			  }
			else  
			  { 
			     $data['error_username'] = "";
			     $data['error_password'] = "密码错误";
			  }
		 }
		 else
		 {
		     $data['error_username'] = "用户名不存在";
			 $data['error_password'] = "";
		 }
	  }
	 $this->load->view('login',$data);
   }
   else
   {
   	 $this->load->view('homepage');
   }
 }
 
 function signup()
 {
    if ($this->form_validation->run('signup') === FALSE)
	   {
          $this->load->view('signup');
	   }
	else 
	   {
	     $Username = $this->input->post('username');
		 $Password = $this->input->post('password');
		 $Password = $this->encrypt->encode($Password);
		 $SignupDate = date("d-m-y G:i");
		 $data = array(
		            'username'=> $Username,
					'password'=> $Password,
					'signupdate' => $SignupDate,
					'lastlogin'=> $SignupDate,
					'lastloginfail'=> 0,
					'numloginfail' => 0
		            );
		 $this->db->insert('user',$data);
		 $query = $this->db->get_where('user',array('Username'=>$Username));
		 $row = $query->row_array();
		 $uid = $row['uid'];
		 $newdata = array(
				        'Username' => $Username,
						'Password' => $Password,
						'uid' => $uid
				          );						 
		 $this->session->set_userdata($newdata);				   	
	     $this->load->view('next_signup');
	   }
 }
function next_signup()
{
	if ($this->form_validation->run('next_signup') === FALSE)
	{
		$this->load->view('next_signup');
	}
    else
    {
        if (!$this->Form_model->next_signup())
        {
        	$data['error'] = "注册失败";
        	$this->load->view('error_handle',$data);
        }
        else
        {
            $this->load->view('form_success');
        }
    }	
} 
} 
?>