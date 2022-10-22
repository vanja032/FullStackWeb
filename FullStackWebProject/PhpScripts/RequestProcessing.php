<?php
require "Database_Info.php";
session_start();



if(isset($_POST["username"]) && isset($_POST["password"])){
    $username = validateInput($_POST["username"]);
    $password = validateInput($_POST["password"]);
    $conn = new mysqli($server_name, $server_username, $server_password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $username = strval(mysqli_real_escape_string($conn, $username));
    $password = strval(mysqli_real_escape_string($conn, $password));
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT {$user_first_name}, {$user_last_name}, {$user_email}, {$user_username}, {$user_password}, {$user_role} FROM {$users_table} 
    WHERE ({$user_username} = '{$username}' OR {$user_email} = '{$username}') AND {$user_password} = '{$password}';";
    $result = $conn->query($sql);
    $response = [];
    $data = [];
    if ($result->num_rows > 0) {
        if($row = $result->fetch_assoc()) {
            $data[$user_first_name] = $row[$user_first_name];
            $data[$user_last_name] = $row[$user_last_name];
            $response["type"] = "success";
            $_SESSION["first_name"] = $row[$user_first_name];
            $_SESSION["last_name"] = $row[$user_last_name];
            $_SESSION["username"] = $row[$user_username];
            $_SESSION["password"] = $row[$user_password];
            $_SESSION["role"] = $row[$user_role];
        }
        $response["data"] = $data;
    }
    else{
        $response["type"] = "errornotfound";
        unset($_SESSION["first_name"]);
        unset($_SESSION["last_name"]);
        unset($_SESSION["username"]);
        unset($_SESSION["password"]);
        unset($_SESSION["role"]);
        session_destroy();
    }
    $conn->close();
    
    echo json_encode($response, JSON_PRETTY_PRINT);
}


if(isset($_POST["picturecategory"]) && isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])){
    $value = validateInput($_POST["picturecategory"]);
    $conn = new mysqli($server_name, $server_username, $server_password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $value = strval(mysqli_real_escape_string($conn, $value));
    mysqli_set_charset($conn, "utf8");
    $sql = "INSERT INTO {$picture_types_table} ({$picture_type_name})
    VALUES ('{$value}');";

    $response = [];
    if ($conn->query($sql) === TRUE) {
        $response = array("type" => "success");
    } else {
        $response = array("type" => "error");
    }
    $conn->close();

    echo json_encode($response, JSON_PRETTY_PRINT);
}



if(isset($_POST["pictureTypeRequest"]) && strcmp($_POST["pictureTypeRequest"], "true") === 0 /*&& isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])*/){
    $conn = new mysqli($server_name, $server_username, $server_password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT {$picture_type_id}, {$picture_type_name} FROM {$picture_types_table};";
    $result = $conn->query($sql);
    $data = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    $conn->close();
    $response = [];
    $response['data'] = $data;
    echo json_encode($response, JSON_PRETTY_PRINT);
}


if(isset($_POST["readMessagesRequest"]) && strcmp($_POST["readMessagesRequest"], "true") === 0 && isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])){
    $conn = new mysqli($server_name, $server_username, $server_password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT {$message_id}, {$message_first_name}, {$message_last_name}, {$message_email}, {$message_text}, {$message_date} FROM {$messages_table};";
    $result = $conn->query($sql);
    $data = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    $conn->close();
    $response = [];
    $response['data'] = $data;
    echo json_encode($response, JSON_PRETTY_PRINT);
}



if(isset($_FILES["pictureFileValue"]) && isset($_POST["pictureTypeValue"]) && isset($_POST["pictureHeaderValue"]) && isset($_POST["pictureBodyValue"]) && isset($_POST["pictureDisplayValue"]) && isBool($_POST["pictureDisplayValue"]) && isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])){
    $response = "";
    $pictureFileValue = $_FILES["pictureFileValue"];
    $pictureTypeValue = validateInput($_POST["pictureTypeValue"]);
    $pictureHeaderValue = validateInput($_POST["pictureHeaderValue"]);
    $pictureBodyValue = validateInput($_POST["pictureBodyValue"]);
    $pictureDisplayValue = validateInput($_POST["pictureDisplayValue"]);
    $conn = new mysqli($server_name, $server_username, $server_password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $pictureTypeValue = strval(mysqli_real_escape_string($conn, $pictureTypeValue));
    $pictureHeaderValue = strval(mysqli_real_escape_string($conn, $pictureHeaderValue));
    $pictureBodyValue = strval(mysqli_real_escape_string($conn, $pictureBodyValue));
    $pictureDisplayValue = strval(mysqli_real_escape_string($conn, $pictureDisplayValue));
    $pictureFileInfo = @getimagesize($pictureFileValue["tmp_name"]);
    $allowed_image_extension = array("png", "gif", "pjp", "jpg", "jpg", "pjpeg", "jpeg", "jfif", "svgz", "svg", "bmp", "tif", "tiff");
    $file_extension = pathinfo($pictureFileValue["name"], PATHINFO_EXTENSION);
    if (!file_exists($pictureFileValue["tmp_name"])) {
        $response = array("type" => "error", "message" => "Selected image is not valid. Please select valid image and try again!");
    }
    else if (!in_array($file_extension, $allowed_image_extension)){
        $response = array("type" => "error", "message" => "Invalid image type. Please select valid image and try again!");
    }
    else if ($pictureFileValue["size"] > $byteSize){
        $response = array("type" => "error", "message" => "Picture file size must be up to 50MB. Resize or compress image and try again!");
    }
    else{
        $target = "../" . $gallery_image_file_location . basename($pictureFileValue["name"]);
        if(file_exists($target)){
            $response = array("type" => "error", "message" => "Selected image already exists in gallery. Choose another image name or apload another image and try again!");
        }
        else if (move_uploaded_file($pictureFileValue["tmp_name"], $target)) {
            mysqli_set_charset($conn, "utf8");
            $pictureUrl = $gallery_image_file_location . basename($pictureFileValue["name"]);
            $sql = "INSERT INTO {$pictures_table} ({$picture_url}, {$picture_header}, {$picture_body}, {$picture_display_body}, {$picture_type_category})
            VALUES ('{$pictureUrl}', '{$pictureHeaderValue}', '{$pictureBodyValue}', {$pictureDisplayValue}, {$pictureTypeValue});";

            if ($conn->query($sql) === TRUE) {
                $response = array("type" => "success", "message" => "Picture uploaded successfully, operation complete!");
            } else {
                $response = array("type" => "errorSQL", "message" => "Problem while uploading data. Check it and try again later!");
                unlink($target);
            }
        } else {
            $response = array("type" => "error", "message" => "Problem while uploading image. Select another image or try again later!");
        }
    }

    $conn->close();
    echo json_encode($response, JSON_PRETTY_PRINT);
}



if(isset($_POST["readPicturesRequest"]) && strcmp($_POST["readPicturesRequest"], "true") === 0){
    $conn = new mysqli($server_name, $server_username, $server_password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_set_charset($conn, "utf8");
    $sql = "SELECT {$picture_id}, {$picture_url}, {$picture_header}, {$picture_body}, {$picture_display_body}, {$picture_type_category}, {$picture_type_name} 
    FROM {$pictures_table} LEFT JOIN {$picture_types_table} 
    ON {$picture_type_category} = {$picture_type_id}
    ORDER BY {$picture_type_category}, {$picture_id};";
    $result = $conn->query($sql);
    $data = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    $conn->close();
    $response = [];
    $response['data'] = $data;
    echo json_encode($response, JSON_PRETTY_PRINT);
}



if(isset($_POST["removePicturesRequest"]) && isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])){
    $value = validateInput($_POST["removePicturesRequest"]);
    $conn = new mysqli($server_name, $server_username, $server_password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $value = strval(mysqli_real_escape_string($conn, $value));
    mysqli_set_charset($conn, "utf8");
    $sqlp = "SELECT {$picture_url} FROM {$pictures_table} WHERE {$picture_id} = {$value};";
    $result = $conn->query($sqlp);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            unlink("../" . $row[$picture_url]);
        }
    }

    $sql = "DELETE FROM {$pictures_table} 
    WHERE {$picture_id} = {$value}";

    $response = "";
    if ($conn->query($sql) === TRUE) {
        $response = array("type" => "success", "message" => "Picture removed successfully, operation complete!");
    } else {
        $response = array("type" => "error", "message" => "Problem while removing picture. Check it and try again!");
    }
    $conn->close();

    echo json_encode($response, JSON_PRETTY_PRINT);
}




