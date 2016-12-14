<!DOCTYPE HTML>  
<html>

<head>
   <meta charset="UTF-8">
   <title>Post Message</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

   <link rel="stylesheet"  href="">
</head>
<body> 
<div class="wrapper">

<form action="index.php" method="post" enctype="multipart/form-data" class='form-horizontal style-form'>
 <div class="row mt">
          		<div class="col-lg-10">
 <div class="form-panel">
                  	  <h4 class="mb"><i class="fa fa-angle-right"></i> Post a Message</h4>
                      
                       <div class="form-group">
                 <label class="col-sm-2 col-sm-2 control-label">Name</label>
                     <div class="col-sm-10">
                  <input type="text" class="form-control" id="title" name="title" required="required" value="<?php echo @$_POST['title'];?>" maxlength="255">
                                  <span class="help-block">Enter title of your post</span>
                              </div>
                          </div>
                          
                            <div class="form-group">
                 <label class="col-sm-2 col-sm-2 control-label">Message</label>
                     <div class="col-sm-10">
                  <textarea required="required" id="messagetext" name="messagetext" rows="7" cols="80" class="form-control" ><?php echo @$_POST['messagetext'];?></textarea>
                                  <span class="help-block">Enter content of your message</span>
                              </div>
                          </div>
                          
                           <div class="form-group">
                 <label class="col-sm-2 col-sm-2 control-label">Picture</label>
                     <div class="col-sm-10">
                  <input type="file" name="file" />
                                  <span class="help-block">Add Picture to your post (JPG or PNG only)</span>
                              </div>
                          </div>
                          
                             <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">&nbsp;</label>
                     <div class="col-sm-10">
                   <input type="submit" class="btn btn-primary btn-lg" value="Post Message" id="submit" name="submit"/>
                                 
                              </div>
                          </div>
                          
                          
                          
</div>
</div>
</div>



</form>
</div>
</body>
</html>
 
	<?php
	require_once('connection.php');

if(isset($_POST['submit']) && !empty($_FILES))
{    
//file specified.
$errmsg="";//assume we have no errors
$allowedMimeTypes=array('image/jpeg','image/png');
    $file = rand(1000,10000000)."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
	$file_size = $_FILES['file']['size'];
	$file_type = strtolower($_FILES['file']['type']);
	$title=mysqli_real_escape_string($connection,trim($_POST['title']));
    $msg=mysqli_real_escape_string($connection,trim($_POST['messagetext']));
	if(strlen($title)<5){
	$errmsg="Title must be five characters long<br/>";
	}
	if(strlen($msg)<15){
	$errmsg.="Message must be at least 15 characters long<br/>";
	}
//iss the file type allowed?
if(!in_array($file_type,$allowedMimeTypes)){
$errmsg.= "The image you entered is not JPG or PNG";
}

//do we have errors?
if($errmsg){
echo $errmsg;exit;
}

	$folder="uploads/";
	
	// new file size in KB
	$new_size = $file_size/1024;  
	// new file size in KB
	
	// make file name in lower case
	$new_file_name = strtolower($file);
	// make file name in lower case
	
	$final_file=str_replace(' ','-',$new_file_name);
	
	if(move_uploaded_file($file_loc,$folder.$final_file))
	{ 
				
	$sql="INSERT INTO post(title,message,file,type,size) VALUES('$title','$msg','$final_file','$file_type','$new_size')";
	       
		   if(mysqli_query($connection, $sql)){
		   //added ok. Get its id now
		   $postid=mysqli_insert_id($connection);

		   header('Location:post.php?do=detail&id='.$postid);exit;
		   }
		   else{
		   //File was uploaded but its information couldn'nt be saved so delete the file.
		   @unlink($folder.$final_file);
		   echo "There was an error posting your message. Please try again";
		   }
		
	}
	else
	{
		?>
		<script>
		alert('error while uploading file');
        window.location.href='index.php?fail';
        </script>
		<?php
	}
}

	?>


