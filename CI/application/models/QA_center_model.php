<?php
class QA_center_model extends CI_Model
{
   function __construct()
   {
     parent::__construct();
	 $this->load->database();
	 $this->load->library('session');
   } 
 
 function initial()
    {
         $xml = file_get_contents('php://input');
         $xml = simplexml_load_string($xml);
         foreach($xml->children() as $child)
         { 
             $_POST[$child->getName()] = "$child";
         }
         return $_POST;
    }
    
 function ask(& $qid)
  {
    $uid = $this->session->userdata('uid');
    $email = $this->session->userdata('email');
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
	     'like_num' => 0,
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

	function answer($qid,$content)
	{
		$uid = $this->session->userdata('uid');
        $data = array(
        	            'qid' => $qid,
        	            'content' => $content,
        	            'uid' => $uid,
        	            'good' => 0,
        	            'bad' => 0,
        	            'date' => date('Y-m-d H:i:s',time())
        	         );
        return $this->db->insert('q2a_answer',$data);
        // $query = "select db2_last_insert_id(resource)"
        // $aid = $this->db->query($query);

	}

	function good($aid)
	{
		$uid = $this->session->userdata('uid');
		$query = $this->db->get_where('answer_vote',array('uid' => $uid,'aid' => $aid));
		if ($query->num_rows() > 0)
		{
            /*之前有过评论*/
            $row = $query->row_array();
            if ($row['vote'] == 1)
            {
            	/*已赞*/
                return TRUE;
            }
            else
            {
            	/*已踩*/
                $this->db->delete('answer_vote',array('uid' => $uid,'aid' => $aid));
                $this->db->set('bad','bad - 1',FALSE);
                $this->db->where('id',$aid);
                return $this->db->update('q2a_answer');
            }
		}
		else
		{
            $data = array(
            	        'uid' => $uid,
            	        'aid' => $aid,
            	        'vote' => 1 
            	         );
            $this->db->insert('answer_vote',$data);
            $this->db->set('good','good + 1',FALSE);
            $this->db->where('id',$aid);
            return $this->db->update('q2a_answer');
		}
	}

	function bad($aid)
	{
		$uid = $this->session->userdata('uid');
		$query = $this->db->get_where('answer_vote',array('uid' => $uid,'aid' => $aid));
		if ($query->num_rows() > 0)
		{
            /*之前有过评论*/
            $row = $query->row_array();
            if ($row['vote'] == -1)
            {
            	/*已踩*/
                return TRUE;
            }
            else
            {
            	/*已赞*/
                $this->db->delete('answer_vote',array('uid' => $uid,'aid' => $aid));
                $this->db->set('good','good - 1',FALSE);
                $this->db->where('id',$aid);
                return $this->db->update('q2a_answer');
            }
		}
		else
		{
            $data = array(
            	        'uid' => $uid,
            	        'aid' => $aid,
            	        'vote' => -1 
            	         );
            $this->db->insert('answer_vote',$data);
              $this->db->set('bad','bad + 1',FALSE);
            $this->db->where('id',$aid);
            return $this->db->update('q2a_answer');
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