if((isset($_FILES["imageFileValue"]) || isset($_POST["imageFileValue"])) && isset($_POST["imageFileEdited"]) && isBool($_POST["imageFileEdited"]) && isset($_POST["imageID"]) && isset($_POST["imageTypeValue"]) && isset($_POST["imageHeaderValue"]) && isset($_POST["imageBodyValue"]) && isset($_POST["imageDisplayValue"]) && isBool($_POST["imageDisplayValue"]) && isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])){
    $response = "";
    $pictureFileValue = "";
    $pictureEdited = validateInput($_POST["imageFileEdited"]);
    if(isset($_FILES["imageFileValue"])){
        $pictureFileValue = $_FILES["imageFileValue"];
    }
    else{
        $pictureEdited = false;
    }
    $pictureID = validateInput($_POST["imageID"]);
    $pictureTypeValue = validateInput($_POST["imageTypeValue"]);
    $pictureHeaderValue = validateInput($_POST["imageHeaderValue"]);
    $pictureBodyValue = validateInput($_POST["imageBodyValue"]);
    $pictureDisplayValue = validateInput($_POST["imageDisplayValue"]);
    $conn = new mysqli($server_name, $server_username, $server_password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_set_charset($conn, "utf8");
    $pictureEdited = strval($pictureEdited);
    $pictureID = strval(mysqli_real_escape_string($conn, $pictureID));
    $pictureTypeValue = strval(mysqli_real_escape_string($conn, $pictureTypeValue));
    $pictureHeaderValue = strval(mysqli_real_escape_string($conn, $pictureHeaderValue));
    $pictureBodyValue = strval(mysqli_real_escape_string($conn, $pictureBodyValue));
    $pictureDisplayValue = strval(mysqli_real_escape_string($conn, $pictureDisplayValue));
    $displayValue = getBool($pictureDisplayValue);
    if(getBool($pictureEdited)){
        $pictureFileInfo = @getimagesize($pictureFileValue["tmp_name"]);
        $allowed_image_extension = array("png", "gif", "pjp", "jpg", "jpg", "pjpeg", "jpeg", "jfif", "svgz", "svg", "bmp", "tif", "tiff");
        $file_extension = pathinfo($pictureFileValue["name"], PATHINFO_EXTENSION);
        if (!file_exists($pictureFileValue["tmp_name"])) {
            $response = array("type" => "error", "message" => "Selected image is not valid. Please select valid image and try again!");
        }
        else if (!in_array($file_extension, $allowed_image_extension)){
            $response = array("type" => "error", "message" => "Invalid image type. Please select valid image and try again!");
        }
        else if ($pictureFileValue["size"] > $byteSize){
            $response = array("type" => "error", "message" => "Picture file size must be up to 50MB. Resize or compress image and try again!");
        }
        else{
            $target = "../" . $gallery_image_file_location . basename($pictureFileValue["name"]);
            $sqlp = "SELECT {$picture_url} FROM {$pictures_table} WHERE {$picture_id} = {$pictureID};";
            $result = $conn->query($sqlp);
            $unlinkUrl = "";
            $unlinkCheck = false;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $unlinkUrl = "../" . $row[$picture_url];
                }
            }
            if($unlinkUrl != ""){
                if(file_exists($unlinkUrl)){
                    $unlinkCheck = true;
                }
            }
            if(file_exists($target)){
                $response = array("type" => "error", "message" => "Selected image already exists in gallery. Choose another image name or apload another image and try again!");
            }
            else if (move_uploaded_file($pictureFileValue["tmp_name"], $target)) {
                $pictureUrl = $gallery_image_file_location . basename($pictureFileValue["name"]);
                $sql = "UPDATE {$pictures_table}
                SET {$picture_url} = '{$pictureUrl}', {$picture_header} = '{$pictureHeaderValue}', {$picture_body} = '{$pictureBodyValue}', {$picture_display_body} = {$displayValue}, {$picture_type_category} = {$pictureTypeValue}
                WHERE {$picture_id} = {$pictureID};";

                if ($conn->query($sql) === TRUE) {
                    $response = array("type" => "success", "message" => "Picture uploaded successfully, operation complete!");
                    if($unlinkUrl != "" && $unlinkCheck) unlink($unlinkUrl);
                } else {
                    $response = array("type" => "errorSQL", "message" => "Problem while uploading data. Check it and try again later!" . $conn -> error);
                    unlink($target);
                }
            } else {
                $response = array("type" => "error", "message" => "Problem while uploading image. Select another image or try again later!");
            }
        }
    }
    else{
        $sql = "UPDATE {$pictures_table}
        SET {$picture_header} = '{$pictureHeaderValue}', {$picture_body} = '{$pictureBodyValue}', {$picture_display_body} = {$displayValue}, {$picture_type_category} = {$pictureTypeValue}
        WHERE {$picture_id} = {$pictureID};";

        if ($conn->query($sql) === TRUE) {
            $response = array("type" => "success", "message" => "Picture uploaded successfully, operation complete!");
        } else {
            $response = array("type" => "errorSQL", "message" => "Problem while uploading data. Check it and try again later!");
        }
    }
    
    $conn->close();
    echo json_encode($response, JSON_PRETTY_PRINT);
}




