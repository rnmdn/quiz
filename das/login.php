<?php
session_start();

// Function to validate login credentials
function loginSystem($username, $password) {
    return ($username === 'student' && $password === 'quiz123');
}

// Initialize login attempts counter
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

$error = '';
$locked = false;

// Check if account is already locked (3 or more failed attempts)
if ($_SESSION['login_attempts'] >= 3) {
    $locked = true;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login']) && !$locked) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (loginSystem($username, $password)) {
        // Successful login
        $_SESSION['loggedin'] = true;
        $_SESSION['login_attempts'] = 0; // reset attempts
        header('Location: difficulty.php');
        exit();
    } else {
        $_SESSION['login_attempts']++;
        $remaining = 3 - $_SESSION['login_attempts'];
        if ($_SESSION['login_attempts'] >= 3) {
            $locked = true;
            $error = ""; // no error message, show locked page instead
        } else {
            $error = "Invalid username or password. Attempts remaining: $remaining";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $locked ? 'QuizBee - Hive Sealed' : 'QuizBee - Login'; ?></title>
    <style>
        /* Shared reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Normal login page styles (unlocked) */
        body.login-page {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #FEF9E7;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            position: relative;
            max-width: 600px;
            width: 100%;
        }
        .login-card {
            background-color: #FFD93D;
            padding: 40px 40px 60px 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1;
        }
        h2 {
            color: #1a1a1a;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            color: #1a1a1a;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            background-color: white;
            font-size: 14px;
            transition: box-shadow 0.3s;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.5);
        }
        button {
            width: 100%;
            padding: 14px;
            background-color: #1a1a1a;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: transform 0.2s, background-color 0.2s;
        }
        button:hover {
            background-color: #333;
            transform: translateY(-2px);
        }
        button:active {
            transform: translateY(0);
        }
        .error {
            background-color: #ff6b6b;
            color: white;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }
        .bee-container {
            position: absolute;
            bottom: -20px;
            right: -20px;
            z-index: 2;
            width: 200px;
            height: auto;
        }
        .bee-image {
            width: 100%;
            height: auto;
            display: block;
            filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.2));
        }
        .hint {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            background-color: rgba(255,255,255,0.3);
            padding: 8px;
            border-radius: 6px;
        }

        /* Locked page styles (Hive Sealed) */
        body.locked-page {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fcfbe3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        .alert-card {
            background-color: #ffcc00;
            border-radius: 20px;
            padding: 70px 100px 70px 70px;
            position: relative;
            max-width: 700px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }
        .alert-message {
            font-size: 2.2rem;
            font-weight: 700;
            color: #000000;
            line-height: 1.5;
        }
        .security-bee-img {
            position: absolute;
            bottom: -50px;
            right: -80px;
            width: 250px;
            height: auto;
            z-index: 10;
        }
        @media (max-width: 768px) {
            .alert-card {
                padding: 40px;
                margin: 20px;
            }
            .alert-message {
                font-size: 1.5rem;
            }
            .security-bee-img {
                width: 150px;
                bottom: -30px;
                right: -30px;
            }
        }
    </style>
</head>
<body class="<?php echo $locked ? 'locked-page' : 'login-page'; ?>">
    <?php if ($locked): ?>
        <!-- LOCKED STATE: Hive Sealed Alert Card -->
        <div class="alert-card">
            <p class="alert-message">
                Un-bee-lievable! 🐝 That's<br>
                3 incorrect attempts.<br>
                We've temporarily <br>
                sealed the hive.
            </p>
            <img src="security-bee.png" alt="Security Bee Guard" class="security-bee-img">
        </div>
    <?php else: ?>
        <!-- NORMAL LOGIN FORM -->
        <div class="container">
            <div class="login-card">
                <h2>Welcome to QuizBee!</h2>

                <?php if ($error): ?>
                    <div class="error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="form-group">
                        <label for="username">Email:</label>
                        <input type="text" id="username" name="username" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" name="login">Login</button>
                </form>
                <p class="hint">Hint: student / quiz123</p>
            </div>
            <div class="bee-container">
                <img src="bee.png" alt="QuizBee Mascot" class="bee-image">
            </div>
        </div>
    <?php endif; ?>
</body>
</html>