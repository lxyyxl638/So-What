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

class Login extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('crud');
        $this->load->library('encrypt');
        $this->load->library('session');
    }

	function userlogin_get()
    {
        
    }
    
    function userlogin_post()
    {
        //$data = var_dump($_POST);

         $username = $this->input->post('username',TRUE);
         $password = $this->input->post('password',TRUE);
         // $username = $_POST["username"];
         // $password = $_POST["password"];
         //$message['username'] = $_POST["username"];
         //$message['password'] = $_POST["password"];

      //   $this->response($message,200);

             if ($username !==FALSE && $password !==FALSE)
              {
                  $query = $this->db->get_where('user',array('username' => $username));
                 if ($query->num_rows() > 0)
                 {
                     $row = $query->row_array();
                     $checkpassword = $this->encrypt->decode($row['password']);
                     if ($checkpassword === $password)
                     {
                        $id = $row['id'];
                        $data = array( 
                                       'id' => $id,
                                       'lastlogin' => date("d-m-y G:i"),
                                       'numloginfail' => '0',
                                       'lastloginfail' => '0'
                                     );
                        $message = $this->crud->insert('user',$data);
                        if ($message['state'] == "success")
                        {
                            $query = $this->db->get_where('user',array('username' => $username));
                            $row = $query->row_array();
                            $realname = $row['realname'];
                            $newdata = array(
                                          'username' => $username,
                                          'password' => $password,
                                          'realname' => $realname
                                         );                      
                            $this->session->set_userdata($newdata);                

                            $message['state'] = 'success';
                            $this->response($message,200);
                        }
                        else
                        {
                            $message['state'] = 'fail';
                            $message['detail'] = "登陆失败";
                            $this->response($message,200);
                        }  
                    }
                    else  
                      { 
                         $message['state'] = 'fail';
                         $message['detail'] = '密码错误';
                         $this->response($message,200);
                      }
                 }
                 else
                 {
                     $message['state'] = 'fail';
                     $message['detail'] = '用户名不存在';
                     $this->response($message,200);
                 }
              }
              else
              {
                 $message['state'] = 'fail';
                 $message['detail'] = '用户名不存在';
                 $this->response($message,200);
              }
            
    }
}