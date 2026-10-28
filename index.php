<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Placement Portal — Career & Recruitment System</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700&display=swap">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Heebo', sans-serif;
    background: radial-gradient(circle at 50% 10%, rgba(30, 20, 35, 0.9) 0%, #0b0f19 85%);
    color: #ffffff;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow-x: hidden;
}

/* Wipe Transition Curtain - Right to Left, matching website dark background */
.wipe-curtain {
    position: fixed;
    top: 0;
    right: -100%;
    width: 100%;
    height: 100%;
    background: #0b0f19; /* Website ke dark background se match karega */
    z-index: 9999;
    transition: transform 0.6s cubic-bezier(0.77, 0, 0.175, 1);
}

.wipe-curtain.active {
    transform: translateX(-100%);
}

/* Navbar */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 50px;
    background: rgba(11, 15, 25, 0.85);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(254, 254, 254, 0.08);
    position: sticky;
    top: 0;
    z-index: 100;
}

.brand {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    color: #ffffff;
}

.brand span {
    color: #E8C777;
}

.nav-links a {
    color: #94a3b8;
    text-decoration: none;
    margin-left: 25px;
    font-weight: 500;
    font-size: 0.95rem;
    transition: color 0.3s;
}

.nav-links a:hover {
    color: #E8C777;
}

/* Hero Section */
.hero {
    text-align: center;
    padding: 70px 20px 50px 20px;
    max-width: 800px;
    margin: auto;
}

.hero-tag {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #E8C777;
    margin-bottom: 15px;
    font-weight: 600;
}

.hero h1 {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 20px;
    line-height: 1.2;
    letter-spacing: -0.5px;
}

.hero h1 span {
    background: linear-gradient(135deg, #ffffff 40%, #E8C777 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hero p {
    font-size: 1.05rem;
    color: #94a3b8;
    margin-bottom: 40px;
    line-height: 1.6;
}

/* Role Cards Section */
.cards-container {
    display: flex;
    justify-content: center;
    gap: 30px;
    max-width: 900px;
    margin: 0 auto 60px auto;
    padding: 0 20px;
    flex-wrap: wrap;
}

.role-card {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(254, 254, 254, 0.1);
    border-radius: 12px;
    padding: 30px;
    width: 100%;
    max-width: 400px;
    text-align: left;
    backdrop-filter: blur(10px);
    transition: transform 0.3s ease, border-color 0.3s ease;
}

.role-card:hover {
    transform: translateY(-5px);
    border-color: rgba(232, 199, 119, 0.4);
}

.card-icon {
    width: 40px;
    height: 40px;
    background: #E8C777;
    color: #0b0f19;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.1rem;
    margin-bottom: 20px;
}

.role-card h3 {
    font-size: 1.3rem;
    margin-bottom: 10px;
    color: #ffffff;
}

.role-card p {
    font-size: 0.95rem;
    color: #94a3b8;
    margin-bottom: 25px;
    line-height: 1.5;
}

.card-link {
    color: #E8C777;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.card-link:hover {
    text-decoration: underline;
}

/* Workflow Section */
.workflow-section {
    background: rgba(0, 0, 0, 0.25);
    border-top: 1px solid rgba(254, 254, 254, 0.06);
    border-bottom: 1px solid rgba(254, 254, 254, 0.06);
    padding: 50px 20px;
    text-align: center;
}

.workflow-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 30px;
}

.steps-grid {
    display: flex;
    justify-content: center;
    gap: 40px;
    max-width: 900px;
    margin: auto;
    flex-wrap: wrap;
}

.step-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #94a3b8;
    font-size: 0.95rem;
}

.step-number {
    width: 28px;
    height: 28px;
    background: rgba(232, 199, 119, 0.15);
    color: #E8C777;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    font-weight: bold;
    border: 1px solid rgba(232, 199, 119, 0.3);
}

/* Features Highlights */
.features-section {
    max-width: 1000px;
    margin: 60px auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    gap: 30px;
    flex-wrap: wrap;
}

