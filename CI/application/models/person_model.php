<?php
  class Person_model extends CI_Model
  {
     function __construct()
     {
         parent::__construct();
         $this->load->database();
         $this->load->library('form_validation');
         $this->load->library('encrypt');
     }

     function change_password($Username,&$data)
     {
         $OldPassword = $this->input->post('OldPassword');
         $query = $this->db->get_where('user',array('Username'=>$Username));
         if ($query->num_rows()>0)
         {
         	 $row = $query->row_array();
             $CheckPassword = $row['password'];
             $CheckPassword = $this->encrypt->decode($CheckPassword);
             if ($CheckPassword !== $OldPassword) return FALSE;
             $NewPassword = $this->input->post('NewPassword');
             $NewPassword = $this->encrypt->encode($NewPassword);
             $data = array(
             	            'Password' => $NewPassword
             	          );
             $data['Password'] = $NewPassword;
             return $this->db->update('User',$data,array('uid' => $row['uid']));
         }
         else 
         {
         	return FALSE;
         }
     }

     function profile($Username,&$data)
      {
      	   $flag = TRUE;
           
           $newdata = array(
           	                'email' => $this->input->post('email'),
           	                'photo' => $this->input->post('photo')
           	               );
           $flag = $this->db->update('user_profile',$newdata,array('username'=>$Username));
           if ($flag) 
           	 {
                $query = $this->db->get_where('user_profile',array('username'=>$Username));
                $data['profile'] = $query;
             }
           return $flag;
      }

     function myquestions($Username,&$data)
     {
     	 $flag = TRUE;
     	 /*if ($order == 'delete')
     	 {
     	 	$flag = $this->db->delete('q2a_questions',array('qid'=>$qid));
     	 }*/
     	 if ($flag)
     	 	 {
                $query = $this->db->get_where('q2a_questions',array('username' => $Username));
                $data['myquestions'] = $query->result_array();
                $data['myquestion_num'] = $query->num_rows();
             }
         return $flag;    
     } 
     
     function myanswers($Username,&$data)
     {
     	 $flag = TRUE;
     	 // if ($order == 'delete')
     	 // {
     	 // 	$flag = $this->db->delete('q2a_answerss',array('qid'=>$qid));
     	 // }
     	 if ($flag)
     	 	 {
                $flag = $query = $this->db->get_where('q2a_answers',array('username' => $Username));
                $data['myanswers'] = $query->result_array();
                $data['myanswers_num'] = $query->num_rows();
             }
         return $flag;    
     }

    
  };
 ?>