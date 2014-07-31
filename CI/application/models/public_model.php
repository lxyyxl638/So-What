<?php
  class Public_model extends CI_Model{
   
   function __construct()
   {
   	  parent::__construct();
   	  $this->load->database();
   }

   function getid($email)
   {
   	  $this->db->select('id');
   	  $query = $this->db->get_where('user',array('email' => $email));
      $row = $query-> row_array();
      return $row['id'];
   }

   function getemail($id)
   {
   	  $this->db->select('email');
   	  $query = $this->db->get_where('user',array('id' => $id));
      $row = $query-> row_array();
      return $row['email'];
   }

   function uidrealname(& $message,$uid)
   {
      $this->db->select('realname');
      $this->db->where('uid',$uid);
      $query = $this->db->get_where('user_profile');
      $row = $query->row_array();
      $message['uidrealname'] = $row['realname'];
      return TRUE;
   }

   /*判断是否有照片*/
     function get_photo($uid)
     {
         $this->db->select('photo');
         $this->db->where('uid',$uid);
         $query = $this->db->get('user_profile');
         $row = $query-> row_array();
         if ($row['photo'] == 1) 
            {
                return TRUE;
            }
         else
            {
                return FALSE;
            }

     }
};
?>