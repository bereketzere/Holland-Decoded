 <?php 
require_once('connection.php');
$action=@strtolower($_GET['do']);
if($action=='addcomment'){
//add comment

$id=mysqli_real_escape_string($connection,$_POST['d']);
$comment=trim(mysqli_real_escape_string($connection,$_POST['c']));
if(strlen($comment)>5){
//add
 $sql="INSERT INTO comments (comment,postcode) VALUES ('$comment',$id)";
    if(mysqli_query($connection, $sql)){
	$postid=mysqli_insert_id($connection); 
	 echo $postid;exit;
	}
	else{
	echo -2;exit;
	}

}
else{
echo -1;exit;

}


}
?>
<!DOCTYPE HTML>  
<html>
<head>

   <meta charset="UTF-8">
   <title>Post Message</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
   <link rel="stylesheet"  href="blog.css">
</head>
<body> 
<div class="wrapper">
 <div class="row mt">
          		<div class="col-lg-10">
  <?php 

//what do we want to do?


if($action=='detail'){
/*//view detail of a single post
$id=mysqli_real_escape_string($connection,$_GET['id']);
  $query="select * from post WHERE id=$id order by created_at DESC LIMIT 1"; 
$result=mysqli_query($connection, $query) or die("failed query ");
//assume we didn't find the post
$title='Missing Post';
$foundPost=false;
$msg='The post you requested could not be found';
$img='';
if (mysqli_num_rows($result)>0){
//found.
$foundPost=true;
$postDetail=mysqli_fetch_array($result, MYSQLI_ASSOC);
$title= stripslashes($postDetail['title']);
           $msg=stripslashes($postDetail['message']);

            $img='uploads/'.$postDetail['file'];
}

?>
<h4><a href="post.php?do=detail&id=<?php echo $id;?>"><?php echo $title;?></a></h4>
            
          <img  src="<?php echo $img;?>" style="height: 200px; width: 200px;" />
<p><?php echo $msg;?></p>

<?php
   //if we have a post, then show the comment.
            if($foundPost){
			//we have a post: so show comments and comment form
			?>
			 <form action="#" method="post">
     <textarea required="required"  rows="4" cols="80" class="form-control c<?php echo $id;?>"  ></textarea>
                      
     <input type="button" value="Add Comment" class="addcomment" data-id="<?php echo $id;?>">
                  </form>
			
            <div class="comments<?php echo $id;?>">
            <?php
			$queryc="select * from comments WHERE postcode=$id order by reg_date DESC"; 
             $result2=mysqli_query($connection, $queryc) or die("failed query ");
			  //do we have comments?
			  if (mysqli_num_rows($result2)>0){
			  //show comments
			  while($commentDetail=mysqli_fetch_array($result2, MYSQLI_ASSOC))         
            {          
            $comment= stripslashes($commentDetail['comment']);
			$date= $commentDetail['reg_date'];
           ?>
           <div class="commentblock">
           <h4><?php echo $comment;?></h4>
           
           <?php echo $date;?>
           </div><br/>
           <?php
            
		   }//end while
			  
			  }//we have comments.
			
			echo '</div>';//id=comments
			}//if foundpost

}
else{*/
//view all posts
?>
<h4 class="mb"><i class="fa fa-angle-right"></i> Posts</h4>
<?php
$query="select * from post order by created_at DESC"; 
$result2=mysqli_query($connection, $query) or die("failed query ");
while($result=mysqli_fetch_array($result2, MYSQLI_ASSOC))         
     {          
            $title= stripslashes($result['title']);
            $msg= stripslashes($result['message']);
            $id= $result['id'];
            $img=$result['file'];
			
			?>
            <div class="col-lg-10">
            <h4><a href="post.php?do=detail&id=<?php echo $id;?>"><?php echo $title;?></a></h4>
            
          <img  src="uploads/<?php echo $img;?>" style="height: 450px; width: 700px;" />
            
           <p> <?php echo $msg;?></p>
           <div class="comments<?php echo $id;?>">
           <?php
		   //get comments for the post
			$queryc="select * from comments WHERE postcode=$id order by reg_date DESC LIMIT 5"; 
             $result3=mysqli_query($connection, $queryc) or die("failed query ");
			  //do we have comments?
			  if (mysqli_num_rows($result3)>0){
			  //show comments
			  while($commentDetail=mysqli_fetch_array($result3, MYSQLI_ASSOC))         
            {          
            $comment= stripslashes($commentDetail['comment']);
			$date= $commentDetail['reg_date'];
           ?>
           <div class="commentblock">
           <h4><?php echo $comment;?></h4>
           
           <?php echo $date;?>
           </div><br/>
           <?php
            
		   }//end while
			  
			  }//we have comments.
			  ?>

              </div>

     <form action="#" method="post">
     <textarea required="required"  rows="4" cols="80" class="form-control c<?php echo $id;?>" ></textarea>
                      
     <input type="button" value="Add Comment" class="addcomment" data-id="<?php echo $id;?>">
                  </form>
            
            <hr/>
            </div>
           
            


      </div>     
<?php
                 }

}

            ?>

</div></div></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
<script>
$(document).ready(function() {
						   

//-------------------------------------						   
$('.addcomment').click(function(){

var postid=$(this).attr('data-id');

 //send the requests now
 var comment=$('.c'+postid).val().trim();


 //
 if(comment==''){
alert("Insert comment please");
 return false;
 }

  
  var postForm = { //Fetch form data
            'c':comment,
			'd':postid
        };

       $.ajax({
                type: "POST",
                url: "post.php?do=addcomment",
                data: postForm,
                dataType : "text",
                cache: "false",
                success: function (result) {
				
					if(result==-1){
					alert('Add Comment please that is at least 5 characters left');
					}
					else if(result==-2){
					alert('Error adding the comment');
					}
					else if(parseInt(result)>0){
					//add form
					$('.c'+postid).val('');
					var dt=giveMeDateTime('-');
					$('.comments'+postid).prepend('<div class="commentblock"><h4>'+comment+'</h4>'+dt+'</div> </div><br/>');
					
					}
						else{
							alert('Error adding comment');
						}
					
					
                },
				fail: function (result){
				alert('Sorry, there was an error connecting to the server');
				}
				
				
            });
							  
 });
//------------------------------
  
//close doc ready
});
function giveMeDateTime(separator){
	

var now = new Date();
//var strDateTime = [[AddZero(now.getDate()), AddZero(now.getMonth() + 1), now.getFullYear()].join("/"), [AddZero(now.getHours()), AddZero(now.getMinutes())].join(":"), now.getHours() >= 12 ? "PM" : "AM"].join(" ");
//return strDateTime;

	return now.getFullYear()+separator+(now.getMonth()+1)+separator+now.getDate();

}

</script>
<a href="index.php">home</a>

 </body>
 </html>
