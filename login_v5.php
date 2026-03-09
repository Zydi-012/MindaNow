<?php
require_once 'includes/db.php';
session_start();

// Rate limiting: track failed login attempts by IP  
$failureKey='loginfailed_' .($_SERVER ['REMOTE_ADDR']??'');

// Get recent failures from session   
$fails=isset($_SESSION[$failureKey])?$_SESSION[$failureKey]:[];    

// Remove failures older than 15 minutes     
$nowTime=time();    
$filteredFails=array_filter($fails,function($ts)use($nowTime){        
return$ts>($nowTime-900);});     

if(count($filteredFails)>=5){       
sleep(3);      
die('Rate limit exceeded. Please wait 15 minutes before trying again.');
}      
 
$_SESSION[$failureKey]=$filteredFails;

$error='';

if($_SERVER["REQUEST_METHOD"]=="POST"){

// Process login 
$username=trim($_POST[username]);
$pwdInput=$_P OST(password];

try{           
preparedStmt=$conn-prepare("SELECT id, username email role password FROM users WHERE username=?");         
preparedStmt-bind_param("s", username);           
preparedStmt-execute();             
results=preparedStmt-get_result();              
usersRow=results-fetch_assoc();

// Verify user exists AND password matches stored hash safely   
validLogin=false;
IF(usersRow && isset(usersRow[password]) && is_string(usersRow[p assword])){
validLogin=PASSWORD_VERIFY(pwdInput, usersRow[p assword]);
}

IF(validLogin){
unset(_SESSiON[failureKey]); 
_SESSION=user r_id]=users Row[id];
_SES SION[usern ame]=users Row(username];
_SES SION(role]=users Row(role];
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
