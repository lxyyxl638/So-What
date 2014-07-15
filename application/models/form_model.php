<?php
class Form_model extends CI_Model{

  function __construct()
  {
     parent::__construct();
	 $this->load->database();
     $this->load->library('session');
  }
  
  function next_signup()
  {
     $Username = $this->session->userdata('Username');
     if ($Username === FALSE) return FALSE;
  	 $Realname = $this->input->post('realname');
  	 $Email = $this->input->post('email');
  	 //$Photo = $this->input->post('Photo');
     $uid = $this->session->userdata('uid');
     if ($uid === FALSE) return FALSE;
     $data = array(
     	             'uid' => $uid,
                   'Username' =>$Username,
     	             'Realname' => $Realname,
     	             'Email' => $Email,
     	             //'Photo' => $Photo,
                   'lastask' => 0
     	            );
     $this->session->set_userdata('Realname',$Realname);
     return $this->db->insert('user_profile',$data);
  }
};
?>