.feature-box {
    flex: 1;
    min-width: 280px;
    background: rgba(255, 255, 255, 0.02);
    padding: 25px;
    border-radius: 8px;
    border: 1px solid rgba(254, 254, 254, 0.05);
}

.feature-box span {
    color: #E8C777;
    font-size: 0.85rem;
    font-weight: 600;
    display: block;
    margin-bottom: 8px;
}

.feature-box h4 {
    font-size: 1.1rem;
    margin-bottom: 10px;
    color: #ffffff;
}

.feature-box p {
    font-size: 0.9rem;
    color: #94a3b8;
    line-height: 1.5;
}

/* Footer */
footer {
    text-align: center;
    padding: 25px;
    font-size: 0.85rem;
    color: #64748b;
    border-top: 1px solid rgba(254, 254, 254, 0.05);
    background: #0b0f19;
}
</style>
<link rel="stylesheet" href="css/dark-saas-theme.css">
</head>
<body>

    <!-- Wipe Transition Element -->
    <div class="wipe-curtain" id="wipeCurtain"></div>

    <!-- Header Navigation -->
    <header>
        <div class="brand">Placement<span>Portal</span></div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="student/login.php" class="wipe-link">Student Login</a>
            <a href="admin/login.php" class="wipe-link">Admin Login</a>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-tag">College Placement Cell</div>
        <h1>Your placement journey, organized <span>in one place.</span></h1>
        <p>Track companies, apply to drives, and follow your application status — all from a single dashboard built for students and the placement team.</p>
    </div>

    <!-- Role Cards -->
    <div class="cards-container">
        <!-- Student Card -->
        <div class="role-card">
            <div class="card-icon">S</div>
            <h3>I'm a Student</h3>
            <p>Register, browse eligible drives, apply, and track your application status in real time.</p>
            <a href="student/login.php" class="card-link wipe-link">Go to student login &rarr;</a>
        </div>

        <!-- Admin Card -->
        <div class="role-card">
            <div class="card-icon" style="background:#4f46e5; color:#ffffff;">A</div>
            <h3>I'm the Admin</h3>
            <p>Add companies, schedule drives, review applicants, and shortlist students seamlessly.</p>
            <a href="admin/login.php" class="card-link wipe-link" style="color:#818cf8;">Go to admin login &rarr;</a>
        </div>
    </div>

    <!-- Workflow Section -->
    <div class="workflow-section">
        <div class="workflow-title">How an application moves through the system</div>
        <div class="steps-grid">
            <div class="step-item">
                <div class="step-number">1</div>
                <span>Submitted</span>
            </div>
            <div class="step-item">
                <div class="step-number">2</div>
                <span>Under Review</span>
            </div>
            <div class="step-item">
                <div class="step-number">3</div>
                <span>Shortlisted</span>
            </div>
            <div class="step-item">
                <div class="step-number">4</div>
                <span>Selected</span>
            </div>
        </div>
    </div>

    <!-- Features Highlights -->
    <div class="features-section">
        <div class="feature-box">
            <span>01</span>
            <h4>Live drive listings</h4>
            <p>Every upcoming company drive, with eligibility criteria, shown as soon as the admin adds it.</p>
        </div>
        <div class="feature-box">
            <span>02</span>
            <h4>One-click apply</h4>
            <p>Students apply to a drive in a single click — no forms to fill out again and again.</p>
        </div>
        <div class="feature-box">
            <span>03</span>
            <h4>Status you can trust</h4>
            <p>Application status updates directly from the admin panel, visible to students instantly.</p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        Placement Record Management System &bull; Minor Project &bull; Bhoraniya Safin, Mathakiya Shafik & Ghosiya Karan
    </footer>

    <!-- JavaScript for Right-to-Left Dark Wipe Effect -->
    <script>
        document.querySelectorAll('.wipe-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetUrl = this.getAttribute('href');
                const curtain = document.getElementById('wipeCurtain');
                
                // Trigger right-to-left wipe
                curtain.style.right = '0%';
                curtain.classList.add('active');

                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 500);
            });
        });
    </script>
</body>
</html>
