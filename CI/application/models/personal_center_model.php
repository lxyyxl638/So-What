<?php

  class Personal_center_model extends CI_Model{
     
     function __construct()
     {
     	parent::__construct();
     	$this->load->library('upload');
     	$this->load->library('session');
     }

     function profile(& $message);
     {
     	$uid = $this->session->userdata('uid');
     	$email = $this->session->userdata('email');
        $query = $this->db->get_where('uid',$uid);
        $row = $query->row_array();
        unset($row['id']);
        unset($row['uid']);
        unset($row['photo']);
        foreach ($row as $key => $value)
        {
        	if (!$this->input->post($key))
        	{
                $row[$key] = $value;
        	}
        	else
        	{
                $row[$key] = $this->input->post($key);
        	}
        }
        
        $this->db->where('uid',$uid);
        if (!$this->db->update('user_profile',$row))
        {
        	return FALSE;
        }
        $config['upload_path'] = 'uploads';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = $email;
        $config['overwrite'] = TRUE;
        $this->load->library('upload',$config)
        
        if (!$this->upload->do_upload()))
         {

         }
         else
         {
         	$data = $this->upload->data();
         	$config['image_library'] = 'gd2';
         	$config['source_image'] = $data['full_path'];
         	$config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 75;
            $config['height'] = 50;
            $this->load->library('image_lib',$config);
            $this->image_lib->resize();
         }

         $query = $this->db->get_where('uid',$uid);
         $message = $query->row_array();
        return TRUE;
     }

     function letter_send(& $message)
     {
         if ($this->form_validation->run('letter_send') === FALSE)
         {
             $message['detail'] = "some inputs are unavailable";
             return FALSE;
         }
         else
         {
             $sender = $this->session->userdata('email');
             $receiver = $this->input->post('receiver');
             $message = $this->input->post('message');
             $data = array(
                            'sender' => $sender,
                            'receiver' => $receiver,
                            'message' => $message,
                            'look' => 0,
                            'date' => date('Y-m-d H:i:s',time())
                          );
             if (!$this->db->insert('user_message',$data))
             {
                $message['detail'] = "insert wrong";
                return FALSE;
             }
             else
             {
                return TRUE;
             }
         }
     }

     function letter_notify(& $message)
     {
        $receiver = $this->session->userdata('email');
        $query = $this->db->get_where('user_message',array('receiver' => $receiver,'look' => '0'));
        $message['sum'] = $query->num_rows();
        return TRUE; 
     }

     function letter_friend(& $message)
     {
         $
     }
  };
?>