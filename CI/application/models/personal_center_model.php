<?php

  class Personal_center_model extends CI_Model{
     
     function __construct()
     {
     	parent::__construct();
     	$this->load->library('upload');
     	$this->load->library('session');
     }

     function profile()
     {
     	$uid = $this->session->userdata('uid');
     	$username = $this->session->userdata('username');
     	$email = $this->input->post('email');
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
        $config['file_name'] = $username;
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
        return TRUE;
     }
  };
?>