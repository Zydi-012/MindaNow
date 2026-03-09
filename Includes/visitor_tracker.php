<?php
// Visitor tracking using cookies
function trackVisitor($conn) {
    $cookieName = 'mindanow_visitor';
    $cookieExpiry = time() + (365 * 24 * 60 * 60); // 1 year
    
    if (isset($_COOKIE[$cookieName])) {
        // Existing visitor
        $visitorId = $_COOKIE[$cookieName];
        
        // Update visit count and last visit
        $stmt = $conn->prepare("UPDATE visitors SET visit_count = visit_count + 1, last_visit = NOW() WHERE visitor_id = ?");
        $stmt->bind_param("s", $visitorId);
        $stmt->execute();
    } else {
        // New visitor
        $visitorId = bin2hex(random_bytes(32));
        
        // Insert new visitor
        $stmt = $conn->prepare("INSERT INTO visitors (visitor_id) VALUES (?)");
        $stmt->bind_param("s", $visitorId);
        $stmt->execute();
        
        // Set cookie
        setcookie($cookieName, $visitorId, $cookieExpiry, '/');
    }
}

function getTotalVisitors($conn) {
    $result = $conn->query("SELECT COUNT(*) as total FROM visitors");
    $row = $result->fetch_assoc();
    return $row['total'];
}
?>
