<?php

  class Personal_center_model extends CI_Model{
     
     function __construct()
     {
     	parent::__construct();
     	$this->load->library('upload');
     	$this->load->library('session');
        $this->load->model('public_model');
     }
     
     function profile_get(& $message,$uid)
     {
        $this->db->where('uid',$uid);
        $query = $this->db->get_where('user_profile');
        if ($query->num_rows() > 0)
        {
            $message = $query->row_array();
            if ($uid == $this->session->userdata('uid'))
            {
                $message['myprofile'] = 1; 
            }
            else
            {
                $message['myprofile'] = 0;
            }
            $message['location'] = $this->public_model->large_photo_get($uid);
            return TRUE;
        }
        else
        {
            $message['detail'] = "no this man's profile";
            return FALSE;
        }
     }
     function modify_profile(& $message)
     {
     	$uid = $this->session->userdata('uid');
     	$email = $this->session->userdata('email');
        $query = $this->db->get_where('user_profile',array('uid' => $uid));
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
        // $message = $row;
        // return TRUE;
        $this->db->where('uid',$uid);
        if (!$this->db->update('user_profile',$row))
        {
            return FALSE;
        }
        $config['upload_path'] = 'uploads';
        $config['allowed_types'] = 'jpg|png';
        $config['file_name'] = "'$uid'.jpg";
        $config['overwrite'] = TRUE;
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        $supery = '';
        $userfile = 'userfile';
        if (!$this->upload->do_upload($userfile))
         {
         }
         else
         {
            $data = array(
                            'photo' => 1
                         );
            $this->db->where('uid',$uid);
            $this->db->update('user_profile',$data);
         	$data = $this->upload->data();
            $config = '';
         	$config['image_library'] = 'gd2';
         	$config['source_image'] = $data['full_path'];
            $config['new_image'] = $data['file_path'].$uid."_large".$data['file_ext'];
         	//$config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 100;
            $config['height'] = 100;
            $this->load->library('image_lib',$config);
            $this->image_lib->resize();
            
            // $message = $data;
            // return TRUE;
            $config['new_image'] = $data['file_path'].$uid."_middle".$data['file_ext'];
            $config['width'] = 38;
            $config['height'] = 38;
            // $message = $config;
            // return TRUE;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();

            $config['new_image'] = $data['file_path'].$uid."_small".$data['file_ext'];
            $config['width'] = 27;
            $config['height'] = 27;
            $this->load->library('image_lib',$config);
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
         }
        // $query = $this->db->get_where('user_profile',array('uid' => $uid));
        // $message = $query->row_array();
        return TRUE;
     }
    
    
     /*我的提问*/
     function my_question(& $message,$limit = 10,$offset = 0)
     {
        $uid = $this->session->userdata('uid');
        $this->db->order_by('date','desc');
        $this->db->limit($limit,$offset);
        $query = $this->db->get_where('q2a_question',array('uid'=>$uid));
        $message = $query->result_array();
        return TRUE;
     }
     
     /*我的回答*/
     function my_answer(& $message,$limit = 10,$offset = 0)
     {
        $uid = $this->session->userdata('uid');
        $this->db->order_by('date','desc');
        $this->db->where('uid',$uid);
        $this->db->limit($limit,$offset);
        $query = $this->db->get('q2a_answer');
        $result = $query->result_array();
        foreach ($result as $key => $value)
        {
            $qid = $value['qid'];
            $this->db->where('id',$qid);
            $query = $this->db->get('q2a_question');
            $row = $query->row_array();
            $value['title'] = $row['title'];
            $value['description'] = $row['content'];
            $message[$key] = $value;
        }
        return TRUE;
     }
    /*我关注的问题*/

    function my_attention(& $message,$limit = 10,$offset = 0)
    {
        $uid = $this->session->userdata('uid');
        $this->db->order_by('date','desc');
        $this->db->select('qid');
        $this->db->where('uid',$uid);
        $this->db->limit($limit,$offset);
        $query = $this->db->get('user_question');
        $result = $query->result_array();
        foreach ($result as $key => $value)
         {
            $qid = $value['qid'];
            $query = $this->db->get_where('q2a_question',array('id' => $qid));
            $message[$key] = $query->row_array();
         }
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
             $send_id = $this->session->userdata('uid');
             $rece_id = $this->input->post('uid');
             $letter = $this->input->post('letter');
             
             if ($send_id > $rece_id)
             {
                $tmp = $send_id;
                $send_id = $rece_id;
                $rece_id = $tmp;
             }
             $data = array(
                             'uid_1' => $send_id,
                             'uid_2' => $rece_id,
                             'date' => date('Y-m-d H:i:s',time())
                          );
             
             $query = $this->db->get_where('user_message_date',array('uid_1' => $send_id,'uid_2' => $rece_id));
             if ($query->num_rows() > 0)
             {
                $this->db->where(array('uid_1' => $send_id,'uid_2' => $rece_id));
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

             $query = $this->db->get_where('user_message_date',array('uid_1' => $send_id,'uid_2' => $rece_id));
             $row = $query->row_array();
             $letter_id = $row['id'];
             $send_id = $this->session->userdata('uid');
             $rece_id = $this->input->post('uid');
             $data = array(
                            'letter_id' => $letter_id,
                            'send_id' => $send_id,
                            'rece_id' => $rece_id,
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
        $myuid = $this->session->userdata('uid');
        $this->db->where('rece_id',$myuid);
        $this->db->where('look','0');
        $message['sum'] = $this->db->count_all_results('user_message');
        return TRUE; 
     }

     function letter_friend(& $message)
     {
         $myuid = $this->session->userdata('uid');        
         $this->db->where('uid_1',$myuid);
         $this->db->or_where('uid_2',$myuid);
         $this->db->order_by('date','desc');
         $query = $this->db->get('user_message_date');
         $message = $query->result_array();

         foreach ($message as $key => $index)
         {
            if ($index['uid_1'] == $myuid) $index['uid'] = $index['uid_2'];
            else $index['uid'] = $index['uid_1'];
            $uid = $index['uid'];
            $this->db->select('realname');
            $query = $this->db->get_where('user_profile',array('id' => $uid));
            $row = $query->row_array();
            $index['realname'] = $row['realname'];
            unset($index['uid_1']);
            unset($index['uid_2']);
            $index['location'] = $this->public_model->middle_photo_get($uid);
            $where = "(rece_id ='$myuid' AND send_id = '$uid') OR (rece_id = '$uid' AND send_id = '$myuid')";
            $this->db->where($where);
            $this->db->from('user_message');
            $index['msg_total'] = $this->db->count_all_results();
            $this->db->where('rece_id',$myuid);
            $this->db->where('send_id',$uid);
            $this->db->where('look','0');
            $this->db->from('user_message');
            $index['msg_unread'] = $this->db->count_all_results();
            $message[$key] = $index; 
         } 
         return TRUE;
     }

     function letter_talk(& $message,$uid)
     {
         $myuid = $this->session->userdata('uid');
         // $where = "(sender = '$uidemail' AND receiver = '$myemail' ) OR (sender = '$myemail' AND receiver = '$uidemail')";
         // $message['where'] = $where;
         $where = "(rece_id ='$myuid' AND send_id = '$uid') OR (rece_id = '$uid' AND send_id = '$myuid')";
         $this->db->where($where);
         $this->db->order_by('date','desc');
         $query = $this->db->get('user_message');
         $result = $query -> result_array();
         foreach ($result as $key => $value)
         {
            if ($value['rece_id'] == $myuid) 
            {
                $value['dir'] = TRUE;
            }
            else
            {
                $value['dir'] = FALSE;
            }
            unset($value['rece_id']);
            unset($value['send_id']);
            $message[$key] = $value;
         }
         $this->db->where('rece_id',$myuid);
         $this->db->where('send_id',$uid);
         $data = array(
                        'look' => '1'
                      );
         return $this->db->update('user_message',$data);
     }

     function letter_set_look(& $message)
     {
        $myuid = $this->session->userdata('uid');
        $this->db->where('rece_id',$myuid);
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

     function attention_new_answer(& $message,& $num_1 = 0)
     {
          $uid = $this->session->userdata('uid');
    
          $this->db->select('qid,flushtime_of_new_answer');
          $this->db->where('uid',$uid);
          $query = $this->db->get('user_question');
          $result = $query->result_array();

          foreach ($result as $key => $value)
          {
             $qid = $value['qid'];
             $timepoint = $value['flushtime_of_new_answer'];
             //$message['timepoint'] = $timepoint;
             $this->db->select('uid');
             $this->db->where('qid',$qid);
             $this->db->where('date >=',$timepoint);
             //$this->db->where('uid !=',$uid);
             $this->db->order_by('date','desc');
             $query = $this->db->get('q2a_answer');
             if ($query->num_rows() > 0)
             {
                $num_1 += $query->num_rows();
                $value= $query->result_array();
                $value['qid'] = $qid;
                unset($value['flushtime_of_new_answer']);
                $message[$key] = $value;
             }
          }
          return TRUE;
     }

     function answer_good(& $message, & $num_2 = 0)
     {
          $uid = $this->session->userdata('uid');
          
          $this->db->select('id,flushtime_of_answer_good');
          $this->db->where('uid',$uid);
          $query = $this->db->get('q2a_answer');
          $result = $query->result_array();

          foreach ($result as $key => $value)
          {
             $aid = $value['id'];
             $timepoint = $value['flushtime_of_answer_good'];
               
             $this->db->select('uid');
             $this->db->where('aid',$aid);
             $this->db->where('vote','1');
             $this->db->where('date >=',$timepoint);
            // $this->db->where('uid !=',$uid);
             $this->db->order_by('date','desc');
             $query = $this->db->get('answer_vote');
             if ($query->num_rows() > 0)
              {  
                 $num_2 += $query->num_rows();
                 $this->db->select('qid');
                 $this->db->where('id',$aid);
                 $tmp = $this->db->get_where('q2a_answer');
                 $row = $tmp->row_array();
                 $message[$key] = $query->result_array();
                 $message[$key]['qid'] = $row['qid'];
              }
              
          }       
          return TRUE;
     }


     function myquestion_new_answer(& $message, & $num_3 = 0)
     {
          $uid = $this->session->userdata('uid');
          
          $this->db->select('id,flushtime_of_myquestion_new_answer');
          $this->db->where('uid',$uid);
          $query = $this->db->get('q2a_question');
          $result = $query->result_array();

          foreach ($result as $key => $value)
          {
             $qid = $value['id'];
             $timepoint = $value['flushtime_of_myquestion_new_answer'];
             
             $this->db->select('uid');
             $this->db->where('date >=',$timepoint);
             $this->db->where('qid',$qid);
             $this->db->order_by('date','desc');
             $query = $this->db->get_where('q2a_answer');
             if ($query->num_rows() > 0)
              {
                 $num_3 += $query->num_rows();
                 $message[$key] = $query->result_array();
                 $message[$key]['qid'] = $qid;
              }
          }       
          return TRUE;
     }
};
?>