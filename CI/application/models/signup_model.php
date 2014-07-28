<?php
class signup_model extends CI_Model{
  
  function __construct()
  {
  	parent::__construct();
  	$this->load->database();
  	$this->load->library('session');
  }

  function secondsignup(& $message)
  {
     $status = $this->session->userdata('status');
     if (isset($status) && $status == "OK")
     {
       if ($this->form_validation->run('secondsignup') === FALSE)
       {
          $message['detail'] = "some messages are unavailable";
          return FALSE;
       }
       else
         {
          $uid = $this->session->userdata('uid');
          $data = array(
                         'gender' => $this->input->post('gender'),
                         'description' => $this->input->post('description'),
                         'job' => $this->input->post('job')
                        );
          $this->db->where('id',$uid);
          if (!$this->db->update('user_profile',$data))
          {
            $message['detail'] = "update fails";
            return FALSE;
          }
          else
          {
            $job = $this->input->post('job');
            // is a student
            if ($job == 0) 
            {
               if (!$this->get_school($message))
               {
                  $message['detail'] = "get school fails";
                  return FALSE;
               } 
            }
            //is a worker
            else
            {
               if (!$this->get->company($message))
               {
                  $message['detail'] = "get company fails";
                  return FALSE;
               }
            }
            return TRUE;
         }
        }
     }
     else
     {  
        $message['detail'] = "you didn't login";
     	  return FALSE;
     }
  }

  function thirdsignup(& $message)
  {
     $status = $this->session->userdata('status');
     if (isset($status) && $status == "OK")
     {
           $uid = $this->session->userdata('uid');
           $this->db->select('job');
           $query = $this->db->get_where('user_profile',array('uid' => $uid));
           $row = $query->row_array();
           $job = $row['job'];
           //is a student
           if ($job === '0')
           {
             if ($this->form_validation->run('thirdsignup_college') === FALSE)
              {
                   $message['detail'] = "some messages are unavailable";
                   return FALSE;
              }
              else
              {
                  $city = $this->input->post('city');
                  $school = $this->input->post('school');
                  $major = $this->input->post('major');
                  $year = $this->input->post('year');
                  $query = $this->db->get_where('user_major',array('major' => $major));
                  $data = array(
                                 'city' => $city,
                                 'jobplace' => $school,
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
       
                  $data['jobid'] = $major;
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
                $message['detail'] = "some messages are unavailable";
                return FALSE;
             }
             else
             {
                   $city = $this->input->post('city');
                   $company = $this->input->post('company');
                   $major = $this->input->post('major');
                   $query = $this->db->get_where('user_job',array('job' => $job));
                   $data = array(
                                  'city' => $city,
                                  'jobplace' => $company,
                                );
                   if ($query->num_rows() === 0) 
                   {
                      $tmp = array(
                                    'major' => $major
                                  );
                      if (!$this->db->insert('user_job',$tmp))
                         {
                           $message['detail'] = "insert job fails";
                           return FALSE;
                         }
                   }
        
                   $data['jobid'] = $major;
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
        $message['detail'] = "you didn't login";
        return FALSE;
     }
  }

  function get_school(& $message)
  {
     $this->db->where('city');
     $query = $this->db->get('city');
     if (!isset($query) || $query == FALSE) return FALSE;
     $result = $query->result_array();
     foreach ($result as $value)
     {
        $this->db->select('school');
        $query = $this->db->get_where('city',$value);
        if (!isset($query) || $query == FALSE) return FALSE;
        $message[$value] = $query->result_array();
     }     
     return TRUE;
  }

  function get_company(& $message)
  {
     $this->db->where('city');
     $query = $this->db->get('city');
     if (!isset($query) || $query == FALSE) return FALSE;
     $result = $query->result_array();
     foreach ($result as $value)
     {
        $this->db->select('company');
        $query = $this->db->get_where('city',$value);
        if (!isset($query) || $query == FALSE) return FALSE;
        $message[$value] = $query->result_array();
     } 
     return TRUE;
  }
};
?>  