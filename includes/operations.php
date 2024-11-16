<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// function connect()
// {
//     return mysqli_connect("localhost","root","","tasks");
// }
function connect()
{
    $host = "database-1.cfa0oouaaqg9.us-east-2.rds.amazonaws.com"; 
    $username = "admin"; 
    $password = "Meshari&0099"; 
    $database = "task_manager"; 

    $connection = mysqli_connect($host, $username, $password, $database);

    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $connection;
}
// function security($name) //handling and sanitizing form data
// {
//     $conn = connect();
//     $string = trim($_POST[$name]);

//     if ($name == 'email') {
//         $email = filter_var($string, FILTER_SANITIZE_EMAIL);
//         $string = filter_var($email, FILTER_VALIDATE_EMAIL);
//     }

//     $value = escape($string);

//     return mysqli_real_escape_string($conn, $value); //protects from sql injection
// }
function security($input) // handling and sanitizing form data
{
    $conn = connect();
    $string = trim($input); // Sanitizes the provided input directly

    // If the field is an email, sanitize and validate it
    if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
        $string = filter_var($string, FILTER_SANITIZE_EMAIL);
    }

    // Escape the string to prevent SQL injection
    $string = escape($string);
    return mysqli_real_escape_string($conn, $string);
}


function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8'); //protects from xss
}

function array_depth(array $array) {
    $max_depth = 1;

    foreach ($array as $value) {
        if (is_array($value)) {
            $depth = array_depth($value) + 1;

            if ($depth > $max_depth) {
                $max_depth = $depth;
            }
        }
    }

    return $max_depth;
}

function select_rows($sql)
{
    $conn = connect();
    $res = mysqli_query($conn, $sql);
    $result = array();
    while ($row = $res->fetch_assoc()) {
        $result[] = $row;
    }
    return $result;
}
function insert_delete_edit($sql)
{
    $conn = connect();
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo mysqli_error($conn);
    }
}
function delete($table, $id)
{
    $conn = connect();
    $sql = "delete from `$table` where id = '$id'";
    if (insert_delete_edit($sql)) {
        return true;
    } else {
        return false;
    }
}
function build_sql_insert($table, $elements)
{
    $sql = "insert into `$table` ( ";
    $i = sizeof($elements);
    $j = 0;
    foreach ($elements as $key => $value) {
        $j++;
        if ($i != $j) {
            $sql .= "`$key`" . ",";
        } else {
            $sql .=  "`$key`";
        }
    }
    $j = 0;
    $sql .= ") values (";
    foreach ($elements as $value) {
        $j++;
        if ($i != $j) {
            $sql .= "'$value'" . ",";
        } else {
            $sql .= "'$value'";
        }
    }
    $sql .= ")";
    return insert_delete_edit($sql);
}
function build_sql_select($table, $col, $id)
{
    $conn = connect();
    $sql = "select * from `$table` where `$col` = '$id'";
    $res = mysqli_query($conn, $sql);
    $result = array();
    while ($row = $res->fetch_assoc()) {
        $result[] = $row;
    }
    return $result;
}
function build_sql_edit($table, $elements, $id, $col = "id") {
    $sql = "
        UPDATE
            `$table`
        SET
    ";

    $i = sizeof($elements);
    $j = 0;

    foreach ($elements as $key => $value) {
        $j++;
        if ($i != $j) {
            $sql .= "`$key`" . " = " . "'$value',";
        } else {
            $sql .=  "`$key`" . " = " . "'$value'";
        }
    }

    $sql .= "
        WHERE
            `$col` = '$id'
    ";
    return insert_delete_edit($sql);
}
function input($label, $name, $type = "text", $required = false)
{
?>
<div class="form-group">
    <label><?php echo $label ?></label>
    <input type="<?php echo $type ?>" id = "<?= $name ?>"  class="form-control" <?php echo $required ? 'required' : '' ?>
        name="<?php echo $name ?>">
    <p class="text-red" style="display: none" id = "<?= $name ?>badge">
        <i class="fas fa-info-circle"></i>
        This needs to be filled</p>
    <p class="text-red" style="display: none" id = "<?= $name ?>error">
        <i class="fas fa-warning"></i>
        An error occurred</p>
</div>
<?php
}
function input_hybrid($label, $name, $row = array(), $required = true, $type = "text")
{
?>
<div class="form-group mb-2">
    <label><?php echo $label ?></label>
    <input type="<?php echo $type ?>" <?php echo $required ? 'required' : '' ?>
        value="<?php echo !empty($row) ? $row[$name] : '' ?>" id="<?php echo $name ?>" class="form-control" name="<?php echo $name ?>">
</div>
<?php
}
function input_array($label, $name, $type = "text")
{
?>
<div class="form-group">
    <label><?php echo $label ?></label>
    <input type="<?php echo $type ?>" class="form-control" id = "<?= $name ?>" name="<?php echo $name ?>[]">

</div>
<?php
}
function submit()
{
?>
<div class="card-footer text-right">
    <button class="btn btn-primary" id="submit">submit</button>
</div>
<?php
}
function mynext()
{
    ?>
    <div class="card-footer text-right">
        <button value="back" id="back" class="btn btn-dark" onclick = "myback()" type="button">Back</button>
        <button value="next" id = "next" class="btn btn-primary" onclick = "mynext()" type="button">next</button>
        <button id = "submit" class="btn btn-success"  type="submit">submit</button>
    </div>
    <?php
}
function upload($name2)
{
    if (isset($_FILES[$name2]["name"]) && $_FILES[$name2]["name"] != '') {

        $target_dir = "../uploads/";
        $rand = rand(1000, 9000);
        $name = basename($_FILES[$name2]["name"]);
        $tmpname = $_FILES[$name2]["tmp_name"];
        $extention = explode(".",$name);
        $extention = end($extention);
        $filename = date("Ymjhis") . $rand;
        $image_path = $target_dir . $filename . "." . $extention;
        if (check_ext($extention)) {
            move_uploaded_file($tmpname, $image_path);
            return $filename . "." . $extention;
        } else {
            return "";
        }
    } else {
        return "";
    }
}
function check_ext($ext)
{
    if ($ext == "png" || $ext == "jpg" || $ext == "jpeg" || $ext == "mp4" || $ext == "mkv") {
        return true;
    } else {
        return false;
    }
}
function insert_edit_form($table_name)
{
    if (isset($_POST)) {
        $arr = array();
        foreach ($_POST as $key => $value) {
            $arr[$key] = security($key);
        }
        if (isset($_SESSION['edit'])) {
            build_sql_edit($table_name, $arr, $_SESSION['edit']);
            $id = $_SESSION['edit'];

            return true;
        } else {
            build_sql_insert($table_name, $arr);
            return true;
        }
    }
    return false;
}
// function check_email_exists($table, $email) {
//     $conn = connect();
//     $sql = "SELECT COUNT(*) as count FROM add_enumerators WHERE email = '$email'";
//     // $sql = "SELECT COUNT(*) as count FROM agency WHERE email = '$email'";

