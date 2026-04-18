<?php
session_start();

// Prevent access without login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'] ?? 'Sanchez';
$email    = $_SESSION['email'] ?? 'sanchez@example.com';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizBee - Quizzes List</title>
    <style>
        /* Reset and Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #000;
            background-color: #ffffff;
            height: 100vh; 
            display: flex;
            flex-direction: column;
        }

        /* ================== TOP MENU BAR ================== */
        .top-bar {
            width: 100%;
            background-color: #fdfce9; 
            padding: 15px 30px;
            border-bottom: 1px solid #fce883; 
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            height: 60px; 
            width: auto;
        }

        .site-title {
            font-size: 2rem;
            font-weight: 800;
            color: #f8b44c;
            letter-spacing: 1px;
        }

        /* ================== MAIN LAYOUT ================== */
        .container {
            display: flex;
            flex-grow: 1; 
            overflow: hidden; 
        }

        /* ================== SIDEBAR ================== */
        .sidebar {
            width: 280px;
            background-color: #fdfce9; 
            border-right: 1px solid #fce883; 
            display: flex;
            flex-direction: column;
            padding: 30px 20px 20px 20px;
        }

        .user-card {
            display: flex;
            align-items: center;
            background-color: #fef0a1; 
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .user-card .icon-img {
            width: 40px;
            height: 40px;
            margin-right: 15px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .username {
            font-weight: bold;
            color: #f8b44c; 
            font-size: 1.1rem;
        }

        .email {
            font-size: 0.75rem;
            font-weight: bold;
            color: #7d6b3a;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex-grow: 1; 
        }

        .nav-item {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #000;
            font-weight: bold;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 1.1rem;
            transition: background-color 0.2s ease;
        }

        .nav-item.active {
            background-color: #fef0a1;
            color: #f8b44c;
        }

        .nav-item .icon-img {
            width: 24px;
            height: 24px;
            margin-right: 15px;
            object-fit: contain;
        }

        .logout-container {
            border-top: 1px solid #fce883;
            padding-top: 20px;
            margin-top: 20px;
        }

        .main-content {
            flex-grow: 1;
            padding: 60px;
            background-color: #ffffff; 
            overflow-y: auto;
        }

        .section-heading {
            color: #f8b44c; 
            font-size: 2.2rem;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .quiz-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;           /* Full width of parent */
            /* Remove max-width restriction */
        }

        .quiz-list-item {
            border: 1px solid #fce883;
            border-radius: 10px;
            padding: 25px 20px;
            background-color: #fffbe6; 
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: box-shadow 0.2s ease, transform 0.2s ease;
            cursor: pointer;
            width: 100%;           /* Each item spans full width */
        }

        .quiz-list-item:hover {
            box-shadow: 0 4px 10px rgba(248, 180, 76, 0.15);
            transform: translateY(-2px);
        }

        .quiz-subject {
            color: #f8cc1b;
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .quiz-details {
            color: #000;
            font-size: 0.95rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

<header class="top-bar">
    <img src="bee.png" alt="QuizBee Logo" class="logo">
    <div class="site-title">QuizBee</div>
</header>

<div class="container">
    
    <aside class="sidebar">
        <div class="user-card">
            <img src="usericon.png" alt="User Icon" class="icon-img">
            <div class="user-info">
                <span class="username"><?php echo htmlspecialchars($username); ?></span>
                <span class="email"><?php echo htmlspecialchars($email); ?></span>
            </div>
        </div>

        <nav class="nav-menu">
            <a href="quizzes.php" class="nav-item active">
                <img src="quizzesicon.png" alt="Quizzes" class="icon-img">
                <span>Quizzes</span>
            </a>
        </nav>

        <div class="logout-container">
            <a href="logout.php" class="nav-item logout">
                <img src="logout.png" alt="Log Out" class="icon-img">
                <span>Log Out</span>
            </a>
        </div>
    </aside>

    <main class="main-content">
        <h1 class="section-heading">Quizzes to Take:</h1>

        <div class="quiz-list">
            <?php
            $subjects = [
                ['name' => 'Web Programming', 'details' => 'HTML Scripts | Items up to 10'],
                ['name' => 'App Development', 'details' => 'Notification | Items up to 10'],
                ['name' => 'Integrative Programming', 'details' => 'PHP | Items up to 10'],
                ['name' => 'Advance Database', 'details' => 'SQL | Items up to 10']
            ];

            foreach ($subjects as $subject) {
                $encoded = urlencode($subject['name']);
                echo '<a href="difficulty.php?subject=' . $encoded . '" class="quiz-list-item">';
                echo '<h3 class="quiz-subject">' . htmlspecialchars($subject['name']) . '</h3>';
                echo '<p class="quiz-details">' . htmlspecialchars($subject['details']) . '</p>';
                echo '</a>';
            }
            ?>
        </div>
    </main>
</div>

</body>
</html>