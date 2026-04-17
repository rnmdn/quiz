<?php
session_start();
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['quiz_score'])) {
    header('Location: quizzes.php');
    exit();
}

$score = $_SESSION['quiz_score'];
$total = $_SESSION['quiz_total'];
$percentage = $_SESSION['quiz_percentage'];
$remarks = $_SESSION['quiz_remarks'];
$username = $_SESSION['username'] ?? 'Sanchez';
$email = $_SESSION['email'] ?? 'sanchez@example.com';

// Determine color class and feedback message based on percentage
if ($percentage >= 80) {
    $scoreClass = 'score-excellent';
    $feedback = ($percentage == 100) ? "Outstanding! Perfect score!" : "Excellent work! Keep it up!";
    $beeImage = "bee-excellent.png";
} elseif ($percentage >= 60) {
    $scoreClass = 'score-good';
    $feedback = "Good effort! You're doing well!";
    $beeImage = "bee-good.png";
} elseif ($percentage >= 40) {
    $scoreClass = 'score-improve';
    $feedback = "Fair attempt. Keep practicing!";
    $beeImage = "bee-improve.png";
} else {
    $scoreClass = 'score-try-again';
    $feedback = "Keep studying. You can do better!";
    $beeImage = "bee-improve.png";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizBee - Quiz Results</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #000;
            background-color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .top-bar {
            width: 100%;
            background-color: #fdfce9;
            padding: 15px 30px;
            border-bottom: 1px solid #fce883;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .logo { height: 60px; width: auto; }
        .site-title {
            font-size: 2rem;
            font-weight: 800;
            color: #f8b44c;
            letter-spacing: 1px;
        }
        .container {
            display: flex;
            flex-grow: 1;
        }
        .sidebar {
            width: 280px;
            background-color: #fdfce9;
            border-right: 1px solid #fce883;
            display: flex;
            flex-direction: column;
            padding: 30px 20px 20px 20px;
            position: fixed;
            height: 100vh;
        }
        .user-card {
            display: flex;
            align-items: center;
            background-color: #fef0a1;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .user-card .icon-img { width: 40px; height: 40px; margin-right: 15px; }
        .username { font-weight: bold; color: #f8b44c; font-size: 1.1rem; }
        .email { font-size: 0.75rem; font-weight: bold; color: #7d6b3a; }
        .nav-menu { display: flex; flex-direction: column; gap: 10px; flex-grow: 1; }
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
        .nav-item.active { background-color: #fef0a1; color: #f8b44c; }
        .nav-item .icon-img { width: 24px; height: 24px; margin-right: 15px; object-fit: contain; }
        .logout-container { border-top: 1px solid #fce883; padding-top: 20px; margin-top: 20px; }
        .main-content {
            flex-grow: 1;
            padding: 40px 60px 100px 60px;
            background-color: #ffffff;
            margin-left: 280px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 80px);
        }
        .results-card {
            background-color: #fdf3bb;
            border-radius: 15px;
            padding: 50px 120px 50px 60px;
            text-align: center;
            position: relative;
            width: 550px;
            max-width: 90%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
        }
        .score-excellent { color: #4caf50; }
        .score-good { color: #2196f3; }
        .score-improve { color: #ff9800; }
        .score-try-again { color: #f44336; }
        .final-score {
            font-size: 5.5rem;
            font-weight: 800;
            margin-bottom: 15px;
            letter-spacing: -2px;
        }
        .percentage {
            font-size: 2.2rem;
            font-weight: 800;
            color: #000;
            margin-bottom: 15px;
        }
        .feedback-text {
            font-size: 1.4rem;
            font-weight: bold;
            color: #000;
        }
        .result-bee-img {
            position: absolute;
            right: -100px;
            top: 50%;
            transform: translateY(-50%);
            width: 320px;
            height: auto;
            z-index: 10;
        }
        .retake-btn {
            margin-top: 30px;
            background-color: #fce883;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            color: #000;
            font-weight: bold;
            display: inline-block;
            transition: filter 0.2s;
        }
        .retake-btn:hover { filter: brightness(0.95); }
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
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
            <a href="#" class="nav-item">
                <img src="library.png" alt="Library" class="icon-img">
                <span>Your Library</span>
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
        <div class="results-card">
            <div class="final-score <?php echo $scoreClass; ?>"><?php echo "$score/$total"; ?></div>
            <div class="percentage"><?php echo $percentage; ?>%</div>
            <div class="feedback-text"><?php echo $feedback; ?></div>
            <img src="<?php echo $beeImage; ?>" alt="QuizBee Result" class="result-bee-img">
        </div>
        <div class="button-group">
            <a href="quizzes.php" class="retake-btn">📚 Take Another Quiz</a>
            <a href="review.php" class="retake-btn">🔍 Review Answers</a>
        </div>
    </main>
</div>

</body>
</html>