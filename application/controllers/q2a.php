<meta content="text/html; charset=utf-8" http-equiv="Content-Type">	
<?php
class Q2a extends CI_Controller{
 function __construct()
 {
   parent::__construct(); 
   $this->load->helper(array('form','url'));
   $this->load->library('form_validation');
   $this->load->library('session');
   $this->load->model('Q2a_model');
   if (!$this->session->userdata('Username'))
    {
	   $this->load->view("unsignup");
	   return;
	}
 }
 
 function index()
 {
    
 }
 

 function home()
 {
    $this->load->library('pagination');
	$this->load->library('table');
	
	$config['base_url'] = 'http://localhost/index.php/q2a/home';
	$config['total_rows'] = $this->db->get('q2a_questions')->num_rows();
	$config['per_page'] = 10;
	$config['num_links'] = 20;
	
	$this->pagination->initialize($config);
	
	$this->db->select('realname,title,id');
	$data['records'] = $this->db->get('q2a_questions',$config['per_page'],$this->uri->segment(3))->result_array();
	
	$this->load->view('home',$data);
 }
 
 function ask_submit()
 {
    $Username = $this->session->userdata('Username');
	$Name = $this->session->userdata('Realname');
	if ($this->Q2a_model->ask())
	  {
		$this->load->view('ask_successful');
	  }
	else
      {
	     exit("你问问题太快啦~");
      }	  
 } 
function ask()
 {
     if (!$this->session->userdata('Username'))
	   {
	       $this->load->view('login');
	   }
	 else
       {
	       $this->load->view('ask');
       }	   
 }
 
 function answer_view($id)
 {
     if (!$this->session->userdata('Username'))
	 {
	     $this->load->view('login');
	 }
	 else
	 {  
	 	 $query = "update q2a_questions set view_num = view_num + 1 where id='$id'";
	     mysql_query($query);
	      
	     $query = $this->db->get_where('q2a_questions',array('id' => $id));
		 $data['question'] = $query->row_array();
		 $query = $this->db->get_where('q2a_answers',array('qid' => $id));
	     $data['answer'] = $query->result_array();
		 $this->load->view('answer',$data);
	 }
 }
 function answer($id)
 {
    if ($this->Q2a_model->answer($id))
	  {
	    $this->load->view('answer_successful');
	  }
	else
      {
	     $data['error'] = "回答失败";
		 $this->load->view('error_handle',$data);
      }	  
 }
 
 function good($id)
 {
    if ($this->Q2a_model->good($id))
	 {
	    if (!$this->session->userdata('Username'))
	    {
	     $this->index();
	    }
	    else
	    {  
	      $query = $this->db->get_where('q2a_questions',array('id' => $id));
		  $data['question'] = $query->row_array();
		  $query = $this->db->get_where('q2a_answers',array('qid' => $id));
	      $data['answer'] = $query->result_array();
		  $this->load->view('answer',$data);
	    }
	 }
	else
     {
	     $data['error'] = "评论失败";
		 $this->load->view('error_handle',$data);
     }	 
 }
 function bad($id)
 {
    if ($this->Q2a_model->bad($id))
	 {
	    if (!$this->session->userdata('Username'))
	    {
	     $this->index();
	    }
	    else
	    {  
	     $query = $this->db->get_where('q2a_questions',array('id' => $id));
		 $data['question'] = $query->row_array();
		 $query = $this->db->get_where('q2a_answers',array('qid' => $id));
	     $data['answer'] = $query->result_array();
		 $this->load->view('answer',$data);
	    }
	 }
	else
     {
	     $data['error'] = "评论失败";
		 $this->load->view('error_handle',$data);
     }	 
 } 
}
?>