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
  function profile_get()
  {
     $status = $this->session->userdata('status');
        if (isset($status) && $status === 'OK')
        {
            $message = '';
            if (!$this->Personal_center_model->profile($message))
            {
              $message['state'] = "fail";
              $message['detail'] = "fail change profile";
              $this->response($message,200);
            }
            else
            {
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

	function profile_post()
    {
        $status = $this->session->userdata('status');
        if (isset($status) && $status === 'OK')
        {
            $message = '';
            if (!$this->Personal_center_model->profile($message))
            {
            	$message['state'] = "fail";
            	$message['detail'] = "fail change profile";
            	$this->response($message,200);
            }
            else
            {
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
  
  /*我的提问*/
  function my_question_get($limit = 10,$offset = 0)
  {
     $status = $this->session->userdata('status');
        if (isset($status) && $status === 'OK')
        {
            $message = '';
            if (!$this->Personal_center_model->my_question($message,$limit,$offset))
            {
              $message['state'] = "fail";
              $message['detail'] = "fail show questions";
              $this->response($message,200);
            }
            else
            {
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
  /*我的回答*/
  function my_answer_get($limit = 10,$offset = 0)
  {
      $status = $this->session->userdata('status');
        if (isset($status) && $status === 'OK')
        {
            $message = '';
            if (!$this->Personal_center_model->my_answer($message,$limit,$offset))
            {
              $message['state'] = "fail";
              $message['detail'] = "fail show answers";
              $this->response($message,200);
            }
            else
            {
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

  /*我关注的问题*/
  function my_attention_get($limit = 10,$offset = 0)
  {
      $status = $this->session->userdata('status');
        if (isset($status) && $status === 'OK')
        {
            $message = '';
            if (!$this->Personal_center_model->my_attention($message,$limit,$offset))
            {
              $message['state'] = "fail";
              $message['detail'] = "fail show attention";
              $this->response($message,200);
            }
            else
            {
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

  /*回复或者发站内信*/
  function letter_send_post()
  {
     $status = $this->session->userdata('status');
    if (isset($status) && $status === 'OK')
        {
            $message = '';
            if (!$this->Personal_center_model->letter_send($message))
            {
              $message['state'] = "fail";
              $this->response($message,200);
            }
            else
            {
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

  /*未读信息提醒*/
  function letter_notify_get()
  {
     $status = $this->session->userdata('status');
        if (isset($status) && $status === 'OK')
        {
            $message = '';
            if (!$this->Personal_center_model->letter_notify($message))
            {
              $message['state'] = "fail";
              $this->response($message,200);
            }
            else
            {
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

  /*私信主页*/
  function letter_friend_get()
  {
     $status = $this->session->userdata('status');
        if (isset($status) && $status === 'OK')
        {
            $message = '';
            if (!$this->Personal_center_model->letter_friend($message))
            {
              $message['state'] = "fail";
              $this->response($message,200);
            }
            else
            {
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

  /*聊天历史*/
  function letter_talk_post()
  {
     $status = $this->session->userdata('status');
        if (isset($status) && $status === 'OK')
        {
            $message = '';
            if (!$this->Personal_center_model->letter_talk($message))
            {
              $message['state'] = "fail";
              $this->response($message,200);
            }
            else
            {
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
  
  /*全部设为已读*/
  function letter_set_look_get()
  {
     $status = $this->session->userdata('status');
        if (isset($status) && $status === 'OK')
        {
            $message = '';
            if (!$this->Personal_center_model->set_look($message))
            {
              $message['state'] = "fail";
              $this->response($message,200);
            }
            else
            {
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