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

class QA_center extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('crud');
        $this->load->library('encrypt');
        $this->load->library('session');
        $this->load->model('QA_center_model');
        $this->load->model('public_model');
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
           $result = $query->result_array();
           foreach ($result as $key => $value)
           {
              $uid = $value['uid'];
              $value['location'] = $this->public_model->middle_photo_get($uid);
              $value['best_answer'] = $this->QA_center_model->get_best_answer($value['id']);
              $value['follow'] = $this->QA_center_model->get_follow($value['id']);
              $message[$key] = $value;
           }
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
           $message = '';
           $uid = $this->session->userdata('uid');
           $order = "select * from q2a_question where id in (select distinct qid from tag_question where tid in (select tid from user_tag where uid = 5)) order by date desc";
           $query = $this->db->query($order);
           $result = $query->result_array();
           foreach ($result as $key => $value)
           {
              $uid = $value['uid'];
              $value['location'] = $this->public_model->middle_photo_get($uid);
              $value['best_answer'] = $this->QA_center_model->get_best_answer($value['id']);
              $value['follow'] = $this->QA_center_model->get_follow($value['id']);
              $message[$key] = $value;
           }
           
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
        $result = $query->result_array();
           foreach ($result as $key => $value)
           {
              $uid = $value['uid'];
              $value['location'] = $this->public_model->middle_photo_get($uid);
              $value['best_answer'] = $this->QA_center_model->get_best_answer($value['id']);
              $value['follow'] = $this->QA_center_model->get_follow($value['id']);
              $message[$key] = $value;
           }
        $this->response($message,200);
     }
     else
     {
        $message['state'] = "fail";
        $message['detail'] = "You didn't login!";
        $this->response($message,200);
     }
   }

/*提问*/
  function question_ask_post()
    {
        //$_POST = $this->initial();
        $status = $this->session->userdata('status');

        if (isset($status) && $status === 'OK')
        {
           $qid = 0;
           if ($this->QA_center_model->ask($qid)!==FALSE)
            {
                 $this->QA_center_model->tag($qid);
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

  /*查看问题内容*/
  function view_question_get($qid)
    {
        $status = $this->session->userdata('status');

        if (isset($status) && $status === 'OK')
        {
           $this->db->set('view_num','view_num + 1',FALSE);
           $this->db->where('id',$qid);
           $this->db->update('q2a_question');

           $query = $this->db->get_where('q2a_question',array('id' => $qid));
           $message = $query->row_array();
           $message['state'] = "success";
           $this->response($message,200);
        }
        else
        {
          $message['state'] = "fail";
          $message['detail'] = "You didn't login!";
          $this->response($message,200);
        }
    }

/*查看问题回答*/
  function view_answer_get($qid,$offset = 0)  
    {
        $status = $this->session->userdata('status');

        if (isset($status) && $status === 'OK')
        {
           $this->db->order_by("good","desc");
           $this->db->limit(10,$offset);
           $query = $this->db->get_where('q2a_answer',array('qid' => $qid));
           $result = $query->result_array();
           foreach ($result as $key => $value)
           {
              $value['mygood'] = $this->QA_center_model->get_mygood($value['id']);
              $message[$key] = $value;
           }
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
    // $_POST = $this->initial();
     $status = $this->session->userdata('status');

     if (isset($status) && $status === 'OK')
     {
        $content = $this->input->post('content');
        if ($content != FALSE)
         {
            if ($this->QA_center_model->answer($qid,$content) != FALSE)
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

  function good_get($qid,$aid)
  {
      $status = $this->session->userdata('status');
      if (isset($status) && $status === 'OK')
      {
          if ($this->QA_center_model->good($qid,$aid) != FALSE)
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

  function bad_get($qid,$aid)
  {
      $status = $this->session->userdata('status');
      if (isset($status) && $status === 'OK')
      {
          if ($this->QA_center_model->bad($qid,$aid) != FALSE)
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

/*（取消）关注某个问题*/
  function question_attention_get($qid)
  {
      $message = '';
      $status = $this->session->userdata('status');
        if (isset($status) && $status === 'OK')
        { 
           $follow = 0;
           if (!$this->QA_center_model->question_attention($qid,$follow))
           {
              $message['state'] = "fail";
              $this->response($message,200);
           }
           else
           {
              $message['follow'] = $follow;
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

  function get_answer_get($aid)
  {
      $message = '';
      $status = $this->session->userdata('status');
        if (isset($status) && $status === 'OK')
        { 
           if (!$this->QA_center_model->get_answer($message,$aid))
           {
              $message['state'] = "fail";
              $this->response($message,200);
           }
           else
           {
              $message['mygood'] = $this->QA_center_model->get_mygood($aid);
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