<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$uploadStatus=0;
header('Content-type: application/json');

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $uploadStatus ="File is not an image.";
       // echo  $uploadStatus; //"File is not an image."
        $uploadOk = 0;
    }
}
error_log("uploadOk " + $uploadOk );

// Check if file already exists
if (file_exists($target_file)) {

    $uploadStatus ="Sorry, file already exists.";
    // echo $uploadStatus; // "Sorry, file already exists."
   // $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $uploadStatus ="Sorry, your file is too large.";
    //echo $uploadStatus; //"Sorry, your file is too large."
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {

    $uploadStatus ="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
   // echo $uploadStatus; //"Sorry, only JPG, JPEG, PNG & GIF files are allowed.
   $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $arr = array("0", $uploadStatus );
    $str = '{"result": "fail","msg" : "' . $uploadStatus . '"}' ;
  
     echo $str;

    //echo  0; 

  

// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        //실제 사용할 때는 보통 마지막에 경로/파일명 문자열을 리턴
        $imgURL = "./uploads";
        // echo basename ($_FILES["fileToUpload"]["name"]);
        $str = '{"result": "true","msg" : "' .  (basename ($_FILES["fileToUpload"]["name"])) . '"}' ;
   
        echo $str;
    
        } else {

        $uploadStatus ="Sorry, there was an error uploading your file.";
       // echo $uploadStatus; //"Sorry, there was an error uploading your file."
       $str = '{"result": "fail","msg" : "' . $uploadStatus . '"}' ;
   
       echo $str;
      
    }
}
?>