//     $result = mysqli_query($conn, $sql);
//     $row = mysqli_fetch_assoc($result);
//     if ($row['count'] > 0) {
//         return true;
//     } else {
//         return false;
//     }
// }
// function trace_id($table, $trace_id){
//     $conn = connect();
//     $sql = "SELECT trace_id FROM $table WHERE id=1";
//     $result = mysqli_query($conn, $sql);
//     $row = mysqli_fetch_assoc($result);
//     if ($row['count'] > 0) {
//         return true;
//     } else {
//         return false;
//     }
// }
// if (!empty($_POST["email"])) {
//     echo user_available('email', 'Email');
// }


// function user_available($attr, $text)
// {
//     $attribute_availability = get_user($_POST["email"]);

//     if (!empty($attribute_availability)) {
//         echo "<span style='color:red'> " . $text . " already exists .</span>";
//         echo "<script>$('#add').prop('disabled',true);</script>";
//     } else {
//         echo "<span style='color:green'> " . $text . " available for registration .</span>";
//         echo "<script>$('#add').prop('disabled',false);</script>";
//     }
// }
// function get_local_ipv4() {
//   $out = split(PHP_EOL,shell_exec("/sbin/ifconfig"));
//   $local_addrs = array();
//   $ifname = 'unknown';
//   foreach($out as $str) {
//     $matches = array();
//     if(preg_match('/^([a-z0-9]+)(:\d{1,2})?(\s)+Link/',$str,$matches)) {
//       $ifname = $matches[1];
//       if(strlen($matches[2])>0) {
//         $ifname .= $matches[2];
//       }
//     } elseif(preg_match('/inet addr:((?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3})\s/',$str,$matches)) {
//       $local_addrs[$ifname] = $matches[1];
//     }
//   }
//   return $local_addrs;
// }

