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

class Signup extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->model('crud');
        $this->load->library(array('session','encrypt'));
        $this->load->model('signup_model');
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

    function firstsignup_post()
    {
         $_POST = $this->initial();
         
         if ($this->form_validation->run('signup') === FALSE)
          {
             $message['state'] = "fail";
             $message['detail'] = "验证失败";
             $this->response($message,200);
          }
         else 
         {
             $email = $this->input->post('email');
             $password = $this->input->post('password');
             $lastname = $this->input->post('lastname');
             $firstname = $this->input->post('firstname');
             $realname = $lastname.$firstname;
             $password = $this->encrypt->encode($password);
             $signupdate = date('Y-m-d H:i:s',time());
             $data = array( 
                            'id' => 0,
                            'email'=> $email,
                            'password'=> $password,
                            'realname' => $realname,
                            'signupdate' => $signupdate,
                            'lastlogin'=> $signupdate,
                            'lastloginfail'=> 0,
                            'numloginfail' => 0
                           );
             $message = $this->crud->insert('user',$data);
             $query = $this->db->get_where('user',array('email' => $email));
             $row = $query->row_array();
             $temp = array(
                             'id' => 0,
                             'uid' => $row['id'], 
                             'realname' => $realname,
                             'lastask' => 0
                          );
             $this->crud->insert('user_profile',$temp);

             if ($message['state'] == 'success')
               {
                     $query = $this->db->get_where('user',array('email'=>$email));
                     $row = $query->row_array();
                     $id = $row['id'];
                     $newdata = array(
                       'email' => $email,
                       'password' => $password,
                       'uid' => $id,
                       'realname' => $realname,
                       'status' => 'OK'
                       );             
                     $this->session->set_userdata($newdata);            
                     $message['state'] = 'success';
                     $this->response($message,200);
               }
              else 
              {
                 $message['detail'] = "signup fail";
                 $this->response($message,200);
              }
         }
            
    }

    function secondsignup_post()
    {
       $message = '';
       $_POST = $this->initial();
       if (!$this->signup_model->secondsignup($message))
       {
          $message['state'] = "fail"; 
       }
       else
       {
          $message['state'] = "success";
       }

       $this->response($message,200);
    }

    function thirdsignup_post()
    {
       $message ='';
       $_POST = $this->initial();
       if (!$this->signup_model->thirdsignup($message))
       {
         $message['state'] = "fail";
       }
       else
       {
         $message['state'] = "success";
       }

       $this->response($message,200);
    }

}