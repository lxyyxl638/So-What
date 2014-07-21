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
    }

	function usersignup_get()
    {
        
    }
    
    function usersignup_post()
    {
         if ($this->form_validation->run('signup') === FALSE)
          {
             $message['state'] = "fail";
             $message['detail'] = "验证失败";
             $this->response($message,200);
          }
         else 
         {
             // $data = var_dump($_POST);
             // $username = $_POST["username"];
             // $password = $_POST["password"];
             // $realname = $_POST["realname"];
             $username = $this->input->post('username');
             $password = $this->input->post('password');
             $realname = $this->input->post('realname');
             $password = $this->encrypt->encode($password);
             $signupdate = date("d-m-y G:i");
             $data = array( 
                            'id' => 0,
                            'username'=> $username,
                            'password'=> $password,
                            'realname' => $realname,
                            'signupdate' => $signupdate,
                            'lastlogin'=> $signupdate,
                            'lastloginfail'=> 0,
                            'numloginfail' => 0
                           );
            $message = $this->crud->insert('user',$data);
            if ($message['state'] == 'success')
               {
                     $query = $this->db->get_where('user',array('username'=>$username));
                     $row = $query->row_array();
                     $uid = $row['id'];
                     $newdata = array(
                       'username' => $username,
                       'password' => $password,
                       'uid' => $id
                       );             
                   $this->session->set_userdata($newdata);            
                   $message['state'] = 'success';
                   $this->response($message,200);
              }
              else 
              {
                 $message['detail'] = "插入数据失败";
                 $this->response($message,200);
              }
     }
            
    }
}