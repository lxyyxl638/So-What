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

class Public_function extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('crud');
        $this->load->library('session');
        $this->load->model('public_model');
    }

	function myrealname_get()
    {
    	$status = $this->session->userdata('status');
        if (isset($status) && $status === 'OK')
        {
           $message['myrealname'] = $this->session->userdata('realname');
           $this->response($message,200);
        }
        else
        {
          $message['state'] = "fail";
          $message['detail'] = "You didn't login!";
          $this->response($message,200);
        }
        $this->response($message,200);
    }

    function uidrealname_get($uid)
    {
    	$status = $this->session->userdata('status');
        if (isset($status) && $status === 'OK')
        {
            $message = '';
            if (!$this->public_model->uidrealname($message,$uid))
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