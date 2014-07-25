<?php
class Question_center_model extends CI_Model
{
   function __construct()
   {
     parent::__construct();
	 $this->load->database();
	 $this->load->library('session');
   } 
  
 function ask(& $qid)
  {
    $uid = $this->session->userdata('uid');
    $username = $this->session->userdata('username');
	$realname = $this->session->userdata('realname');
	$datetime = time();
	$query = $this->db->get_where('user_profile',array('uid' => $uid));
	$row = $query->row_array();
	$lastask = strtotime($row['lastask']);
  	  
	if (!isset($lastask) || ($datetime - $lastask) > 60)
     {	
	   $data = array(
	     'uid' => $uid,
	     'realname' => $realname,
	     'date' => date('Y-m-d H:i:s',$datetime),
	     'title' => $this->input->post('title'),
	     'content' => $this->input->post('content'),
	     'view_num' => 0,
	     'answer_num' => 0
	     );
	     if ($this->db->insert('q2a_question',$data))
		  {
		  	 $this->db->select('id');
		  	 $this->db->order_by("id","desc");
		  	 $query = $this->db->get('q2a_question');
             $row = $query->row_array();
             $qid = $row['id'];
		     $data = array(
			                'lastask' => date('Y-m-d H:i:s',$datetime)
			              );
			return ($this->db->update('user_profile',$data,array('uid' => $uid)));
		  }
		 else return FALSE;
	  }
	else 
       return FALSE;	
  }

	function tag($qid)
	{
		$data = '';
		$data['tag1'] = $this->input->post("tag1");
	    $data['tag2'] = $this->input->post("tag2");
	    $data['tag3'] = $this->input->post("tag3");
	    $data['tag4'] = $this->input->post("tag4");
	    $data['tag5'] = $this->input->post("tag5");
	    foreach ($data as $key => $value)
	    {
	    	if (!empty($data[$key]))
	    	{
		    	$this->db->select('id');
		        $query = $this->db->get_where('tag',array('tag' => $value));
		        if ($query->num_rows() == 0)
		        {
		            $this->db->insert('tag',array('tag' => $value));
		            $this->db->select('id');
		            $query = $this->db->get_where('tag',array('tag' => $value));
		        }
		        $row = $query-> row_array();
		        $tid = $row['id'];
		        $this->db->insert('tag_question',array('tid' => $tid,'qid' => $qid));
	        }
	    }
	}
	// function answer($id)
	// {
	//    $Username = $this->session->userdata('Username');
	//    $query = $this->db->get_where('q2a_questions',array('id'=>$id));
	//    $row = $query->row_array();
	//    $title = $row['title'];
	//    $date = date('d-m-y G:i');
	//    $data = array(
	//                'qid' => $id,
	//                'title' => $title,
	// 			   'answer' => $this->input->post('text'),
	// 			   'username'=> $Username,
	// 			   'good' => 0,
	// 			   'bad' => 0,
	// 			   'date' => $date
	//                 );
	//    $query = "update q2a_questions set answer_num = answer_num+1 where id = '$id'";
	//    mysql_query($query);
	   
	// 	return $this->db->insert('q2a_answers',$data);			
	// }  
	// function good($id)
	// {
	//   if (!$this->session->userdata('valuation'.$id))
	//     {
	// 	   $this->session->set_userdata('valuation'.$id,true);
	// 	   $query = "update q2a_answers set good=good+1 where qid='$id'";
	// 	   return mysql_query($query);  
	// 	} 
	//    else return false;	
	// }
	// function bad($id)
	// {
	//   if (!$this->session->userdata('valuation'.$id))
	//     {
	// 	   $this->session->set_userdata('valuation'.$id,true);
	// 	   $query = "update q2a_answers set bad=bad+1 where qid='$id'";
	// 	   return mysql_query($query);
	// 	}
	//   else return false;  
	// }
 }
?>