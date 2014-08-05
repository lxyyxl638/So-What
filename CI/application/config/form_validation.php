<?php $config = array(
         'signup'=>array(
		             array(
					        'field'=>'email',
							'label'=>'email',
							'rules'=>'required|valid_email|is_unique[user.email]'
					      ),
				     array(
					        'field'=>'password',
							'label'=>'password',
							'rules'=>'required|min_length[6]|max_length[12]'
					      ),		  
				     array(
					        'field'=>'firstname',
							'label'=>'firstname',
							'rules'=>'required'
					      ),
				     array( 
				     	    'field'=>'lastname',
				     	    'label'=>'lastname',
				     	    'rules'=>'required'
				     	  ),
		              ),
        'secondsignup'=>array
                      (
                      	 array(
                      	 	'field'=>'gender',
                      	 	'label'=>'gender',
                      	 	'rules'=>'required'
                      	 	),
                      	 array(
                      	 	'field'=>'occupation',
                      	 	'label'=>'occupation',
                      	 	'rules'=>'required',
                      	 	),
        	          ),
		'thirdsignup_college'=>array
                      (
					     array(
					        'field'=>'city',
							'label'=>'city',
							'rules'=>'required'
					      ),
                         array(
					         'field'=>'college',
							 'label'=>'college',
							 'rules'=>'required'
					       ),
					     array(
					     	  'field'=>'major',
					     	  'label'=>'major',
					     	  'rules'=>'required'
					     	), 					
					      array(
					      	   'field'=>'year',
					      	   'label'=>'year',
					      	   'rules'=>'required'
					      	)	  
					  ),
	    'thirdsignup_work' => array
	                  (
	                  	 array(
	                  	 	 'field'=>'city',
	                  	 	 'label'=>'city',
	                  	 	 'rules'=>'required'
	                  	 	),
	                  	 array(
	                  	 	  'field'=>'company',
	                  	 	  'label'=>'company',
	                  	 	  'rules'=>'required'
	                  	 	),
	                  	 array(
	                  	 	   'field'=>'position',
	                  	 	   'label'=>'position',
	                  	 	   'rules'=>'required'
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
		'letter_send' => array
		          (
		          	array(
		          		'field' => 'uid',
		          		'label' => 'uid',
		          		'rules' => 'required'
		          		),
		          	array(
		          		'field' => 'letter',
		          		'label' => 'letter',
		          		'rules' => 'required'
		          		),
		          )			  						  
					  
               );			   
?>