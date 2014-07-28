<?php
class Per_question_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	    $this->load->database();
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
}
?>