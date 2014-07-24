<?php

class Image extends CI_Controller{
   
   function __construct()
   {
       parent::__construct();
       $this->load->helper('url');
   }

   function index()
   {
      $config['image_library'] = 'gd2';
      $config['source_image'] = 'uploads/1.gif';
      $config['create_thumb'] = TRUE;
      $config['maintain_ratio'] = TRUE;
      $config['width'] = 75;
      $config['height'] = 50;

      $this->load->library('image_lib',$config);
      $this->image_lib->resize();
      $this->load->view('view_image');
   }

};
?>  