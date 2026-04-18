<?php
session_start();
require_once 'questions.php';

// Authentication & session checks
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}
if (!isset($_SESSION['quiz_subject']) || !isset($_SESSION['difficulty'])) {
    header('Location: difficulty.php');
    exit();
}

$subject = $_SESSION['quiz_subject'];
$difficulty = $_SESSION['difficulty'];
$username = $_SESSION['username'] ?? 'Sanchez';
$email = $_SESSION['email'] ?? 'sanchez@example.com';

// Initialize or restore quiz state
if (!isset($_SESSION['quiz_questions']) || !isset($_SESSION['quiz_current_index'])) {
    $pool = getQuestionPool($subject, $difficulty);
    if (empty($pool)) {
        die("No questions available for this subject/difficulty.");
    }
    shuffle($pool);
    $_SESSION['quiz_questions'] = array_slice($pool, 0, 10);
    $_SESSION['quiz_current_index'] = 0;
    $_SESSION['quiz_user_answers'] = array_fill(0, 10, null);
}

$questions = $_SESSION['quiz_questions'];
$total = count($questions);
$currentIdx = $_SESSION['quiz_current_index'];
$currentQuestion = $questions[$currentIdx];
$userAnswers = $_SESSION['quiz_user_answers'];

// Handle navigation and final submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // AJAX save answer
    if (isset($_POST['ajax_save'])) {
        $idx = (int)$_POST['q_index'];
        $selected = $_POST['answer'] ?? null;
        if ($selected !== null && array_key_exists($idx, $userAnswers)) {
            $userAnswers[$idx] = $selected;
            $_SESSION['quiz_user_answers'] = $userAnswers;
            $answeredCount = count(array_filter($userAnswers));
            echo json_encode(['success' => true, 'answeredCount' => $answeredCount]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit();
    }
    
    // Save current answer from standard form submission (fallback)
    if (isset($_POST['answer'])) {
        $userAnswers[$currentIdx] = $_POST['answer'];
        $_SESSION['quiz_user_answers'] = $userAnswers;
    }

    // Navigation
    if (isset($_POST['next']) && $currentIdx + 1 < $total) {
        $_SESSION['quiz_current_index'] = $currentIdx + 1;
        header("Location: quiz.php");
        exit();
    } elseif (isset($_POST['prev']) && $currentIdx - 1 >= 0) {
        $_SESSION['quiz_current_index'] = $currentIdx - 1;
        header("Location: quiz.php");
        exit();
    } elseif (isset($_POST['submit_quiz'])) {
        // Calculate score
        $score = 0;
        foreach ($questions as $idx => $q) {
            if ($userAnswers[$idx] === $q['ans']) $score++;
        }
        $percentage = ($score / $total) * 100;
        $remarks = ($percentage >= 90) ? "Excellent" : (($percentage >= 70) ? "Good" : "Needs Improvement");
        $_SESSION['quiz_score'] = $score;
        $_SESSION['quiz_total'] = $total;
        $_SESSION['quiz_percentage'] = round($percentage, 2);
        $_SESSION['quiz_remarks'] = $remarks;
        header('Location: result.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizBee - Taking Quiz</title>
    <style> 
        * { box-sizing: border-box; margin: 0; padding: 0; }
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
        .container { display: flex; flex-grow: 1; overflow: hidden; }
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
        .main-content { flex-grow: 1; padding: 40px 60px; background-color: #ffffff; overflow-y: auto; }
        .quiz-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
        .page-title { color: #f8b44c; font-size: 2.5rem; margin-bottom: 5px; }
        .page-subtitle { font-size: 1.4rem; font-weight: bold; color: #000; }
        .timer {
            background-color: #fdf3bb;
            color: #f8b44c;
            font-size: 2rem;
            font-weight: bold;
            padding: 8px 20px;
            border-radius: 15px;
            font-family: monospace;
        }
        .progress-info { display: flex; justify-content: space-between; font-weight: bold; margin-bottom: 8px; }
        .progress-bar-container {
            width: 100%;
            height: 18px;
            background-color: #b3cfff;
            border-radius: 10px;
            margin-bottom: 30px;
            overflow: hidden;
        }
        .progress-bar-fill { 
            height: 100%; 
            background-color: #558df2; 
            border-radius: 10px; 
            width: 0%; 
            transition: width 0.3s ease;
        }
        .question-card { background-color: #fdf3bb; padding: 30px; border-radius: 12px; margin-bottom: 20px; }
        .question-box { background-color: #ffffff; padding: 15px 25px; border-radius: 8px; margin-bottom: 25px; }
        .question-box h3 { font-size: 1.3rem; font-weight: bold; }
        .option-box {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            padding: 12px 25px;
            border-radius: 8px;
            margin-bottom: 12px;
            cursor: pointer;
            border: 1px solid transparent;
            transition: background-color 0.2s ease;
        }
        .option-box:hover { background-color: #fafafa; }
        .option-box input[type="radio"] { display: none; }
        .custom-radio {
            width: 22px;
            height: 22px;
            border: 1px solid #000;
            border-radius: 50%;
            margin-right: 15px;
            display: inline-block;
            background-color: #fff;
        }
        .option-box input[type="radio"]:checked + .custom-radio { background-color: #7ab28d; }
        .option-text { font-size: 1.1rem; font-weight: bold; }
        .quiz-footer { display: flex; justify-content: space-between; padding: 0 10px; margin-top: 20px; }
        .nav-btn {
            background-color: #fce883;
            color: #000;
            border: none;
            padding: 12px 35px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: filter 0.2s ease;
        }
        .nav-btn:hover { filter: brightness(0.95); }
        .error-message {
            background-color: #ffebee;
            color: #c62828;
            border-left: 5px solid #c62828;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: left;
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
        <div class="quiz-header">
            <div class="quiz-titles">
                <h1 class="page-title"><?php echo htmlspecialchars($subject); ?></h1>
                <h2 class="page-subtitle"><?php echo ucfirst($difficulty); ?> Quiz</h2>
            </div>
            <div class="timer" id="timerDisplay">5:00</div>
        </div>

        <?php
        $answeredCount = count(array_filter($userAnswers));
        $progressPercent = ($answeredCount / $total) * 100;
        ?>
        <div class="progress-info">
            <span>Question <?php echo $currentIdx + 1; ?> of <?php echo $total; ?></span>
            <span id="answeredCountDisplay">Items up to 10 | <?php echo $answeredCount; ?> answered</span>
        </div>
        <div class="progress-bar-container">
            <div class="progress-bar-fill" id="progressFill" style="width: <?php echo $progressPercent; ?>%;"></div>
        </div>

        <form method="post" id="navForm">
            <div class="question-card">
                <div class="question-box">
                    <h3><?php echo ($currentIdx+1) . ". " . htmlspecialchars($currentQuestion['q']); ?></h3>
                </div>
                <?php foreach ($currentQuestion['opts'] as $opt): ?>
                    <label class="option-box">
                        <input type="radio" name="answer" value="<?php echo htmlspecialchars($opt); ?>"
                            <?php echo ($userAnswers[$currentIdx] === $opt) ? 'checked' : ''; ?>>
                        <span class="custom-radio"></span>
                        <span class="option-text"><?php echo htmlspecialchars($opt); ?></span>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="quiz-footer">
                <?php if ($currentIdx > 0): ?>
                    <button type="submit" name="prev" class="nav-btn">Previous</button>
                <?php else: ?>
                    <button type="button" class="nav-btn" style="visibility: hidden;">Previous</button>
                <?php endif; ?>
                
                <?php if ($currentIdx + 1 < $total): ?>
                    <button type="submit" name="next" class="nav-btn">Next</button>
                <?php else: ?>
                    <button type="submit" name="submit_quiz" class="nav-btn" onclick="return window.timerExpired || confirm('Are you sure you want to submit the quiz? You cannot change answers after submission.')">Submit Quiz</button>
                <?php endif; ?>
            </div>
        </form>
    </main>
</div>

<script>
    const totalTime = 300;
    const timerEl = document.getElementById('timerDisplay');
    const navForm = document.getElementById('navForm');
    const totalQuestions = <?php echo $total; ?>;
    const progressFill = document.getElementById('progressFill');
    const answeredCountSpan = document.getElementById('answeredCountDisplay');

    const quizKey = "quizStartTime_<?php echo addslashes($subject); ?>";

    let startTime = localStorage.getItem(quizKey);
    if (!startTime) {
        startTime = Date.now();
        localStorage.setItem(quizKey, startTime);
    }

    function updateTimer() {
        const now = Date.now();
        const elapsed = Math.floor((now - startTime) / 1000);
        const timeLeft = totalTime - elapsed;

        if (timeLeft <= 0) {
            window.timerExpired = true;
            localStorage.removeItem(quizKey);
            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "submit_quiz";
            input.value = "1";
            navForm.appendChild(input);
            navForm.submit();
            return;
        }

        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        timerEl.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
    }

    updateTimer();
    setInterval(updateTimer, 1000);

    // Auto-save answer and update progress bar when radio button is clicked
    const radioButtons = document.querySelectorAll('input[name="answer"]');
    const currentIndex = <?php echo $currentIdx; ?>;

    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            const selectedValue = this.value;
            fetch(window.location.href, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `ajax_save=1&q_index=${currentIndex}&answer=${encodeURIComponent(selectedValue)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update answered count display
                    const newCount = data.answeredCount;
                    answeredCountSpan.textContent = `Items up to 10 | ${newCount} answered`;
                    // Update progress bar width based on answered count
                    const newPercent = (newCount / totalQuestions) * 100;
                    progressFill.style.width = newPercent + '%';
                }
            })
            .catch(err => console.error('Auto-save error:', err));
        });
    });
</script>
</body>
</html>