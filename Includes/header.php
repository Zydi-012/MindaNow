<!DOCTYPE html>
<html>
<head>
    <title>MindaNow Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: #1a3a2a;
            color: white;
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar .logo {
            padding: 1.5rem;
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            color: #74c69d;
        }
        .sidebar .logo span { color: #d4a253; }
        .sidebar-menu {
            padding: 1rem 0;
        }
        .sidebar-menu .menu-section {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.5);
            margin-top: 1rem;
        }
        .sidebar-menu a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.9rem;
        }
        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.1);
            color: #74c69d;
            padding-left: 2rem;
        }
        .sidebar-menu a i {
            width: 20px;
            margin-right: 10px;
        }
        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }
        .top-bar {
            background: white;
            padding: 1rem 2rem;
            margin: -2rem -2rem 2rem -2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">Minda<span>Now</span></div>
        <div class="sidebar-menu">
            <a href="../dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            
            <div class="menu-section">Content Management</div>
            <a href="../Articles/index.php"><i class="fas fa-newspaper"></i> Articles</a>
            <a href="../Destinations/index.php"><i class="fas fa-map-marker-alt"></i> Destinations</a>
            <a href="../Cuisine/index.php"><i class="fas fa-utensils"></i> Cuisine</a>
            <a href="../Events/index.php"><i class="fas fa-calendar"></i> Events</a>
            <a href="../Advisories/index.php"><i class="fas fa-exclamation-triangle"></i> Advisories</a>
            <a href="../Gallery/index.php"><i class="fas fa-images"></i> Gallery</a>
            <a href="../MapPins/index.php"><i class="fas fa-map-pin"></i> Map Pins</a>
            
            <div class="menu-section">Settings</div>
            <a href="../../Public/index.php" target="_blank"><i class="fas fa-eye"></i> View Website</a>
            <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <div class="main-content">