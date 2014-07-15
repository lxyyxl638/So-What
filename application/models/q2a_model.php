<?php
class Q2a_model extends CI_Model
{
  function __construct()
  {
    parent::__construct();
	$this->load->database();
	$this->load->library('session');
  }
  
 function ask()
  {
    $Username = $this->session->userdata('Username');
	$Realname = $this->session->userdata('Realname');
	$Datetime=date("d-m-y G:i");
	$query = $this->db->get_where('user_profile',array('Username' => $Username));
	if ($query->num_rows()>0)
	  {
	    foreach ($query->result_array() as $row)
		 {
		    $Lastask = $row['lastask'];
		 }
	  }
  	  
	if (!isset($Lastask) || abs(strtotime($Datetime) - strtotime($Lastask)) > 60)
     {	
	   $data = array(
	     'username' => $Username,
	     'realname' => $Realname,
	     'date' => $Datetime,
	     'title' => $this->input->post('title'),
	     'text' => $this->input->post('text'),
	     'view_num' => 0,
	     'answer_num' => 0
	     );
	     if ($this->db->insert('q2a_questions',$data))
		  {
		     $data = array(
			           'lastask' => $Datetime
			              );
			return ($this->db->update('user_profile',$data,array('username' => $Username)));
		  }
		 else return false;
	  }
	else 
       return false;	
  }
function answer($id)
{
   $Username = $this->session->userdata('Username');
   $query = $this->db->get_where('q2a_questions',array('id'=>$id));
   $row = $query->row_array();
   $title = $row['title'];
   $date = date('d-m-y G:i');
   $data = array(
               'qid' => $id,
               'title' => $title,
			   'answer' => $this->input->post('text'),
			   'username'=> $Username,
			   'good' => 0,
			   'bad' => 0,
			   'date' => $date
                );
   $query = "update q2a_questions set answer_num = answer_num+1 where id = '$id'";
   mysql_query($query);
   
	return $this->db->insert('q2a_answers',$data);			
}  
function good($id)
{
  if (!$this->session->userdata('valuation'.$id))
    {
	   $this->session->set_userdata('valuation'.$id,true);
	   $query = "update q2a_answers set good=good+1 where qid='$id'";
	   return mysql_query($query);  
	} 
   else return false;	
}
function bad($id)
{
  if (!$this->session->userdata('valuation'.$id))
    {
	   $this->session->set_userdata('valuation'.$id,true);
	   $query = "update q2a_answers set bad=bad+1 where qid='$id'";
	   return mysql_query($query);
	}
  else return false;  
}
}
?>