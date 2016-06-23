<?php
require(APPPATH.'libraries/REST_Controller.php');

class Album extends REST_Controller
{
  function Album_get($album_id = null) {
  }
  function Album_post() {
   
  }
  function Album_delete() {
   
  }
  function Artist_get($artist_id = null) {
   {   // checking to see if the Genre resource exists...
    $this->load->database();
    $sql = 'SELECT COUNT(artist_id) AS records FROM Artist WHERE artist_id = "'.$artist_id.'";';
    $query = $this->db->query($sql);
    $data = $query->row();
   }
   {
    if (!isset($artist_id)) {
     $sql='SELECT * FROM Artist';
     $this->load->database();
     $query = $this->db->query($sql);
     $data = $query->result();
     $info->status = 'sucess';
     $info->Artist = $data;
     $this->response($info,200);
    } elseif($data->records =="0") {
     $info->status = 'failure';
     $info->error->code = 33;
     $info->erorr->text = 'Genre id is not valid';
     $this->response($info,400);
    }
   }
   {
    $sql .='SELECT * FROM Artist WHERE artist_id = "'.$artist_id.'";';
    $this->load->database();
    $query = $this->db->query($sql);
    $data = $query->row();
    $info->status = 'success';
    $info->Artist = $data;
    $this->response($info, 200);
   }
  }
  function Artist_post() {
   {   // unsupported method
    $info->status = 'failure';
    $info->error->code = 44;
    $info->error->text = 'The POST method is not supported by this resource';
    $this->response($info, 400);
   }
  }
  
  function Artist_put() {
  // unsupported method
   $info->status = 'failure';
   $info->error->code = 44;
   $info->error->text = 'The PUT method is not supported by this resource';
   $this->response($info, 400);
  }
  
  function Artist_delete() {
   {   // unsupported method
    $info->status = 'failure';
    $info->error->code = 44;
    $info->error->text = 'The DELETE method is not supported by this resource';
    $this->response($info, 400);
   }
  }
  
  function Users_put(){//login creator
   {
    $username = $this->put('username');
    $password = $this->put('password');
    $email = $this->put('email');
    $name = $this->put('name');
    
   }
   {//checks if a username is taken 
    $this->load->database();
    $sql= 'SELECT COUNT(user_id) AS records FROM User WHERE username= "'.$username.'";';
    $query = $this->db->query($sql);
    $data = $query->row();
    if($data->records !="0" ) {
     $info->status = 'Failure';
     $info->error->code = 32;
     $info->error->text = "username is already taken";
     $info->response($info, 400);
    }
    {// places the data into the specified tables
     $this->load->database();
     $sql= 'INSERT INTO User  VALUES (null,"'.$username.'","'.$email.'", MD5("'.$password.'"),"0","'.$name.'");';
     $query = $this->db->query($sql);
     $info->status='success';
     $info->user = $query;
     $this->response($info, 200);
    }
    {//directs the user request and makes
     $info->staus = 'success';
     $info->user = $data;
     $data = $query->row();
     $this->response($info,200);
    }
   }
  }
  function User_post() {
   {
   $this->load->database;
   $username = $_post['username'];
   $password = $_post['password'];
   }
  }
	function genre_get() { //all genres||do error handling||count no of records in specific genre
						$this->load->database();
						$sql = 'SELECT * FROM genre;';
						$query = $this->db->query($sql);
						$data = $query->result();
						
						
						$info->status = 'success';
						$info->selfLink = 'http://creative.coventry.ac.uk/~3688667/music/v1.1/index.php/musicrate/genres';
						$info->bytes = 0;
						$info->genres = $data;
						$json = json_encode($info);
						$info->bytes = strlen($json);
						
						$this->response($info, 200);
				}

}
?>