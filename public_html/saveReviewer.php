<?php

$fullNmae = htmlspecialchars($_REQUEST['name']);
$phone = htmlspecialchars($_REQUEST['phone']);
$email = htmlspecialchars($_REQUEST['email']);
$address = htmlspecialchars($_REQUEST['address']);

include 'conn.php';

$sql = "insert into reviewer(name,phone,email,address) values('$fullNmae','$phone','$email','$address')";
$result = @mysql_query($sql);
if ($result) {
    echo json_encode(array(
        'id' => mysql_insert_id(),
        'name' => $fullNmae,
        'phone' => $phone,
        'email' => $email,
        'address' => $address
    ));
} else {
    echo json_encode(array('errorMsg' => 'Some errors occured.'));
}
?>