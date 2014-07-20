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

class Form extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('encrypt');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Form_model');
    }
    
    function signin_post()
    {

             $Username = $this->input->post('username',TRUE);
             $Password = $this->input->post('password',TRUE);

             $data['error_username'] = "";
             $data['error_password'] = "";
             if ($Username !==FALSE && $Password !==FALSE)
               {
                  $query = $this->db->get_where('user',array('username' => $Username));
                 if ($query->num_rows() > 0)
                 {
                     $row = $query->row_array();
                     $CheckPassword = $row['password'];
                     $CheckPassword = $this->encrypt->decode($CheckPassword);
                     if ($CheckPassword === $Password)
                      {
                        $id = $row['uid'];
                        $data = array( 'lastlogin' => date("d-m-y G:i"),
                                       'numloginfail' => '0',
                                       'lastloginfail' => '0');

                        $this->db->update('user',$data,array('Username' => $Username));
                        $query = $this->db->get_where('user_profile',array('Username' => $Username));
                        $row = $query->row_array();
                        $Realname = $row['realname'];
                        $newdata = array(
                                          'Username' => $Username,
                                          'Password' => $Password,
                                          'Realname' => $Realname
                                         );                      
                        $this->session->set_userdata($newdata);        
                        redirect('http://localhost/So-What/angular/main/#/home', 'location', 301);      
                      }
                    else  
                      { 
                         $data['error_username'] = "";
                         $data['error_password'] = "密码错误";
                         $message = '';
                        $message = array('result' => "fail,password wrong");
                        $this->response($message,200);
                      }
                 }
                 else
                 {
                    $data['error_username'] = "用户名不存在";
                    $data['error_password'] = "";
                    $message = '';
                    $message = array('result' => "fail,user doesn't exist");
                    $this->response($message,200);
                 }
              }
    }
    
}