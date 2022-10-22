<?php
$server_name = "localhost";
$database_name = "arso_furniture_database";
$server_username = "root";
$server_password = "";

$picture_types_table = "picture_types_table";
$pictures_table = "pictures_table";
$users_table = "users_table";
$messages_table = "user_messages_table";

$picture_type_id = "Type_ID";
$picture_type_name = "Type_Name";

$picture_id = "Picture_ID";
$picture_url = "Picture_URL";
$picture_header = "Picture_Header";
$picture_body = "Picture_Body";
$picture_display_body = "Display_Body";
$picture_type_category = "Picture_Type_Category";

$user_id = "User_ID";
$user_username = "User_Username";
$user_password = "User_Password";
$user_email = "User_Email";
$user_first_name = "User_First_Name";
$user_last_name = "User_Last_Name";
$user_creation_date = "Creation_Date";
$user_role = "User_Role";

$message_id = "Message_ID";
$message_first_name = "User_First_Name";
$message_last_name = "User_Last_Name";
$message_email = "User_Email";
$message_text = "Message_Text";
$message_date = "Message_Sending_Date";


$gallery_image_file_location = "Media/Images/Cards Gallery/";
$byteSize = 52428800;


function validateInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function isBool($object){
    return $object === 'true' || $object === 'false';
}

function getBool($object){
    return (mb_strtolower($object) === 'true' || $object === true || $object === TRUE || $object === 1 || $object === '1') ? 1 : 0;
}
?>