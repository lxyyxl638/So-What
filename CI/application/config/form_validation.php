<?php $config = array(
         'signup'=>array(
		             array(
					        'field'=>'username',
							'label'=>'username',
							'rules'=>'required|min_length[6]|max_length[12]|is_unique[user.username]'
					      ),
				     array(
					        'field'=>'password',
							'label'=>'password',
							'rules'=>'required|min_length[6]|max_length[12]'
					      ),		  
				     array(
					        'field'=>'realname',
							'label'=>'realname',
							'rules'=>'required'
					      )
		              ),
		'next_signup'=>array
                      (
					     array(
					        'field'=>'realname',
							'label'=>'姓名',
							'rules'=>'required'
					      ),
                         array(
					         'field'=>'email',
							 'label'=>'Email',
							 'rules'=>'required|valid_email'
					       ) 						  
					  ),
        'change_password'=>array
                      (
					     array(
					        'field'=>'OldPassword',
							'label'=>'OldPassword',
							'rules'=>'required|min_length[6]|max_length[12]'
					       ),
                         array(
					         'field'=>'NewPassword',
							'label'=>'NewPassword',
							'rules'=>'required|min_length[6]|max_length[12]'
					        ),
                         array(
					         'field'=>'Passconf',
							'label'=>'Passconf',
							'rules'=>'required|matches[NewPassword]'
					       )						   
					  ),
		'sites' => array
		          (
		          	array(
		          		'field' => 'name',
		          		'label' => 'name',
		          		'rules' => 'required'
		          		) 
		          )			  						  
					  
               );			   
?>