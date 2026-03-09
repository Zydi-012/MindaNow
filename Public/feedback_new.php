<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate CSRF token
    $token = $_POST['csrf_token'] ?? '';
    if (!Security::validateCSRFToken($token)) {
        $error = "Security validation failed. Please refresh and try again.";
    } else {
        // Sanitize inputs
        $name = Security::sanitize($_POST['name'] ?? '', 100);
        $email = Security::sanitize($_POST['email'] ?? '', 100);
        $message = Security::sanitize($_POST['message'] ?? '', 2000);
        
        // Validate email format
        if (!empty($email) && !Security::validateEmail($email)) {
            $error = "Please enter a valid email address.";
        } elseif (empty($message)) {
            $error = "Message is required.";
} else {
// Insert into database using prepared statement  
$stmtInsert=$conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
            
// Handle null values properly - use empty string for name if not provided  
insertName=!empty(name)?$name:null;
insertEmail=!empty(email)?$email:null;
            
stmtInsert->bind_param("sss", insertName, insertEmail, message); 
            
if(stmtInsert->execute()){
                success="Thank you for your feedback! We'll get back to you soon.";
// Clear form data on success by redirecting to same page with GET
header("Location: feedback.php?success=1");
exit();
} else{
                error="Failed to submit feedback. Please try again later.";                
}
}
}
}

If(isset($_GET[ 'success']) && empty(error)){
   success="Thank you for your feedback! We'll get back to you soon.";}
?>

<!DOCTYPE html>
<html lang=en>
<head>
<meta charset=UTF-8 >
<meta name=viewport content="width=device-width initial-scale=1">
<Title>Feedback - Mindanow</Title> 
<link href=https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css rel-stylesheet >

<body class bg-light d-flex align-items-center min-vh-100 py4>

<div class container>

divclass row justify-content-center > 

divcol-md8 col-lg6>

divclass card border-0 shadow-sm >

divclass card-body p-4 >

<h2Class mb-4 text-center>Send Us Feedback</h2>

<?php If(!empty(success)): ?>
<divClass alert alert-success >
<?phpechohtmlspecialchars(success);?>
</div>
<?php endif; ?>


<?php If(!empty(error)): ?>
<divClass alert alert-danger >
 <?phpechohtmlspecialchars(error);?>
 </div> 
 <?phpendif; ?>


 <form method POST action=>


<!-- CSRF Token Field -->
 <?phpechoSecurity::csrfField();?> 


 <Div Class mb-3 >
 <label For=name Classform-label>Your Name (optional)</label >
inputType=text name=name id=name ClassFormControl value="<?phpechohtmlspecialchars(_POST[name]?? '');?
>" maxlength=100 placeholder JohnDoe />
 </Div>


 Div Class mb3 > 
 labelFor-emailClassform-label Email(optional)
 inputtype-email nam e=em ail id emai lclass-form-controlvalue="<?phpecho htmlspecial chars(_P OST[email]??'' );?
>"maxl ength10 0placeholder john@example.com /> /Div


 divCl assmb3 labelFor-messageCl assform-labelRequired Message * textareaNamemess ageid=m essagecl assf ormcontrol rows5 r equired placeholder Yourfeedbackhere...><?=ht mlspeci alchars(_PO ST[message]??'',ENT_QUOTES,'UTF-8');?></textarea></d iv>


 ButtontypeSubmit Cl assbtn btn-dark w-
100>S end Feedback /button
 
a href index.PHP classbtn btn-outline-secondary w-
100 mt2 BacktoHome/a


/form
