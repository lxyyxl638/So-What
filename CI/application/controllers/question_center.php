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

class Question_center extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('crud');
        $this->load->library('encrypt');
        $this->load->library('session');
        $this->load->model('Question_center_model');
    }

/*显示一个月内的提问*/
	function question_date_get()
    {
        $status = $this->session->userdata('status');

        if (isset($status) && $status === 'OK')
        {
           $time_point = date('Y-m-d H:i:s',time() - 30 * 60 * 60 * 24);
           $this->db->where('date >',$time_point);
           $this->db->order_by("date","desc");
           $query = $this->db->get('q2a_question');
           $message = $query->result_array();
           //$message['state'] = "success";
           $this->response($message,200);
        }
        else
        {
          $message['state'] = "fail";
          $message['detail'] = "You didn't login!";
          $this->response($message,200);
        }
    }

/*显示用户关注的话题*/
  function question_focus_get()  
    {
        $status = $this->session->userdata('status');

        if (isset($status) && $status === 'OK')
        {
           $uid = $this->session->userdata('uid');
           $order = "select * from q2a_question where id in (select distinct qid from tag_question where tid in (select tid from user_tag where uid = 5)) order by date desc";
           $query = $this->db->query($order);
           $message = $query->result_array();
           //$message['state'] = 'success';
           $this->response($message,200);
        }
        else
        {
           $message['state'] = "fail";
           $message['detail'] = "You didn't login!";
           $this->response($message,200);
        }
        
    }

/*显示当日最多浏览*/
  function question_day_get()
   {
     $status = $this->session->userdata('status');

     if (isset($status) && $status === 'OK')
     {
        $time_point = date('Y-m-d H:i:s',time() - 60*60*24);
        $this->db->where('date >',$time_point);
        $this->db->order_by("view_num","desc");
        $query = $this->db->get('q2a_question');
        $message = $query->result_array();
        //$message['state'] = "success";
        $this->response($message,200);
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