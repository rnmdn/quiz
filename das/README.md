# QuizMaster — PHP Quiz Web Application

A complete PHP quiz application built for XAMPP with sessions, difficulty levels, timers, and full answer review.

---

## 📁 File Structure

```
quiz_app/
├── login.php        ← Entry point: loginSystem(), 3-attempt lockout
├── difficulty.php   ← Difficulty selector with confirmation + timer warning
├── questions.php    ← Question bank: 20 questions × 3 difficulties
├── quiz.php         ← Quiz display: 10 random questions, countdown timer
├── result.php       ← Results: checkAnswers(), score, remarks, review
└── README.md        ← This file
```

---

## ⚙️ XAMPP Setup

1. **Install XAMPP** from https://www.apachefriends.org/
2. **Copy** the `quiz_app/` folder into: `C:\xampp\htdocs\quiz_app\`
3. **Start** Apache in XAMPP Control Panel
4. **Open** your browser and go to: `http://localhost/quiz_app/login.php`

> No database setup required — all data is stored in PHP sessions and arrays.

---

## 🔐 Login Credentials

| Field    | Value     |
|----------|-----------|
| Username | `student` |
| Password | `quiz123` |

- **3 failed attempts** → account is locked
- A "Reset (Demo only)" link appears for testing

---

## 🎮 How It Works

### Flow
```
login.php  →  difficulty.php  →  quiz.php  →  result.php
                                    ↑___________↓  (Retry)
```

### Part 1 – Login (`login.php`)
- `loginSystem(username, password)` validates credentials
- `$_SESSION['attempts']` tracks failed attempts
- `$_SESSION['locked']` locks the account after 3 failures
- Empty fields trigger validation message

### Part 2 – Quiz Display (`quiz.php`)
- `getQuestions($difficulty)` returns 20 questions from `questions.php`
- `shuffle()` randomizes question order
- `array_slice()` picks 10 questions
- `foreach` loop renders each question and its 4 radio-button choices
- Countdown timer (Easy: 60s/q · Medium: 45s/q · Hard: 30s/q × 10 questions)
- Auto-submits when time runs out

### Part 3 – Answer Processing (`result.php`)
- `checkAnswers($userAnswers, $questions)` iterates with `foreach`
- Counts correct answers, computes percentage
- Stores result in `$_SESSION['last_result']`
- Appends to `$_SESSION['score_history']` for session leaderboard

### Part 4 – Results (`result.php`)
- Shows: Score (e.g. 7/10), Percentage, Difficulty, Correct/Wrong counts
- Remarks:
  - 90–100% → **Excellent 🏆**
  - 70–89%  → **Good 👍**
  - < 70%   → **Needs Improvement 📚**
- Full answer review showing correct answers and user's wrong answers
- Session score history table (if more than 1 attempt)
- **Retry Quiz** button, Change Difficulty, Logout

---

## ✅ Requirements Checklist

| Requirement | Status |
|---|---|
| PHP sessions (`$_SESSION`) | ✅ |
| `loginSystem()` function | ✅ |
| 3-attempt lockout | ✅ |
| 15+ questions per difficulty (20 each) | ✅ |
| 10 random questions shown per quiz | ✅ |
| `foreach` to display questions & choices | ✅ |
| Radio buttons | ✅ |
| `checkAnswers()` function with `foreach` | ✅ |
| Percentage score | ✅ |
| Remarks (Excellent / Good / Needs Improvement) | ✅ |
| Randomize question order | ✅ |
| Show correct answers after submission | ✅ |
| Retry Quiz button | ✅ |
| Store score in `$_SESSION` | ✅ |
| Difficulty categories (Easy/Medium/Hard) | ✅ |
| Confirmation + timer warning before quiz | ✅ |
| Countdown timer (per difficulty) | ✅ |
| Prevent access without login | ✅ |
| Handle empty answers (validation) | ✅ |
| Handle wrong login attempts | ✅ |

---

## 🧪 Testing Scenarios

| Scenario | Expected Result |
|---|---|
| Wrong password 3× | "Account Locked" message, form hidden |
| Submit with empty field | "Please enter both username and password" |
| Access quiz.php directly | Redirect to login.php |
| Access result.php directly | Redirect to quiz.php |
| Submit quiz with unanswered questions | Red border on unanswered cards, validation message |
| Timer reaches 0 | Auto-submits the form |
| Click Retry | New randomized 10-question set from same difficulty |
