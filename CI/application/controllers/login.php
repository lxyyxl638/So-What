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
        $this->load->library('encrypt');
        $this->load->library('session');
    }
    
    // function initial()
    // {
    //      $xml = file_get_contents('php://input');
    //      $xml = simplexml_load_string($xml);
    //      foreach($xml->children() as $child)
    //      { 
    //          $_POST[$child->getName()] = "$child";
    //      }
    //      return $_POST;
    // }

    function userlogin_post()
    {
         $email = $this->input->post('email',TRUE);
         $password = $this->input->post('password',TRUE);

         if ($email !==FALSE && $password !==FALSE)
          {
             $query = $this->db->get_where('user',array('email' => $email));
             if ($query->num_rows() > 0)
             {
                 $row = $query->row_array();
                 $checkpassword = $this->encrypt->decode($row['password']);
                 if ($checkpassword === $password)
                 {
                    $id = $row['id'];
                    $realname = $row['realname'];
                    $data = array( 
                                   'lastlogin' => date('Y-m-d H:i:s',time()),
                                   'numloginfail' => 0
                                   //'lastloginfail' => 
                                 );
                    $this->db->where('id',$id);
                    $this->db->update('user',$data);
                    
                    $newdata = array(
                                  'email' => $email,
                                  'password' => $password,
                                  'realname' => $realname,
                                  'uid' => $id,
                                  'status' => 'OK'
                                 );                      
                    $this->session->set_userdata($newdata);                
                    $message['state'] = 'success';
                    if ($email === "root@gmail.com")
                    {
                       $message['state'] = 'root';
                    }
                    $this->response($message,200);
      
                }
                else  
                { 
                     // $lastloginfail = strtotime($row['lastloginfail']);
                     // $now = date('Y-m-d H:i:s',time());
                     // if ($now - $lastloginfail >= 60 * 15)
                     // {
                     //    $this->db->set('numloginfail',0);
                     //    $this->db->where('email',$email);
                     //    $this->db->update('user');
                     // }
                     // $data = array(
                     //              'lastloginfail' => date('Y-m-d H:i:s',time());
                     //              'numloginfail' => 'numloginfail + 1';
                     //              );
                     // $this->db->where('email',$email);
                     // $this->db->update('user',$data);
                     $message['state'] = 'fail';
                     $message['detail'] = 'pswWrong';
                     $this->response($message,200);
                }
             }
             else
             {
                 $message['state'] = 'fail';
                 $message['detail'] = "emailNotExist";
                 $this->response($message,200);
             }
          }
          else
          {
             $message['state'] = 'fail';
             $message['detail'] = "emailNotExist";
             $this->response($message,200);
          }
            
    }

    function user_logout_get()
    {
       $this->session->sess_destroy();
       $message['state'] = "success";
       $this->response($message,200);
    }
}