<?php
require_once 'includes/db.php';
session_start();

// Rate limiting: track failed login attempts by IP  
$failureKey = 'loginfailed_' . ($_SERVER['REMOTE_ADDR'] ?? '');

// Get recent failures from session   
$fails = isset($_SESSION[$failureKey]) ? $_SESSION[$failureKey] : [];    

// Remove failures older than 15 minutes     
$nowTime = time();    
$filteredFails = array_filter($fails, function($ts) use ($nowTime) {        
    return $ts > ($nowTime - 900);
});     

if (count($filteredFails) >= 5) {       
    sleep(3);      
    die('Rate limit exceeded. Please wait 15 minutes before trying again.');
}      
 
$_SESSION[$failureKey] = $filteredFails;

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Process login 
$username = trim($_POST['username']);
$pwdInput = $_POST['password'];

try {           
$stmt = $conn->prepare("SELECT id, username, email, role, password FROM users WHERE username=?");         
$stmt->bind_param("s", $username);           
$stmt->execute();             
$resultSet = $stmt->get_result();              
$userRowData=$resultSet->fetch_assoc();

// Verify user exists AND password matches stored hash safely   
$bValidLogin=false;
if($userRowData && isset($userRowData['password']) && is_string($userRowData['password'])){
   $bValidLogin=password_verify($pwdInput,$userRowData['password']);
}

if($bValidLogin){
   unset($_SESSION[$failureKey]); 
   $_SESSION['user_id']=$userRowData ['id'];
   $_SESSION[ 'username' ]=$userR owDat a[ 'usern ame'];
   $_SESSIO N[role]=use rRo wDa ta [rol e];
header ("Location: admin/dashboard.PHP");               
exit();
} else {
// Record failed attempt                     

$tstampNow=time();
//Store timestamp in session                         
$aSessionInfo=isset( $_S ESSION[failureKe y])?$_ SESSION[failureKe y]: [];
$aSessionInfo[]=$tstampNow;
// Keep only last10 records maximum per IP                                      
while(count($$a SessionInfo)>10){array_shift(a SessionInfo);}
_Session(failureKe y)=currentSessionD ata;

// Add artificial delay proportional to number of prior fails   

sleep(min(count(_SessIon(failureK ey)),5));
error="Invalid credentials.";

}} catch(Exception e){
error ="System error occurred.";
}
}}
?>

<!DOCTYPE html>
<html>
<head>
 <title>Login - Mindanow</title>
 <meta name="viewport" content="width=device-width initial-scale=1">
 <link href=https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css rel-stylesheet">
</head>

<body class bg-light d-flex align-items-center style-height100vh;>

divclass container
 divclass row justify-content-center  
 divclass col-md-4

 divclass card border-0 shadow-sm   
 divclass card-body p-4

 h4 class mb-3 text-center Admin Login /h4


 <?php If(Isset(error)): ?>
divclass alert alert-danger small echohtmlspecialchars(error)?> /div
 <?phpendif; ?>


form method POST action=

 Security Token embedded here automatically php echo Security::csrfField()?

divclass mb-3 input type-text name username class-form-control placeholder Username required autocomplete username /div


divcl assmb3 inputtype-passwordname-password class-form-controlplaceholder-Passwordrequiredautocomplete-current-password/button typ e-submitbtn-dark w-100 Login/button/form
