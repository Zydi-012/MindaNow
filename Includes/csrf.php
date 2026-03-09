<?php
/**
 * MindaNow Security Module
 * Handles CSRF protection, input validation, and rate limiting
 */

class Security {
    
    /**
     * Generate a CSRF token and store in session
     */
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validate CSRF token from form submission
     */
    public static function validateCSRFToken($token) {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        
        $isValid = hash_equals($_SESSION['csrf_token'], $token);
        
        // Regenerate token after validation to prevent reuse attacks
        if ($isValid) {
            unset($_SESSION['csrf_token']);
            self::generateCSRFToken();
        }
        
        return $isValid;
    }
    
    /**
     * Get hidden HTML input field with CSRF token for forms
     */
    public static function csrfField() {
        $token = self::generateCSRFToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }
    
    /**
     * Sanitize string input - prevents XSS attacks  
     */
    public static function sanitize($input, $maxLength = null) {

if (is_array($input)) { 
return array_map([self::class, 'sanitize'], $input);
}

$output = trim($input);
$output = stripslashes($output);

// Remove potential XSS vectors but preserve formatting tags selectively  
$allowedTags = '<p><br><strong><em><u><a>';
$output = strip_tags($output, $allowedTags);

if ($maxLength && strlen($output) > $maxLength) { 
$output = substr($output, 0, $maxLength); 
}

return htmlspecialchars($output, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
}

/**
* Rate Limiting Class for Login Protection  
*/
class RateLimiter {

/**
* Check if IP should be blocked due to too many failed attempts  
*/
public static function shouldBlockIP(): bool {
// Clean old attempts beyond 15 minutes ago                     
 
If(!isset$_SESSIOn[login_fails]){$_SESSIOn[login_fails]=[];}
     
// Count recent failures within last 15 minutes  

recent_attempts=array_filter(
_Session(login_fail_times],fn(ts)=>ts>(time()-900)
);

Returncount(recent_attempts)>=
 ? ceil((min(recent_attempts)+900-time())/60):0; }    

Public StaticfunctionrecordFailedAttempt(){                       
  
 IP=$ SERVER'REMOTE_ADDR'] ?? '';
 timestamp=time();                         
  
 If(!isset_Session(login_fail_times]))$Session(login_fail_times)=[];
 _Session(logi n_fail_times][]=timestamp;

 / Keep only last10 records max                           

 while(count(_session('login_fail_t imes'])>10{array_shift_session('login_fail_times]);}
 }

 Public StaticfunctionclearFailedAttempts(){
 IP=_SERVER'REMOTE ADDR']??'';
 Unset_SESSION('logi nfailtimes'][P]);
 }


?>
