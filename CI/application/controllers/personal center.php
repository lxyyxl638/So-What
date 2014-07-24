<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Personal_Center extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('crud');
        $this->load->library('encrypt');
        $this->load->library('session');
        $this->load->model('Personal_center_model');
    }

/*个人信息完善*/
	function profile_post()
    {
        $status = $this->session->userdata('status');

        if (isset($status) && $status === 'OK')
        {
            if (!$this->Personal_center_model->profile())
            {
            	$message['state'] = "fail";
            	$message['detail'] = "fail change profile";
            	$this->response($message,200);
            }
        }
        else
        {
          $message['state'] = "fail";
          $message['detail'] = "You didn't login!";
          $this->response($message,200);
        }
    }

/*查看问题回答*/
  function view_answer_get($qid,$offset)  
    {
        $status = $this->session->userdata('status');

        if (isset($status) && $status === 'OK')
        {
           $this->db->order_by("good","desc");
           $this->db->limit(10,$offset);
           $query = $this->db->get_where('q2a_answer',array('qid' => $qid));
           $message = $query->result_array();
           $message['state'] = 'success';
           $this->response($message,200);
        }
        else
        {
           $message['state'] = "fail";
           $message['detail'] = "You didn't login!";
           $this->response($message,200);
        }
        
    }

/*添加回答*/
  function answer_post($qid)
   {
     $status = $this->session->userdata('status');

     if (isset($status) && $status === 'OK')
     {
        $content = $this->input->post('content');
        if ($content != FALSE)
         {
            if ($this->Per_question_model->answer($qid,$content) != FALSE)
            {
                $this->db->set('answer_num','answer_num + 1',FALSE);
                $this->db->where('id',$qid);
                $this->db->update('q2a_question');
                $message['state'] = "success";
                $this->response($message,200);
            }
            else
            {
                $message['state'] = "fail";
                $message['detail'] = "insert into db fails";
                $this->response($message,200);     
            }
         }
        else
        {
            $message['state'] = "fail";
            $message['detail'] = "content can't be empty!";
            $this->response($message,200);    
        }
     }
     else
     {
        $message['state'] = "fail";
        $message['detail'] = "You didn't login!";
        $this->response($message,200);
     }
   }

  function good_get($aid)
  {
      $status = $this->session->userdata('status');
      if (isset($status) && $status === 'OK')
      {
          if ($this->Per_question_model->good($aid) != FALSE)
          {
             $this->db->select('good,bad');
             $query = $this->db->get_where('q2a_answer',array('id' => $aid));
             if ($query->num_rows() > 0)
             { 
                $message = $query-> row_array();
                $message['state'] = "success";
                $this->response($message,200);
             }
             else
             {
                $message['state'] = "fail";
                $message['detail'] = "no this answer";
                $this->response($message,200);   
             }  
          }
          else
          {
             $message['state'] = "fail";
             $message['detail'] = "insert good fails";
             $this->response($message,200);
          }
      }
      else
      {
         $message['state'] = "fail";
         $message['detail'] = "You didn't login!";
         $this->response($message,200);
      }
  }

  function bad_get($aid)
  {
      $status = $this->session->userdata('status');
      if (isset($status) && $status === 'OK')
      {
          if ($this->Per_question_model->bad($aid) != FALSE)
          {
             $this->db->select('good,bad');
             $query = $this->db->get_where('q2a_answer',array('id' => $aid));
             if ($query->num_rows() > 0)
             { 
                $message = $query-> row_array();
                $message['state'] = "success";
                $this->response($message,200);
             }
             else
             {
                $message['state'] = "fail";
                $message['detail'] = "no this answer";
                $this->response($message,200);   
             }  
          }
          else
          {
             $message['state'] = "fail";
             $message['detail'] = "insert good fails";
             $this->response($message,200);
          }
      }
      else
      {
         $message['state'] = "fail";
         $message['detail'] = "You didn't login!";
         $this->response($message,200);
      }
  }
  function question_ask_post()
    {
        $status = $this->session->userdata('status');

        if (isset($status) && $status === 'OK')
        {
           $qid = 0;
           if ($this->Question_center_model->ask($qid)!==FALSE)
            {
                 $this->Question_center_model->tag($qid);
                 $message['state'] = "success";
                 $this->response($message,200);
            }
           else
           {
              $message['state'] = "fail";
              $message['detail'] = "Ask fail!";
              $this->response($message,200);
           }   
        }    
        else
        {
            $message['state'] = "fail";
            $message['detail'] = "You didn't login!";
            $this->response($message,200);    
        }
    }
}