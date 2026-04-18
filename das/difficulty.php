<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['subject']) && !empty(trim($_GET['subject']))) {
    $_SESSION['quiz_subject'] = trim(urldecode($_GET['subject']));
} elseif (!isset($_SESSION['quiz_subject'])) {
    header('Location: quizzes.php');
    exit();
}

$username = $_SESSION['username'] ?? 'Sanchez';
$email    = $_SESSION['email'] ?? 'sanchez@example.com';
$subject  = $_SESSION['quiz_subject'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['difficulty'])) {
    $difficulty = $_POST['difficulty'];
    if (in_array($difficulty, ['easy', 'medium', 'hard'])) {
        $_SESSION['difficulty'] = $difficulty;
        unset($_SESSION['quiz_questions']);
        unset($_SESSION['user_answers']);
        unset($_SESSION['quiz_score']);
        unset($_SESSION['quiz_percentage']);
        unset($_SESSION['quiz_remarks']);
        header('Location: quiz.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizBee - Choose Difficulty</title>
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

        /* Active state for Quizzes */
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
        }

        .page-title {
            color: #f8b44c;
            font-size: 2.8rem;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
            font-weight: 800;
        }

        .subject-badge {
            font-size: 1.2rem;
            color: #5a4a2a;
            margin-bottom: 20px;
            font-weight: 500;
            background: #fef4d9;
            display: inline-block;
            padding: 5px 15px;
            border-radius: 30px;
        }

        .page-subtitle {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 50px;
        }

        .difficulty-cards {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
        }

        .card {
            background-color: #fdf3bb;
            border-radius: 12px;
            padding: 20px;
            width: 260px;
            height: 260px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.1);
            background-color: #fff5cf;
        }

        .difficulty-img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            pointer-events: none;
        }

        #difficulty-form {
            display: none;
        }

        /* Custom confirm modal for difficulty */
        #confirm-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(253, 232, 131, 0.45);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        #confirm-box {
            background: #fdfce9;
            border: 1.5px solid #fce883;
            border-radius: 16px;
            padding: 36px 40px;
            width: 380px;
            max-width: 90vw;
            text-align: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        #confirm-box .bee-icon {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        #confirm-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #f8b44c;
            margin-bottom: 8px;
        }

        #confirm-body {
            font-size: 0.9rem;
            color: #5a4a2a;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        #confirm-body strong {
            color: #f8b44c;
        }

        .confirm-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        #confirm-cancel {
            padding: 10px 28px;
            border-radius: 8px;
            border: 1.5px solid #fce883;
            background: #fff;
            color: #7d6b3a;
            font-weight: bold;
            font-size: 0.95rem;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.2s;
        }

        #confirm-cancel:hover {
            background: #fef9e3;
        }

        #confirm-ok {
            padding: 10px 28px;
            border-radius: 8px;
            border: none;
            background: #f8b44c;
            color: #fff;
            font-weight: bold;
            font-size: 0.95rem;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.2s;
        }

        #confirm-ok:hover {
            background: #e6a030;
        }

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
            <a href="quizzes.php" class="nav-item active">
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
        <div class="page-title"><?php echo htmlspecialchars($subject); ?></div>
        <h2 class="page-subtitle">Select Difficulty</h2>

        <div class="difficulty-cards">
            <div class="card" data-difficulty="easy">
                <img src="easy.png" alt="Easy" class="difficulty-img">
            </div>
            <div class="card" data-difficulty="medium">
                <img src="medium.png" alt="Medium" class="difficulty-img">
            </div>
            <div class="card" data-difficulty="hard">
                <img src="hard.png" alt="Hard" class="difficulty-img">
            </div>
        </div>
    </main>
</div>

<!-- Custom confirm modal for difficulty -->
<div id="confirm-overlay">
    <div id="confirm-box">
        <div id="confirm-title"></div>
        <div id="confirm-body"></div>
        <div class="confirm-buttons">
            <button id="confirm-cancel">Cancel</button>
            <button id="confirm-ok">Let's go!</button>
        </div>
    </div>
</div>

<!-- Logout confirmation modal -->
<div id="logout-overlay">
    <div id="logout-box">
        <div class="bee-icon">🐝</div>
        <div id="logout-title">Log out of QuizBee?</div>
        <div id="logout-body">Are you sure you want to leave?<br>Any unsaved progress will be lost.</div>
        <div class="logout-buttons">
            <button id="logout-cancel">Cancel</button>
            <button id="logout-confirm">Log out</button>
        </div>
    </div>
</div>

<form id="difficulty-form" method="post" action="">
    <input type="hidden" name="difficulty" id="difficulty-input" value="">
</form>

<script>
    // Difficulty selection modal logic
    const cards = document.querySelectorAll('.card');
    const form = document.getElementById('difficulty-form');
    const difficultyInput = document.getElementById('difficulty-input');
    const overlay = document.getElementById('confirm-overlay');
    const confirmTitle = document.getElementById('confirm-title');
    const confirmBody = document.getElementById('confirm-body');

    let pendingDifficulty = null;
    const subject = "<?php echo addslashes($subject); ?>";

    function showConfirm(difficulty) {
        const name = difficulty.charAt(0).toUpperCase() + difficulty.slice(1);
        confirmTitle.textContent = name + ' difficulty selected';
        confirmBody.innerHTML =
            `Subject: <strong>${subject}</strong><br>
             A 5-minute timer will start as soon as you begin the quiz.`;
        overlay.style.display = 'flex';
        pendingDifficulty = difficulty;
    }

    cards.forEach(card => {
        card.addEventListener('click', function () {
            const difficulty = this.getAttribute('data-difficulty');
            if (!difficulty) return;
            showConfirm(difficulty);
        });
    });

    document.getElementById('confirm-ok').addEventListener('click', () => {
        overlay.style.display = 'none';
        difficultyInput.value = pendingDifficulty;
        form.submit();
    });

    document.getElementById('confirm-cancel').addEventListener('click', () => {
        overlay.style.display = 'none';
        pendingDifficulty = null;
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.style.display = 'none';
            pendingDifficulty = null;
        }
    });

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