// $addrs = get_local_ipv4();
// // var_export($addrs);
//   function getIPAddress() {
//     //whether ip is from the share internet
//      if(!emptyempty($_SERVER['HTTP_CLIENT_IP'])) {
//                 $ip = $_SERVER['HTTP_CLIENT_IP'];
//         }
//     //whether ip is from the proxy
//     elseif (!emptyempty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
//                 $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
//      }
// //whether ip is from the remote address
//     else{
//              $ip = $_SERVER['REMOTE_ADDR'];
//      }
//      return $ip;
// }

function save_log($data = [])
{
    $conn=connect();
    // Data array parameters
    // user_id = user unique id
    // action_made = action made by the user

    if (count($data) > 0) {
        extract($data);
        // Prepare the log entry for insertion
        $email= $conn->real_escape_string($email);
        $user_id = $conn->real_escape_string($user_id);
        $action_made = $conn->real_escape_string($action_made);
        $timestamp = date("Y-m-d H:i:s");

        // Insert the log entry into the database
        $sql = "INSERT INTO logs (user_id, email, action_made, timestamp) VALUES ('$user_id', '$email','$action_made', '$timestamp')";
        if ($conn->query($sql) === true) {
            // Log entry successfully saved
            // echo "Log entry saved successfully.";
        } else {
            // Error occurred while saving the log entry
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the database connection
        $conn->close();
    }

    return true;
}


// function encryptString($string, $action, $encryptedIP = '')
// {
//     global $flag;

//     $output = false;
//     $extraKey = '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';

//     $encrypt_method = "AES-256-CBC";
//     $secret_key = $flag['2nd-encrypt-key'] . $encryptedIP . '-' . $extraKey;
//     $secret_iv = $flag['2nd-encrypt-secret'] . $encryptedIP . '-' . $extraKey;

//     $key = hash('sha256', $secret_key);
//     $iv = substr(hash('sha256', $secret_iv), 0, 16);

//     $output;

//     if ($action == 'encrypt') {
//         $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
//         $output = base64_encode($output);
//         //replace equal signs with char that hopefully won't show up
//         $output = str_replace('=', '[equal]', $output);
//     } else if ($action == 'decrypt') {
//         //put back equal signs where your custom var is
//         $setString = str_replace('[equal]', '=', $string);
//         $output = openssl_decrypt(base64_decode($setString), $encrypt_method, $key, 0, $iv);
//     }

//     return $output;
// }

// function crypt_id($string, $get_ip = '', $action = 'encrypt')
// {
//     return encryptString($string, $action, $get_ip);
// }

// $get_ip = encryptString(get_ip(), 'encrypt');

// function encrypt($id)
// {
//     global $get_ip;
//     return crypt_id($id, $get_ip);
// }

// function decrypt($encrypt_id)
// {
//     global $get_ip;
//     return crypt_id($encrypt_id, $get_ip, 'decrypt');
// }


// function get_ip()
// {
//     // if (isset($_SERVER['HTTP_CLIENT_IP'])) {
//     //     return $_SERVER['HTTP_CLIENT_IP'];
//     // } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
//     //     return $_SERVER['HTTP_X_FORWARDED_FOR'];
//     // } else {
//     //     return $_SERVER['REMOTE_ADDR'];
//     // }
//     return 1;
// }


function cout($arr, $type = 'p'){
    echo '<pre>';
    $type == 'p' ? print_r($arr) : var_dump($arr);
    echo '</pre>';
}
function hasCircularReference($data) {
    $json = json_encode($data);
    return (json_last_error() == JSON_ERROR_RECURSION);
}

function utf8ize($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } elseif (is_string($mixed)) {
        return utf8_encode($mixed);
    }
    return $mixed;
}
function convertToNestedArray($strands) {
    $nestedArray = array();

    foreach ($strands as $strand) {
        $strandData = $strand;
        $substrands = $strandData["substrands"];
        $strandData["substrands"] = array_values($substrands);

        foreach ($strandData["substrands"] as &$substrand) {
            $learningOutcomes = $substrand["learning_outcomes"];
            $substrand["learning_outcomes"] = array_values($learningOutcomes);

            foreach ($substrand["learning_outcomes"] as &$learningOutcome) {
                $expectations = $learningOutcome["expectations"];
                $learningOutcome["expectations"] = array_values($expectations);
            }
        }

        $nestedArray[] = $strandData;
    }

    return $nestedArray;
}
function array_key_exists_r($needle, $haystack){
    $result = array_key_exists($needle, $haystack);

    if ($result && $haystack[$needle]){
        return $result;
    }

    foreach ($haystack as $v)
    {
        if (is_array($v) || is_object($v)){
            $result = array_key_exists_r($needle, $v);
            if ($result) {
                return $result;
            }
        }
    }

    return false;
}
