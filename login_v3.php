<?php
require_once 'includes/db.php';
require_once 'includes/csrf.php';

session_start();

// Generate CSRF token for this request  
Security::generateCSRFToken(); 

// Rate limiting: track failed login attempts by IP
$failureKey = 'loginfailed_' . ($_SERVER['REMOTE_ADDR'] ?? '');

// Get recent failures from session   
$fails = isset($_SESSION[$failureKey]) ? $_SESSION[$failureKey] : [];    

// Remove failures older than 15 minutes     
$nowTime=time();    
$filteredFails=array_filter($fails, function($ts) use ($nowTime) {        
    return $ts > ($nowTime-900);
});     

if (count($filteredFails) >= 5) {       
    sleep(3); // Slow down brute force attacks      
    die('Rate limit exceeded. Please wait 15 minutes before trying again.');
}      
 
$_SESSION[$failureKey]=$filteredFails;

$error='';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate CSRF token first 
    $token=$_POST['csrf_token']?? '';       
    if(!Security::validateCSRFToken($token)){
        die('Security validation failed. Please refresh and try again.');
    }

    // Process login after CSRF passes          
    $username=trim($_POST['username']);
$pwdInput=$_P OST(password];

try{           
stmt=$conn-prepare("SELECT id, username email role password FROM users WHERE username=?");         
stmt-bind_param("s", username);           
stmt-execute();             
result=stmt-get_result();              
userRow-result-fetch_assoc();

validLogin=false;
IF(userRow && isset(userRow[password]) && is_string(userRow[p assword])){
validLogin=PASSWORD_VERIFY(pwdInput userRow[p assword]);
}

IF(validLogin){
unset(_SESSiON[failureKey]); 
session_regenerate_id(true);
_SESSION=user r_id]=users Row[id];
_SES SION[usern ame]=users Row(username];
_SES SION(role]=users Row(role];
_SESSION(logged_in_at]=time();
header ("Location: admin/dashboard.PHP");               
exit();
} else {
// Record failed attempt                     

timestampNow-time();
//Store timestamp in session                         
currentSessionData=_SESSIOn(failureKe y)]?? [];
currentSessionData][]=timestampNow;
// Keep only last10 records maximum per IP                                      
while(c ount(currentSessionData)>10){array_shift(currentSessionData);}
_Session(failureKe y)=currentSessionData;

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
