<?php
class QA_center_model extends CI_Model
{
   function __construct()
   {
     parent::__construct();
	 $this->load->database();
	 $this->load->library('session');
   } 

 
 // function initial()
 //    {
 //         $xml = file_get_contents('php://input');
 //         $xml = simplexml_load_string($xml);
 //         foreach($xml->children() as $child)
 //         { 
 //             $_POST[$child->getName()] = "$child";
 //         }
 //         return $_POST;
 //    }
 function question_date_get(& $message)
 {
      $time_point = date('Y-m-d H:i:s',time() - 30 * 60 * 60 * 24);
      $this->db->select('id,title,uid,date,realname,answer_num,view_num');
      $this->db->where('date >',$time_point);
      $this->db->order_by("date","desc");
      $query = $this->db->get('q2a_question');
      $result = $query->result_array();
      foreach ($result as $key => $value)
        {
          $uid = $value['uid'];
          $value['location'] = $this->public_model->middle_photo_get($uid);
          $best_answer = $this->QA_center_model->get_best_answer($value['id']);
          $this->get_answer($value['best_answer'],$best_answer);
          $value['follow'] = $this->QA_center_model->get_follow($value['id']);
          $message[$key] = $value;
        }
      return TRUE;
 }
 
 function question_focus_get(& $message)
 {
      $uid = $this->session->userdata('uid');
      $order = "select * from q2a_question where id in (select distinct qid from tag_question where tid in (select tid from user_tag where uid = 5)) order by date desc";
      $query = $this->db->query($order);
      $result = $query->result_array();
       foreach ($result as $key => $value)
       {
          $uid = $value['uid'];
          $value['location'] = $this->public_model->middle_photo_get($uid);
          $best_answer = $this->QA_center_model->get_best_answer($value['id']);
          $this->get_answer($value['best_answer'],$best_answer);
          $value['follow'] = $this->QA_center_model->get_follow($value['id']);
          $message[$key] = $value;
       }
       return TRUE;
 }

 function question_day_get(& $message)
 {
     $time_point = date('Y-m-d H:i:s',time() - 60*60*24);
     $this->db->select('id,title,uid,date,realname,answer_num,view_num');
     $this->db->where('date >',$time_point);
     $this->db->order_by("view_num","desc");
     $query = $this->db->get('q2a_question');
     $result = $query->result_array();
     foreach ($result as $key => $value)
       {
           $uid = $value['uid'];
           $value['location'] = $this->public_model->middle_photo_get($uid);
           $value['best_answer'] = $this->QA_center_model->get_best_answer($value['id']);
           $best_answer = $this->QA_center_model->get_best_answer($value['id']);
           $this->get_answer($value['best_answer'],$best_answer);
           $value['follow'] = $this->QA_center_model->get_follow($value['id']);
           $message[$key] = $value;
        }
    return TRUE;
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
		$realname = $this->session->userdata('realname');
        $data = array(
        	            'qid' => $qid,
        	            'content' => $content,
        	            'realname' => $realname,
        	            'uid' => $uid,
        	            'good' => 0,
        	            'bad' => 0,
        	            'date' => date('Y-m-d H:i:s',time())
        	         );
        $this->db->insert('q2a_answer',$data);
        return TRUE;
	}

	function good($qid,$aid)
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
            	$this->db->delete('answer_vote',array('uid' => $uid,'aid' => $aid));
                $this->db->set('good','good - 1',FALSE);
                $this->db->where('id',$aid);
                return $this->db->update('q2a_answer');
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
            	        'qid' => $qid,
            	        'uid' => $uid,
            	        'aid' => $aid,
            	        'vote' => 1 
            	         );
            $this->db->insert('answer_vote',$data);
            $data = array(
            	         'uid' => $uid,
            	         'aid' => $aid
            	         );
            
            $this->db->set('good','good + 1',FALSE);
            $this->db->where('id',$aid);
            return $this->db->update('q2a_answer');
		}
	}

	function bad($qid,$aid)
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
            	$this->db->delete('answer_vote',array('uid' => $uid,'aid' => $aid));
                $this->db->set('bad','bad - 1',FALSE);
                $this->db->where('id',$aid);
                return $this->db->update('q2a_answer');
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
            	        'qid' => $qid,
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
	
	function question_attention($qid,& $follow)
	{
		$uid = $this->session->userdata('uid');
		$query = $this->db->get_where('user_question',array('uid' => $uid,'qid' => $qid));
		if ($query->num_rows() > 0)
		{
		   if (!$this->db->delete('user_question',array('uid' => $uid,'qid' => $qid)))
		   {
		   	  $message['detail'] = "delete fails";
		   	  return FALSE;
		   }			
		   else 
		   {
		   	  $follow = 0;
		   	  return TRUE;
		   }
		}
		else
		{
			$data = array(
				            'uid' => $uid,
				            'qid' => $qid,
				            'date' => date('Y-m-d H:i:s',time())
				         );
			if (!$this->db->insert('user_question',$data))
			{
				$message['detail'] = "insert user_question fails";
				return FALSE;
			}
			else
			{
			   $follow = 1;
			   return TRUE;
			}
		}
	}
   
   /*检测当前用户是否关注此问题*/
	function get_follow($qid)
	{
		$uid = $this->session->userdata('uid');
		$query = $this->db->get_where('user_question',array('uid' => $uid,'qid' => $qid));
		if ($query->num_rows() > 0)
		{
            return "1";
		}
		else
		{
            return "0";
		}
	}

	function get_best_answer($qid)
	{ 
		$this->db->select('id');
		$this->db->where('qid',$qid);
		$this->db->order_by('good desc,bad asc');
		$query = $this->db->get('q2a_answer');
		if ($query->num_rows() > 0)
		{
		    $row = $query->row_array();
            return $row['id'];
        }
        else
        {
        	return '0';
        }
	}
    
    function get_mygood($aid)
    {
    	$uid = $this->session->userdata('uid');
    	$this->db->select('vote');
    	$this->db->where('uid',$uid);
    	$this->db->where('aid',$aid);
    	$query = $this->db->get('answer_vote');
    	if ($query->num_rows()>0)
    	{
    		$row = $query->row_array();
    		return $row['vote'];
    	}
    	else
    	{
    		return 0;
    	}
    }
	function get_answer(& $message,$aid)
	{
		$this->db->where('id',$aid);
		$query = $this->db->get('q2a_answer');
		$message = $query->row_array();
		return TRUE;
	}
 }
?>