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
    }

	function formuser_get()
    {
        if(!$this->get('id'))
        {
        	$this->response(NULL, 400);
        }

        // $user = $this->some_model->getSomething( $this->get('id') );
    	$users = array(
			1 => array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com', 'fact' => 'Loves swimming'),
			2 => array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com', 'fact' => 'Has a huge face'),
			3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => 'Is a Scott!', array('hobbies' => array('fartings', 'bikes'))),
		);
		
    	$user = @$users[$this->get('id')];
    	
        if($user)
        {
            $this->response($user, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }
    
    function formu_post()
    {

        // $message = array('username' => $this->input->post('username'), 'psw' => $this->input->post('password'), 'email' => $this->post('email'), 'message' => 'ADDED!');
        
        // $this->response($message, 200); // 200 being the HTTP response code

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
                     $CheckPassword = $this->encrypt->decode($row['password']);
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
                        //$this->load->view('homepage');
                        $message = '';
                        $message = array('result' => "success");
                        $this->response($message,200);  
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
    
    function user_delete()
    {
    	//$this->some_model->deletesomething( $this->get('id') );
        $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function users_get()
    {
        //$users = $this->some_model->getSomething( $this->get('limit') );
        $users = array(
			array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com'),
			array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com'),
			3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => array('hobbies' => array('fartings', 'bikes'))),
		);
        
        if($users)
        {
            $this->response($users, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'Couldn\'t find any users!'), 404);
        }
    }


	public function send_post()
	{
		var_dump($this->request->body);
	}


	public function send_put()
	{
		var_dump($this->put('foo'));
	}
}