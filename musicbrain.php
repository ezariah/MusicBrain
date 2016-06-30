<?php
		require(APPPATH.'libraries/REST_Controller.php');
		
		class musicbrain extends REST_Controller {
                    
                //Genre Functions
		
				function genre_get($genre_id = null) {
				  {   // checking to see if the Genre resource exists...
				   $this->load->database();
				   $sql = 'SELECT COUNT(genre_id) AS records FROM Genre WHERE genre_id = "'.$genre_id.'";';
				   $query = $this->db->query($sql);
				   $data = $query->row();
				  }
				  {
				   if (!isset($genre_id)) {
				    $sql='SELECT * FROM Genre';
				    $this->load->database();
				    $query = $this->db->query($sql);
				    $data = $query->result();
				    $info->status = 'sucess';
				    $info->Genre = $data;
				    $this->response($info,200);
				   } elseif($data->records =="0") {
				    $info->status = 'failure';
				    $info->error->code = 33;
				    $info->erorr->text = 'Genre id is not valid';
				    $this->response($info,400);
				   }
				  }
				  {
				   $sql ='SELECT * FROM Genre WHERE genre_id = "'.$genre_id.'";';
				   $this->load->database();
				   $query = $this->db->query($sql);
				   $data = $query->row();
				   $info->status = 'success';
				   $info->Genre = $data;
				   $this->response($info, 200);
				  }
				 }
				 
				 
				 
				 
				function addgenre() { // adding genressssss
				$headers = apache_request_headers();
				$headers = base64_decode($headers['authorization']);
				$information = explode(':',$headers);
				$username = $information[0];
				$password = $information[1];
				$user_token = $information[2];
				$sql = 'SELECT COUNT(username) AS records FROM user WHERE username = "'.$username.'" AND user_token = "'.$user_token.'" AND password = "'.md5($password).'";';
				$query = $this->db->query($sql);
				$data = $query->row();
						if ($data->records == "0") {
								$info->status = 'failure';
								$info->error->code = 48;
								$info->error->text = 'Invalid credentials supplied';
								$this->response($info, 401);
						}
						
						//if no auth has been given
						if (empty($headers['authorization'])) {
								$info->status = 'failure';
								$info->error->code = 47;
								$info->error->text = 'No credentials supplied';
								$this->response($info, 401);	
						}
				                 $name = $_POST['name'];
						$description = $_POST['description'];
						//these fields above input in body
						$info = array('genre_id'=>null, 'name'=>$name, 'description'=>$description);
						$this->db->insert('genre',$info);
						$data->name = $name;
						$data->description = $description;
		
						$this->response($data,200);	
				}
		}
				// 
				//}
		// Artist Functions
		
				function artist_get($artist_id = null) {
				  {   // checking to see if the Artist resource exists...
				   $this->load->database();
				   $sql = 'SELECT COUNT(artist_id) AS records FROM Artsist WHERE artist_id = "'.$artist_id.'";';
				   $query = $this->db->query($sql);
				   $data = $query->row();
				  }
				  {
				   if (!isset($artist_id)) {
				    $sql='SELECT * FROM Artsit';
				    $this->load->database();
				    $query = $this->db->query($sql);
				    $data = $query->result();
				    $info->status = 'sucess';
				    $info->Genre = $data;
				    $this->response($info,200);
				   } elseif($data->records =="0") {
				    $info->status = 'failure';
				    $info->error->code = 33;
				    $info->erorr->text = 'Artist_id is not valid';
				    $this->response($info,400);
				   }
				  }
				  {
				   $sql ='SELECT * FROM Genre WHERE artist_id = "'.$artist_id.'";';
				   $this->load->database();
				   $query = $this->db->query($sql);
				   $data = $query->row();
				   $info->status = 'success';
				   $info->Genre = $data;
				   $this->response($info, 200);
				  }
				 }
				 
				 
				function addartist () {
						
					$headers = apache_request_headers();
				$headers = base64_decode($headers['authorization']);
				$information = explode(':',$headers);
				$username = $information[0];
				$password = $information[1];
				$user_token = $information[2];
				$sql = 'SELECT COUNT(username) AS records FROM user WHERE username = "'.$username.'" AND user_token = "'.$user_token.'" AND password = "'.md5($password).'";';
				$query = $this->db->query($sql);
				$data = $query->row();
						if ($data->records == "0") {
								$info->status = 'failure';
								$info->error->code = 48;
								$info->error->text = 'Invalid credentials supplied';
								$this->response($info, 401);
						}
						
						//if no auth has been given
						if (empty($headers['authorization'])) {
								$info->status = 'failure';
								$info->error->code = 47;
								$info->error->text = 'No credentials supplied';
								$this->response($info, 401);	
						}
				                 $name = $_POST['name'];
						$description = $_POST['description'];
						//these fields above input in body
						$info = array('artist_id'=>null, 'name'=>$name, 'description'=>$description);
						$this->db->insert('Artist',$info);
						$data->name = $name;
						$data->description = $description;
		
						$this->response($data,200);	
					
						
				}
				 
		// Album functions		 
				
				// function addalbum () {
				//}
				// 
				//
		// User Functions
				
				function users_get() {
						
				 $this->load->database();
				 $sql = 'SELECT * FROM Users;';
				 $query = $this->db->query($sql);
				 $data = $query->result();
				
				 $this->response($data, 200);
				}
				
					function createuser_post() {
						$this->load->database();//loads db
						$email = $_POST['email'];
						$username = $_POST['username'];
						$password = $_POST['password'];
						//above is in body, fields
						$password = md5($password);//encodes the password base 64
						$info = array('user_id'=>null, 'username'=>$username, 'password'=>$password, 'email'=>$email);
						$this->db->insert('Users', $info);//stores array in info into table user
						$data->email = $email;
						$data->username = $username;
						$data->password = $password;
						
						$this->response($data,200);
				}
				
				
				
				
				function usertoken_post() {
				{
				$this->load->database();
				$length = '' ;
				{
				$length = 10;

                                $master= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); // creates random token
				  
				$username = $_POST['username'];
				$password = $_POST['password'];
				  $this->load->database();
				  $sql= 'Update Users set user_token ="'.$master.'" where username ="'.$username.'";';
				  $query = $this->db->query($sql);
				  $info->status='success';
				  $info->user = $query;
				  $data->user_token = $master;
				  $this->response($data, 200);
				 }
				}	     
				}
				
				function login_post() {
						$this->load->database();
						//$username = $_POST['Username'];
						//$password = $_POST['Password'];
						$headers = apache_request_headers();
						$username = $headers['username'];
						$password = $headers[md5('password')];
						
						//$username = "";
						//$password = "";
				//		
				//		
						if(empty($username) && ($password)) {
								$info->status = 'failure';
								$info->error->code = 35;
								$info->error->text = 'username/password parameter missing in request body';
								$this->response($info, 400);
						}
						
				//		if(isset($username)){ //checks if surname is empty
				//	       $info->status = 'failure';
				//	       $info->error->code = 31;
				//	       $info->error->text = 'username empty';
				//	       $this->response($info, 400);
				//	       }
				// 
				//     if(isset($password)){ //checks if password is empty
				//	       $info->status = 'failure';
				//	       $info->error->code = 31;
				//	       $info->error->text = 'password empty';
				//	       $this->response($info, 400);
				//	       }
						
						if(isset($headers['username']) && ($headers['password'])) {
								$username = $headers['username'];
								$password = $headers['password'];
								
						} else {
							$info->status = 'failure';
							$info->error->code = 35;
							$info->error->text = 'missing parameter(s) in request body';
							$this->response($info,400);	
						}
						
						
						$sql = 'SELECT COUNT(username) AS records FROM Users WHERE username = "'.$username.'" AND password = "'.$password.'";';
						$query = $this->db->query($sql);
						$data = $query->row();
						if ($data->records == "0") {
								$info->status = 'failure';
								$info->error->code = 48;
								$info->error->text = 'Invalid credentials supplied';
								$this->response($info, 401);
						} else {
								$sql='SELECT username FROM Users WHERE username ="'.$username.'" AND password ="'.md5($password).'";';
								$query = $this->db->query($sql);
								$token= base64_encode($username.':'.$password);
								$info->status='success login ';
								echo "Login Sucessful: ";
								$this->response($token,'hrllo', 200);
						}
				
				
		
}}
?>		