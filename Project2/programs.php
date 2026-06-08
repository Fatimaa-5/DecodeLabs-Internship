<?php require_once 'config.php';

$user_id = $_SESSION['user_id']?? 0;
$user_name = $_SESSION['name']?? '';
$user_email = '';
if($user_id) {
    $res = $conn->query("SELECT email FROM users WHERE id=$user_id");
    $user_email = $res->fetch_assoc()['email']?? '';
}

// Form submit hua to database mein save
if($_POST && isset($_POST['apply'])) {
    $uid = $conn->real_escape_string($_POST['user_id']);
    $course = $conn->real_escape_string($_POST['course']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $msg = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO applications (user_id, course, name, email, phone, message)
            VALUES ('$uid', '$course', '$name', '$email', '$phone', '$msg')";
    if($conn->query($sql)) {
        echo "<script>alert('Application Submitted Successfully!'); window.location='programs.php';</script>";
    }
}
include 'header.php';
?>

<style>
.programs-wrapper {
  display: grid;
  grid-template-columns: 250px 1fr;
  gap: 40px;
  padding: 120px 60px 60px;
  background: #0a0a12;
  color: white;
  min-height: 100vh;
}

.programs-header h1 {
  font-size: 36px;
  margin-bottom: 8px;
}
.programs-header p {
  color: #aaa;
  margin-bottom: 40px;
}

/* LEFT SIDEBAR */
.sidebar {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.sidebar-btn {
  padding: 14px 18px;
  background: #14141f;
  border: none;
  border-radius: 10px;
  color: #aaa;
  text-align: left;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 12px;
  transition: 0.3s;
  font-size: 14px;
}
.sidebar-btn.active {
  background: #8b5cf6;
  color: white;
}
.sidebar-btn:hover {
  background: #1e1e2f;
}
.sidebar-btn svg {
  width: 18px;
  height: 18px;
  stroke: currentColor;
  fill: none;
}

/* CARDS GRID */
.cards-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 25px;
}
.card {
  background: #14141f;
  border: 1px solid #222;
  border-radius: 15px;
  padding: 30px 25px;
  text-align: center;
  transition: 0.3s;
}
.card:hover {
  border-color: #8b5cf6;
  transform: translateY(-5px);
  box-shadow: 0 0 20px rgba(139, 92, 246, 0.2);
}
.card-icon {
  width: 70px;
  height: 70px;
  margin: 0 auto 20px;
  background: rgba(139, 92, 246, 0.1);
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.card-icon svg {
  width: 35px;
  height: 35px;
  stroke: #8b5cf6;
}
.card h3 {
  font-size: 18px;
  margin-bottom: 12px;
}
.card p {
  color: #aaa;
  font-size: 14px;
  line-height: 1.6;
  margin-bottom: 20px;
  min-height: 60px;
}
.btn-apply {
  background: #8b5cf6;
  color: white;
  border: none;
  padding: 10px 25px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: 0.3s;
}
.btn-apply:hover {
  background: #7c3aed;
  transform: scale(1.05);
}

/* POPUP FORM */
.modal {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.85);
  backdrop-filter: blur(5px);
  z-index: 9999;
  align-items: center;
  justify-content: center;
}
.modal.show {
  display: flex;
}
.modal-content {
  background: #14141f;
  border: 1px solid #333;
  border-radius: 15px;
  padding: 30px;
  width: 420px;
  max-width: 90%;
}
.modal-content h3 {
  margin-bottom: 20px;
  color: #8b5cf6;
  font-size: 22px;
}
.modal-content label {
  display: block;
  color: #aaa;
  font-size: 13px;
  margin-top: 12px;
  margin-bottom: 5px;
}
.modal-content input,
.modal-content textarea {
  width: 100%;
  padding: 10px;
  background: #0a0a12;
  border: 1px solid #333;
  border-radius: 8px;
  color: white;
  font-size: 14px;
  outline: none;
}
.modal-content input:focus,
.modal-content textarea:focus {
  border-color: #8b5cf6;
}
.modal-content input[readonly] {
  background: #1a1a2a;
  color: #8b5cf6;
  font-weight: 600;
}
.close-btn {
  float: right;
  font-size: 28px;
  cursor: pointer;
  color: #aaa;
  line-height: 1;
}
.close-btn:hover {
  color: white;
}

@media (max-width: 992px) {
.programs-wrapper {
    grid-template-columns: 1fr;
    padding: 100px 20px 40px;
  }
.cards-grid {
    grid-template-columns: 1fr;
  }
}
</style>

<div class="programs-wrapper">

  <!-- LEFT SIDEBAR -->
  <div class="sidebar">
    <button class="sidebar-btn active">
      <svg viewBox="0 0 24 24" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
      All Programs
    </button>
    <button class="sidebar-btn">
      <svg viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
      Web Development
    </button>
    <button class="sidebar-btn">
      <svg viewBox="0 0 24 24" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"></rect><line x1="12" y1="18" x2="12" y2="18"></line></svg>
      Mobile Development
    </button>
    <button class="sidebar-btn">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M12 19l7-7 3 3-7 7-3-3z"></path><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path></svg>
      UI/UX Design
    </button>
    <button class="sidebar-btn">
      <svg viewBox="0 0 24 24" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
      Data Science
    </button>
    <button class="sidebar-btn">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
      Cyber Security
    </button>
  </div>

  <!-- RIGHT CARDS -->
  <div>
    <div class="programs-header">
      <h1>Our Internship Programs</h1>
      <p>Choose a program that aligns with your passion and career goals.</p>
    </div>

    <div class="cards-grid">

      <div class="card">
        <div class="card-icon">
          <svg viewBox="0 0 24 24" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
        </div>
        <h3>Full Stack Development</h3>
        <p>Learn front-end and back-end technologies and build complete web applications.</p>
        <button class="btn-apply" onclick="openModal('Full Stack Development')">Apply Now →</button>
      </div>

      <div class="card">
        <div class="card-icon">
          <svg viewBox="0 0 24 24" stroke-width="2"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
        </div>
        <h3>Frontend Development</h3>
        <p>Master HTML, CSS, JavaScript and modern frameworks to build stunning websites.</p>
        <button class="btn-apply" onclick="openModal('Frontend Development')">Apply Now →</button>
      </div>

      <div class="card">
        <div class="card-icon">
          <svg viewBox="0 0 24 24" stroke-width="2"><path d="M12 19l7-7 3 3-7 7-3-3z"></path><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path></svg>
        </div>
        <h3>UI/UX Design</h3>
        <p>Design intuitive and user-friendly interfaces with industry-standard tools.</p>
        <button class="btn-apply" onclick="openModal('UI/UX Design')">Apply Now →</button>
      </div>

      <div class="card">
        <div class="card-icon">
          <svg viewBox="0 0 24 24" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"></rect><line x1="12" y1="18" x2="12" y2="18"></line></svg>
        </div>
        <h3>Mobile App Development</h3>
        <p>Build Android and iOS applications using modern technologies.</p>
        <button class="btn-apply" onclick="openModal('Mobile App Development')">Apply Now →</button>
      </div>

      <div class="card">
        <div class="card-icon">
          <svg viewBox="0 0 24 24" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
        </div>
        <h3>Data Science</h3>
        <p>Analyze data and build machine learning models to solve real-world problems.</p>
        <button class="btn-apply" onclick="openModal('Data Science')">Apply Now →</button>
      </div>

      <div class="card">
        <div class="card-icon">
          <svg viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
        </div>
        <h3>Cyber Security</h3>
        <p>Learn ethical hacking and security techniques to protect systems and data.</p>
        <button class="btn-apply" onclick="openModal('Cyber Security')">Apply Now →</button>
      </div>

    </div>
  </div>
</div>

<!-- POPUP FORM -->
<div class="modal" id="applyModal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h3>Apply for Internship</h3>
    <form method="POST">
      <input type="hidden" name="user_id" value="<?php echo $user_id;?>">

      <label>Selected Course</label>
      <input type="text" name="course" id="courseField" readonly>

      <label>Your Name</label>
      <input type="text" name="name" value="<?php echo $user_name;?>" required>

      <label>Email</label>
      <input type="email" name="email" value="<?php echo $user_email;?>" required>

      <label>Phone</label>
      <input type="text" name="phone" placeholder="03XX-XXXXXXX" required>

      <label>Why you want to join?</label>
      <textarea name="message" rows="3" placeholder="Tell us about yourself..." required></textarea>

      <button type="submit" name="apply" class="btn-apply" style="width:100%; margin-top:15px;">Submit Application</button>
    </form>
  </div>
</div>

<script>
function openModal(courseName) {
  document.getElementById('applyModal').classList.add('show');
  document.getElementById('courseField').value = courseName;
}
function closeModal() {
  document.getElementById('applyModal').classList.remove('show');
}
// ESC key se bhi band ho jaye
document.addEventListener('keydown', function(e) {
  if(e.key === 'Escape') closeModal();
});
</script>

<?php include 'footer.php';?>