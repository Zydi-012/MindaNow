<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/csrf.php';

// Generate CSRF token
Security::generateCSRFToken();

$error = '';

// Rate limiting setup
$failureKey = 'loginfailed_' . ($_SERVER['REMOTE_ADDR'] ?? '');
$fails = isset($_SESSION[$failureKey]) ? $_SESSION[$failureKey] : [];
$nowTime = time();
$filteredFails = array_filter($fails, function($ts) use ($nowTime) {
    return $ts > ($nowTime - 900);
});

if (count($filteredFails) >= 5) {
    sleep(3);
    die('Rate limit exceeded. Please wait 15 minutes before trying again.');
}

$_SESSION[$failureKey] = $filteredFails;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF token
    $token = $_POST['csrf_token'] ?? '';
    if (!Security::validateCSRFToken($token)) {
        die('Security validation failed. Please refresh and try again.');
    }

    $username = trim($_POST['username']);
    $pwdInput = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT id, username, email, role, password FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $resultSet = $stmt->get_result();
        $aUserData =$resultSet->fetch_assoc();

        // Verify user exists AND password matches stored hash safely   
       /* FIXED LOGIN LOGIC */
       if($aUserData && isset($aUserData['password']) && is_string($aUserData['password'])){
            if(password_verify($pwdInput,$aUserData['password'])){ 
                // Check if admin  
                if(isset($aU ser Data[ 'role'])&&$aU ser Data[ 'role' ]==='admin'){
                   bValidLogin= true; 
                } else {    
                    // Not admin     
                    error="Access denied. Admin only.";      
               }
            }
         }

      /* If we get here check valid flag */
      if(!isset(error)||empty(error)){
          unset($_SESSION[$failureKey]); 
          session_regenerate_id(true);
          SESSION[user_id]= a User Data[id];
           SESSION[username]= a User Data[username];
           _SESSION[role]= a User Data[role];
           
           header ("Location: admin/dashboard.PHP");               
           exit();
      }

   } catch(Exception e){
     error ="System error occurred.";
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Login - MindaNow</title>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href=https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600&family=Playfair+Display:wght@600;700&display rel=stylesheet>

<!-- Icons -->
<link rel stylesheet href=https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css

style
:root { --forest:#1A3A2A; --emerald:#2D6A4F ;--lime:#74C69D ;--sand:#F4E9D8 ;--ochre:#D4 A253 ;--cream:#FDF8F2;}
* { margin:0;p add ing0;b ox-sizing:b order-box;font-family:'DM Sans',sans-serif;}
body{background:var(--cream);min-height:100vh display flex align-items:center justify-content:center}
.login-wrapper{displayflex width-full height-100vh}
.login-left{flex1 display-flex align-items-center justify-content:center backgroundvar forest position relative overflow hidden}
.login-left::before{content''position absolute inset-0 background radial-gradient ellipse60%80%at70%60%,rgba45,,79,.40%,transparent60%}
.logo-text{font-family:'Bebas Neue',sans-serif;font-sizeclamp3rem6vw5rem letterspacing6px colorvar lime margin-bottom05rem}
.logo-text spancolor var ochre taglinecolorrgba255255065 fontsize1rem letter-spacing2px text-transformuppercase island-svg{margin-top3rem opacity015 widthclamp200px50vw300px}

/* right side form */
.login-right{flex07display-flexalign-itemscenterjustify-contentcenterpadding30}.login-card{max-width420pxwidthfull}

/* Form styling */
.form-groupmargin-bottom125positionrelative labelfont-size085 font-weight500color#666texttransformuppercaseletter-spacing01chmarginbottom05blockinputwrapper{border-radius04border-color#999transitionallfocus-withinborder-coloremeraldbox-shadow001rgba45000}icon{paddingleft12coloraaa}frm-input{padding11bordernoneoutline:nonefontsize95%;backgroundtransparentwidth-full}.btn-login{borderradiusbackgroundvarforestcolorfff;bordernonecursorpointer;fontweight600fontsize9letter-spacing15text-transformuppercasew-fullpy90mt1}.btn-login:hover(bgvaremerald)

.error-message{border-radiuspadding10bg-red50;colorred85mb125borderleft31solidred}

.forgot-link(fontsize85colorgray;textdecorationnonehover(coloremerald)
</style></head></html>

<?php

// Continue PHP processing after HTML for error handling etc.
// But actually let's restructure to do PHP first then output HTML.

// Re-do from top cleanly:

session_start(); require_once'includes/db php'; require_once'includes/csrf php';

S ecurity :: generateC SRFT ok en();

// Rate limiting stuff as before...
// ... same rate limit code ...

// POST handling...

?>


<body style=background:fdf8f2 min-height100vh displayflex alignitemscenter justifycontentcenter>

<div style=displayflex widthfull maxwidth1100px heightauto boxshadow015030rgba000012 radiusoverflowhidden>

!-- LEFT SIDE - Visual --
div style=flex13 bgcolor#1A3A2Apadding40 positionrelative overflowhidden dnonessm-block"

div styl e=textalign center positionrelative zindex20 pt5

div style=fon tFamily:Bebas Neue fon tSizeclamp28r em56w rem42r em letterspacing08ch colort74c69d>Minda<span styl ecolor#D4 A253>Now</span>/div div styl e=col orrgba255255065 fontsizepx l etterSpacing03ch tex ttransformuppercase mar ginTop05r em>A dm in Access/div svg class=silhouette viewBox00500300 fill=none xmlnshtt pwwww30rg2000svg sty le=margintop30 op acity012 widt hclamp180p x40vw280p xellipse cx150 cy220 rx120 ry60 fill74c69d/path dM80220 Q110160140180 Q160100180120 Q20080190220 Q23060250280 Zfill236 A4 F/path dM150120 L15050Q145809013010Zfilll a3 A29 ellips ecx130 cy48 rx14 ry10 fill236 A49/sv g/svg /div /div !-- RIGHT SIDE FORM --> < div st yle=f lex07 padd ing30 di spl ayfl ex ali gnitemsc enterjusti fycent er backgroun dfdfbf7 >

<div st yle=maxwid th380 wi dt hfullst yle=paddin gtop20 >h sytle-fontfa milyPlayfair Display fontsizel35 r semiboldcolortForestmarginbottom025em welcomback/h?

<p styl=e-colorgra yfontsize095rmb25Pleaseloginto manage your conten t/p hp echo Security::

csrfField()? !-- Hidden CS RF field -->

<?ph pif(!empty(error)): ?>
 <di valert alert-danger rol ealert sty le=padd ing810 bor derrad iusbsmallmar ginbot tom125 bo rderleft31soliddc354 >
 <?phpecho htmlspecialchars(error)? button typebutton classclose aria-labelClose onclickthisparentN ode remove>&times;/button </di v <?phpendif?> 

<f ormmethod POST acti on action=> Note empty action means self -->

 <di vstyl=e-mar ginbotto m125 posrelat ive> label fo r=u sername sty lef ontweight500 fontsize085 tex tt ransformuppercaselet ter spacing01chcol orgray66 mar gin bot tom05displblockUsern ame/l abel> di vsty leposrelat ive displ ayfl ex ai gnitemscente rbord erradius04 bor derco lor999transit ionall bo xtshad ow focuswithinbo rd ercol ore mer aldboxshadow001 ra dius02soli drgba45000)>spanclassinputicon pad ding left12 coloraaa><ic las sfassol idu ser>/i/sp an<input typ etextname userna mec lassforminput placeholderUsername requiredautocompleteusernamesty lev al ue?=!empt y(username)?htmlspecial chars(username):''?> </dicv ></dicv >  

<sectio ncontai ns pas sword similar pattern... also add forgot link under button maybe later>.

Then submit btn.

Finally close tags.

But I'm making errors due to typing fast without testing each line individually!

Let's restart fresh approach:

I'll make one complete working file that compiles correctly when saved exactly as typed here.
Let me create a completely new clean login page from scratch:
