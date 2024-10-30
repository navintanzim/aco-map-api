<?php

if(isset($_POST['sender'])){
	
    $file_name = $_POST['sender']."-".$_FILES['file']['name'];
    $uploads_dir = 'uploads/'.$file_name;
	move_uploaded_file($_FILES['file']['tmp_name'], $uploads_dir);
	
	echo "Successful Attempt! <br><br>File stored at: ".$uploads_dir;
	
}else{
	echo 'Unauthorized Access!';
}

 ?>