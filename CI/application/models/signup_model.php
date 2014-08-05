<?php
class signup_model extends CI_Model{
  
  function __construct()
  {
  	parent::__construct();
  	$this->load->database();
  	$this->load->library(array('session','form_validation'));
    $this->form_validation->set_error_delimiters('','');
  }

  
  function info(& $message)
  {
     $status = $this->session->userdata('status');
     if (isset($status) && $status == "OK")
     {
       if ($this->form_validation->run('secondsignup') === FALSE)
       {
          $message['detail'] = form_error('gender');
          if (empty($message['detail'])) 
              { 
                $message['detail'] = form_error('occupation');
              }
          if (empty($message['detail'])) 
              { 
                $message['detail'] = form_error('bio');
              }
          return FALSE;
       }
       else
        {
             $uid = $this->session->userdata('uid');
             $data = array(
                            'gender' => $this->input->post('gender'),
                            'bio' => $this->input->post('bio'),
                            'occupation' => $this->input->post('occupation')
                           );
             $this->db->where('uid',$uid);
             if (!$this->db->update('user_profile',$data))
             {
               $message['detail'] = "update fails";
               return FALSE;
             }
             else
             {
               return TRUE;
             }
        }
     }
     else
     {  
        $message['detail'] = "Unlogin";
     	  return FALSE;
     }
  }

  function more(& $message)
  {
     $status = $this->session->userdata('status');
     if (isset($status) && $status == "OK")
     {
           $uid = $this->session->userdata('uid');
           $this->db->select('occupation');
           $query = $this->db->get_where('user_profile',array('uid' => $uid));
           $row = $query->row_array();
           $occupation = $row['occupation'];
           //is a student
           if ($occupation === 'S')
           {
             if ($this->form_validation->run('thirdsignup_college') === FALSE)
              {
                   $message['detail'] = form_error('city');
                   if (empty($message['detail'])) 
                   { 
                      $message['detail'] = form_error('college');
                   }
                   if (empty($message['detail'])) 
                   { 
                      $message['detail'] = form_error('major');
                   }
                   if (empty($message['detail'])) 
                   { 
                      $message['detail'] = form_error('year');
                   }
                   return FALSE;
              }
              else
              {
                  $city = $this->input->post('city');
                  $college = $this->input->post('college');
                  $major = $this->input->post('major');
                  $year = $this->input->post('year');
                  $query = $this->db->get_where('user_major',array('major' => $major));
                  $data = array(
                                 'city' => $city,
                                 'jobplace' => $college,
                                 'jobtime' => $year,
                               );
                  if ($query->num_rows() === 0) 
                  {
                     $tmp = array(
                                   'major' => $major
                                 );
                     if (!$this->db->insert('user_major',$tmp))
                        {
                          $message['detail'] = "insert major fails";
                          return FALSE;
                        }
                  }
       
                  $data['job'] = $major;
                  $this->db->where('uid',$uid);
                  if (!$this->db->update('user_profile',$data))
                  {
                    $message['detail'] = "update fails";
                    return FALSE; 
                  }
                  return TRUE; 
              }
           }
           //is a worker
           else
           { 
             if ($this->form_validation->run('thirdsignup_work') === FALSE)
             {
                $message['detail'] = form_error('city');
                if (empty($message['detail'])) 
                { 
                   $message['detail'] = form_error('company');
                }
                if (empty($message['detail'])) 
                { 
                   $message['detail'] = form_error('position');
                }
                return FALSE;
             }
             else
             {
                   $city = $this->input->post('city');
                   $company = $this->input->post('company');
                   $position = $this->input->post('position');
                   $query = $this->db->get_where('user_job',array('job' => $position));
                   $data = array(
                                  'city' => $city,
                                  'jobplace' => $company,
                                );
                   if ($query->num_rows() === 0) 
                   {
                      $tmp = array(
                                    'job' => $position
                                  );
                      if (!$this->db->insert('user_job',$tmp))
                         {
                           $message['detail'] = "insert job fails";
                           return FALSE;
                         }
                   }
        
                   $data['job'] = $position;
                   $this->db->where('uid',$uid);
                   if (!$this->db->update('user_profile',$data))
                   {
                     $message['detail'] = "update fails";
                     return FALSE; 
                   }
                   return TRUE; 
              }
           }
     }
     else
     {  
        $message['detail'] = "Unlogin";
        return FALSE;
     }
  }

};
?>  