if(isset($_POST["typeforremove"]) && isset($_POST["typeremoveall"]) && isBool($_POST["typeremoveall"]) && isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])){
    $value = validateInput($_POST["typeforremove"]);
    $removeall = validateInput($_POST["typeremoveall"]);
    $conn = new mysqli($server_name, $server_username, $server_password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $value = strval(mysqli_real_escape_string($conn, $value));
    $removeall = strval(mysqli_real_escape_string($conn, $removeall));
    $response = "";
    mysqli_set_charset($conn, "utf8");
    if(getBool($removeall)){
        $sqlp = "DELETE FROM {$pictures_table} 
        WHERE {$picture_type_category} = {$value}";
    
        if ($conn->query($sqlp) !== TRUE) {
            $response = array("type" => "errorSQL", "message" => "Problem while removing pictures. Check it and try again!");
            echo json_encode($response, JSON_PRETTY_PRINT);
            return;
        }
    }
    $sql = "DELETE FROM {$picture_types_table} 
    WHERE {$picture_type_id} = {$value}";

    if ($conn->query($sql) === TRUE) {
        $response = array("type" => "success", "message" => "Picture removed successfully, operation complete!");
    } else {
        $response = array("type" => "errorSQL", "message" => "Problem while removing picture. If pictures with this category exist, you have to remove them first and try again!");
    }
    $conn->close();

    echo json_encode($response, JSON_PRETTY_PRINT);
}




if(isset($_POST["removeMessagesRequest"]) && isset($_SESSION["first_name"]) && isset($_SESSION["last_name"]) && isset($_SESSION["username"]) && isset($_SESSION["password"])){
    $value = validateInput($_POST["removeMessagesRequest"]);
    $conn = new mysqli($server_name, $server_username, $server_password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $value = strval(mysqli_real_escape_string($conn, $value));
    $response = "";
    mysqli_set_charset($conn, "utf8");
    $sql = "DELETE FROM {$messages_table} 
    WHERE {$message_id} = {$value}";

    if ($conn->query($sql) === TRUE) {
        $response = array("type" => "success", "message" => "Message removed successfully, operation complete!");
    } else {
        $response = array("type" => "errorSQL", "message" => "Problem while removing message. Check it and try again later!");
    }
    $conn->close();

    echo json_encode($response, JSON_PRETTY_PRINT);
}



if(isset($_POST["contactfirstname"]) && isset($_POST["contactlastname"]) && isset($_POST["contactemail"]) && isset($_POST["contactmessage"])){
    $firstname = validateInput($_POST["contactfirstname"]);
    $lastname = validateInput($_POST["contactlastname"]);
    $email = validateInput($_POST["contactemail"]);
    $message = validateInput($_POST["contactmessage"]);
    $conn = new mysqli($server_name, $server_username, $server_password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $firstname = strval(mysqli_real_escape_string($conn, $firstname));
    $lastname = strval(mysqli_real_escape_string($conn, $lastname));
    $email = strval(mysqli_real_escape_string($conn, $email));
    $message = strval(mysqli_real_escape_string($conn, $message));
    mysqli_set_charset($conn, "utf8");
    $sql = "INSERT INTO {$messages_table} ({$message_first_name}, {$message_last_name}, {$message_email}, {$message_text})
    VALUES ('{$firstname}', '{$lastname}', '{$email}', '{$message}');";

    $response = "";
    if ($conn->query($sql) === TRUE) {
        $response = array("type" => "success", "message" => "Message submitted successfully.");
    } else {
        $response = array("type" => "errorSQL", "message" => "Problem while submitting message. Check it and try again later!");
    }
    $conn->close();

    echo json_encode($response, JSON_PRETTY_PRINT);
}


if(isset($_POST["logout"])){
    unset($_SESSION["first_name"]);
    unset($_SESSION["last_name"]);
    unset($_SESSION["username"]);
    unset($_SESSION["password"]);
    unset($_SESSION["role"]);
    session_destroy();
    echo "true";
}

?>