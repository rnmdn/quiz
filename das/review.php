<?php
session_start();
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['quiz_questions'])) {
    header('Location: quizzes.php');
    exit();
}

$questions = $_SESSION['quiz_questions'];
$userAnswers = $_SESSION['quiz_user_answers'];
$subject = $_SESSION['quiz_subject'] ?? 'Quiz';
$difficulty = $_SESSION['difficulty'] ?? 'unknown';
$username = $_SESSION['username'] ?? 'Sanchez';
$email = $_SESSION['email'] ?? 'sanchez@example.com';
$total = count($questions);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizBee - Review Answers</title>
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
            height: 100vh;
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
            overflow: hidden;
        }
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
            padding: 40px 60px;
            background-color: #fffbe6;
            overflow-y: auto;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .page-title {
            color: #f8b44c;
            font-size: 2.5rem;
            font-weight: 800;
        }
        .quiz-info {
            font-size: 1.2rem;
            color: #7d6b3a;
        }
        .review-list {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        .review-card {
            border-radius: 12px;
            padding: 25px;
            transition: background-color 0.2s;
        }
        .review-card.correct {
            background-color: #e8f5e9;  /* light green */
        }
        .review-card.wrong {
            background-color: #ffebee;  /* light red */
        }
        .question-text {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #1a1a1a;
        }
        .answer-detail {
            margin-top: 10px;
            padding: 10px;
            background-color: #ffffff;
            border-radius: 8px;
        }
        .user-answer {
            margin-bottom: 8px;
        }
        .correct-answer {
            font-weight: bold;
            margin-top: 5px;
        }
        .back-btn {
            display: inline-block;
            background-color: #fce883;
            padding: 10px 25px;
            border-radius: 8px;
            text-decoration: none;
            color: #000;
            font-weight: bold;
            margin-top: 30px;
            transition: filter 0.2s;
        }
        .back-btn:hover { filter: brightness(0.95); }

        /* Logout modal styles */
        #logout-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(253, 232, 131, 0.45);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        #logout-box {
            background: #fdfce9;
            border: 1.5px solid #fce883;
            border-radius: 16px;
            padding: 36px 40px;
            width: 400px;
            max-width: 90vw;
            text-align: center;
        }
        #logout-box .bee-icon {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        #logout-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #f8b44c;
            margin-bottom: 8px;
        }
        #logout-body {
            font-size: 0.9rem;
            color: #5a4a2a;
            line-height: 1.6;
            margin-bottom: 28px;
        }
        .logout-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        #logout-cancel {
            padding: 10px 28px;
            border-radius: 8px;
            border: 1.5px solid #fce883;
            background: #fff;
            color: #7d6b3a;
            font-weight: bold;
            cursor: pointer;
        }
        #logout-cancel:hover {
            background: #fef9e3;
        }
        #logout-confirm {
            padding: 10px 28px;
            border-radius: 8px;
            border: none;
            background: #f8b44c;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }
        #logout-confirm:hover {
            background: #e6a030;
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
            <a href="quizzes.php" class="nav-item">
                <img src="quizzesicon.png" alt="Quizzes" class="icon-img">
                <span>Quizzes</span>
            </a>
        </nav>
        <div class="logout-container">
            <!-- Changed to trigger modal -->
            <a href="#" class="nav-item logout" id="logoutBtn">
                <img src="logout.png" alt="Log Out" class="icon-img">
                <span>Log Out</span>
            </a>
        </div>
    </aside>

    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">Review Answers</h1>
            <div class="quiz-info"><?php echo htmlspecialchars($subject); ?> • <?php echo ucfirst($difficulty); ?> • 10 questions</div>
        </div>

        <div class="review-list">
            <?php for ($i = 0; $i < $total; $i++): 
                $q = $questions[$i];
                $userAns = $userAnswers[$i] ?? '(Not answered)';
                $correctAns = $q['ans'];
                $isCorrect = ($userAns === $correctAns);
                $cardClass = $isCorrect ? 'correct' : 'wrong';
            ?>
                <div class="review-card <?php echo $cardClass; ?>">
                    <div class="question-text"><?php echo ($i+1) . ". " . htmlspecialchars($q['q']); ?></div>
                    <div class="answer-detail">
                        <div class="user-answer">
                            <strong>Your answer:</strong> <?php echo htmlspecialchars($userAns); ?>
                        </div>
                        <?php if (!$isCorrect): ?>
                            <div class="correct-answer">
                                <strong>Correct answer:</strong> <?php echo htmlspecialchars($correctAns); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

        <a href="result.php" class="back-btn">← Back to Results</a>
    </main>
</div>

<!-- Logout confirmation modal -->
<div id="logout-overlay">
    <div id="logout-box">
        <div class="bee-icon">🐝</div>
        <div id="logout-title">Log out of QuizBee?</div>
        <div id="logout-body">Are you sure you want to leave?<br>Your review progress will not be saved.</div>
        <div class="logout-buttons">
            <button id="logout-cancel">Cancel</button>
            <button id="logout-confirm">Log out</button>
        </div>
    </div>
</div>

<script>
    // Logout modal logic
    const logoutBtn = document.getElementById('logoutBtn');
    const logoutOverlay = document.getElementById('logout-overlay');

    if (logoutBtn) {
        logoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            logoutOverlay.style.display = 'flex';
        });
    }

    document.getElementById('logout-confirm').addEventListener('click', () => {
        window.location.href = 'logout.php';
    });

    document.getElementById('logout-cancel').addEventListener('click', () => {
        logoutOverlay.style.display = 'none';
    });

    logoutOverlay.addEventListener('click', (e) => {
        if (e.target === logoutOverlay) {
            logoutOverlay.style.display = 'none';
        }
    });
</script>

</body>
</html>