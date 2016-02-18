<?php

$title = htmlspecialchars($_REQUEST['title']);
$author = htmlspecialchars($_REQUEST['author']);
$category = htmlspecialchars($_REQUEST['category']);
$uploadedFile = $_FILES['uploadedFile'];
$receivedDate = htmlspecialchars($_REQUEST['receivedDate']);
$msText = htmlspecialchars($_REQUEST['msText']);

include 'conn.php';


//$target_dir = "uploads/";
//$target_file = $target_dir . basename($_FILES["uploadedFile"]["name"]);
//$uploadOk = 1;
//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image


header('Content-Type: text/plain; charset=utf-8');

try {

    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
//    if (
//        !isset($_FILES['uploadedFile']['error']) ||
//        is_array($_FILES['uploadedFile']['error'])
//    ) {
//        throw new RuntimeException('Invalid parameters.');
//    }

    // Check $_FILES['upfile']['error'] value.
//    switch ($_FILES['uploadedFile']['error']) {
//        case UPLOAD_ERR_OK:
//            break;
//        case UPLOAD_ERR_NO_FILE:
//            throw new RuntimeException('No file sent.');
//        case UPLOAD_ERR_INI_SIZE:
//        case UPLOAD_ERR_FORM_SIZE:
//            throw new RuntimeException('Exceeded filesize limit.');
//        default:
//            throw new RuntimeException('Unknown errors.');
//    }

    // You should also check filesize here.
//    if ($_FILES['uploadedFile']['size'] > 1000000) {
//        throw new RuntimeException('Exceeded filesize limit.');
//    }

    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
//    $finfo = new finfo(FILEINFO_MIME_TYPE);
//    if (false === $ext = array_search(
//            $finfo->file($_FILES['uploadedFile']['tmp_name']),
//            array(
//                'jpg' => 'image/jpeg',
//                'png' => 'image/png',
//                'gif' => 'image/gif',
//                'doc' => 'txt'
//            ),
//            true
//        )) {
//        throw new RuntimeException('Invalid file format.');
//    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
//    if (!move_uploaded_file(
//        $_FILES['uploadedFile']['tmp_name'],
//        sprintf('./uploads/%s.%s',
//            sha1_file($_FILES['upfile']['tmp_name']),
//            $ext
//        )
//    )) {
//        throw new RuntimeException('Failed to move uploaded file.');
//    }

//    echo 'File is uploaded successfully.';
//    $fp      = fopen($_FILES['uploadedFile']['tmp_name'], 'r');
//    $content = fread($fp, filesize($_FILES['uploadedFile']['tmp_name']));
//    $uploadedFile = addslashes($content);
//    fclose($fp);
//    $target_path = "./uploads/";
//
//    $target_path = $target_path . basename( $_FILES['uploadedFile']['name']);
//
//    if(move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $target_path)) {
//        echo "The file ".  basename( $_FILES['uploadedFile']['name']).
//            " has been uploaded";
//    } else{
//        echo "There was an error uploading the file, please try again!";
//        throw new RuntimeException('Failed to move uploaded file.');
//    }


    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["uploadedFile"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["uploadedFile"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["uploadedFile"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if($imageFileType != "pdf" && $imageFileType != "docx" && $imageFileType != "doc"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["uploadedFile"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $uploadedFile = file_get_contents($target_file);
    $uploadedFile= addslashes($uploadedFile);
    $sql = "insert into manuscript(title,author,category, uploadedFile, msText, receivedDate ) values('$title','$author','$category','$$uploadedFile', '$msText','$receivedDate')";
    $result = @mysql_query($sql);
    if ($result) {
        echo json_encode(array(
            'id' => mysql_insert_id(),
            'title' => $title,
            'author' => $author,
            'category' => $category,
            'content' => $content,
            'receivedDate' => $receivedDate
        ));
    } else {
        echo json_encode(array('errorMsg' => 'Some errors occured.'));
    }

} catch (RuntimeException $e) {

    echo $e->getMessage();

}






?>