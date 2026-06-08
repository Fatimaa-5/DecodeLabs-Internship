<?php include 'header.php'; ?>

<style>
.about-wrapper {
  padding: 120px 60px 60px;
  background: #0a0a12;
  color: white;
  min-height: 100vh;
}

.about-top {
  display: grid;
  grid-template-columns: 1fr 400px;
  gap: 60px;
  align-items: center;
  margin-bottom: 60px;
}

.about-text h1 {
  font-size: 42px;
  font-weight: 700;
  margin-bottom: 20px;
  line-height: 1.2;
}
.about-text h1 span {
  color: #8b5cf6;
}
.about-text p {
  color: #aaa;
  font-size: 16px;
  line-height: 1.8;
  max-width: 550px;
}

/* 3D D LOGO */
.logo-3d {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}
.logo-3d .d-letter {
  font-size: 180px;
  font-weight: 900;
  background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 50%, #6d28d9 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  filter: drop-shadow(0 0 40px rgba(139, 92, 246, 0.5));
  position: relative;
  z-index: 2;
}
.logo-3d::before {
  content: '';
  position: absolute;
  width: 280px;
  height: 280px;
  background: radial-gradient(circle, rgba(139, 92, 246, 0.3) 0%, transparent 70%);
  border-radius: 50%;
  animation: pulse 3s infinite;
}
@keyframes pulse {
 0%, 100% { transform: scale(1); opacity: 0.5; }
 50% { transform: scale(1.1); opacity: 0.8; }
}

/* 3 CARDS */
.cards-row {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 25px;
  margin-bottom: 50px;
}
.mvv-card {
  background: #14141f;
  border: 1px solid #222;
  border-radius: 15px;
  padding: 35px 25px;
  text-align: center;
  transition: 0.3s;
}
.mvv-card:hover {
  border-color: #8b5cf6;
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(139, 92, 246, 0.2);
}
.mvv-icon {
  width: 70px;
  height: 70px;
  margin: 0 auto 20px;
  background: linear-gradient(135deg, rgba(139, 92, 246, 0.2) 0%, rgba(139, 92, 246, 0.1) 100%);
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.mvv-icon svg {
  width: 38px;
  height: 38px;
  stroke: #8b5cf6;
}
.mvv-card h3 {
  font-size: 20px;
  margin-bottom: 12px;
  color: white;
}
.mvv-card p {
  color: #aaa;
  font-size: 14px;
  line-height: 1.6;
}

/* STATS ROW */
.stats-row {
  background: #14141f;
  border: 1px solid #222;
  border-radius: 15px;
  padding: 40px 20px;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
  text-align: center;
}
.stat-item h2 {
  font-size: 36px;
  color: #8b5cf6;
  margin-bottom: 8px;
  font-weight: 700;
}
.stat-item p {
  color: #aaa;
  font-size: 14px;
  margin: 0;
}

@media (max-width: 992px) {
  .about-wrapper { padding: 100px 20px 40px; }
  .about-top { grid-template-columns: 1fr; }
  .logo-3d .d-letter { font-size: 120px; }
  .cards-row { grid-template-columns: 1fr; }
  .stats-row { grid-template-columns: repeat(2, 1fr); }
}
</style>

<div class="about-wrapper">

  <!-- TOP: TEXT + 3D D -->
  <div class="about-top">
    <div class="about-text">
      <h1>About <span>Decode Labs</span></h1>
      <p>We are committed to bridging the gap between learning and industry by providing hands-on experience through real-world projects and mentorship.</p>
    </div>
    
    <div class="logo-3d">
      <div class="d-letter">D</div>
    </div>
  </div>

  <!-- MISSION VISION VALUES CARDS -->
  <div class="cards-row">
    
    <div class="mvv-card">
      <div class="mvv-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"></circle>
          <circle cx="12" cy="12" r="6"></circle>
          <circle cx="12" cy="12" r="2"></circle>
        </svg>
      </div>
      <h3>Our Mission</h3>
      <p>Empower students with practical skills and industry exposure to help them build successful careers.</p>
    </div>

    <div class="mvv-card">
      <div class="mvv-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
          <circle cx="12" cy="12" r="3"></circle>
        </svg>
      </div>
      <h3>Our Vision</h3>
      <p>To be a leading platform that nurtures talent and creates future-ready professionals.</p>
    </div>

    <div class="mvv-card">
      <div class="mvv-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M2.7 10.3a2.4 2.4 0 0 1 3.4 0L12 15.6l5.9-5.3a2.4 2.4 0 0 1 3.4 0 2.4 2.4 0 0 1 0 3.4L12 22l-9.3-8.3a2.4 2.4 0 0 1 0-3.4z"></path>
        </svg>
      </div>
      <h3>Our Values</h3>
      <p>We value innovation, integrity, teamwork, and a passion for continuous learning.</p>
    </div>
    
  </div>

  <!-- STATS ROW - YE WALI MISSING THI -->
  <div class="stats-row">
    <div class="stat-item">
      <h2>500+</h2>
      <p>Interns Trained</p>
    </div>
    <div class="stat-item">
      <h2>20+</h2>
      <p>Expert Mentors</p>
    </div>
    <div class="stat-item">
      <h2>100+</h2>
      <p>Projects Completed</p>
    </div>
    <div class="stat-item">
      <h2>10+</h2>
      <p>Industry Partners</p>
    </div>
  </div>

</div>

<?php include 'footer.php'; ?>