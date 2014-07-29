<?php

  class Personal_center_model extends CI_Model{
     
     function __construct()
     {
     	parent::__construct();
     	$this->load->library('upload');
     	$this->load->library('session');
        $this->load->model('public_model');
     }

     function profile(& $message)
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
        $this->load->library('upload',$config);
        
        if (!$this->upload->do_upload())
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
             $letter = $this->input->post('letter');
             $id1 = $this->session->userdata('uid');
             $id2 = $this->public_model->getid($receiver);
             if ($id1 > $id2)
             {
                $tmp = $id1;
                $id1 = $id2;
                $id2 = $tmp;
             }
             $data = array(
                             'uid_1' => $id1,
                             'uid_2' => $id2,
                             'date' => date('Y-m-d H:i:s',time())
                          );
             
             $query = $this->db->get_where('user_message_date',array('uid_1' => $id1,'uid_2' => $id2));
             if ($query->num_rows() > 0)
             {
                $this->db->where(array('uid_1' => $id1,'uid_2' => $id2));
                $this->db->update('user_message_date',$data);
             }
             else
             {
                if (!$this->db->insert('user_message_date',$data))
                {
                    $message['detail'] = "insert user_message_date fails";
                    return FALSE;
                }
             }

             $query = $this->db->get_where('user_message_date',array('uid_1' => $id1,'uid_2' => $id2));
             $row = $query->row_array();
             $letter_id = $row['id'];
             $data = array(
                            'letter_id' => $letter_id,
                            'sender' => $sender,
                            'receiver' => $receiver,
                            'message' => $letter,
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
         $email = $this->session->userdata('email');
         $id1 = $this->public_model->getid($email);         
         $this->db->where('uid_1',$id1);
         $this->db->or_where('uid_2',$id1);
         $this->db->order_by('date','desc');
         $query = $this->db->get('user_message_date');
         $message = $query->result_array();

         foreach ($message as $key => $index)
         {
            if ($index['uid_1'] === $id1) $index['uid'] = $index['uid_2'];
            else $index['uid'] = $index['uid_1'];
            $uid = $index['uid'];
            $this->db->select('realname');
            $query = $this->db->get_where('user_profile',array('id' => $uid));
            $row = $query->row_array();
            $index['realname'] = $row['realname'];
            unset($index['uid_1']);
            unset($index['uid_2']);
            $message[$key] = $index; 
         } 
     }

     function letter_talk(& $message)
     {
         $uid = $this->input->post('uid');
         $myuid = $this->session->userdata('uid');
         $uidemail = $this->public_model->getemail($uid);
         $myemail = $this->public_model->getemail($myuid);
         $where = "(sender = '$uidemail' AND receiver = '$myemail' ) OR (sender = '$myemail' AND receiver = '$uidemail')";
         $message['where'] = $where;
         $this->db->where($where);
         $this->db->order_by('date','desc');
         $query = $this->db->get('user_message');
         $message = $query -> result_array();
         $this->db->where('receiver',$uidemail);
         $this->db->where('sender',$myemail);
         $data = array(
                        'look' => '1'
                      );
         $this->db->update('user_message',$data);
     }

     function letter_set_look(& $message)
     {
        $uid = $this->session->userdata('uid');
        $uidemail = $this->public_model->getemail($uid);
        $this->db->where('receiver',$uidemail);
        $data = array(
                        'look' => '1'
                     );
        if (!$this->db->update('user_message',$data))
            {
                $message['detail'] = "update fails";
                return FALSE;
            };
        return TRUE;
     }
  };
?>