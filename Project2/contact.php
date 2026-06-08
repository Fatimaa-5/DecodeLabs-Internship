<?php require_once 'config.php';
if($_POST) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $msg = $conn->real_escape_string($_POST['message']);
    $sql = "INSERT INTO contacts (name,email,subject,message) VALUES ('$name','$email','$subject','$msg')";
    if($conn->query($sql)) echo "<script>alert('Message Sent Successfully!'); window.location='contact.php';</script>";
}
include 'header.php';
?>

<style>
.contact-wrapper {
  display: grid;
  grid-template-columns: 1fr 1.5fr 1fr;
  gap: 30px;
  padding: 120px 60px 60px;
  background: #0a0a12;
  color: white;
  min-height: 100vh;
}

.contact-left h1 {
  color: #8b5cf6;
  font-size: 40px;
  margin-bottom: 15px;
}
.contact-left p {
  color: #aaa;
  line-height: 1.6;
  margin-bottom: 40px;
}
.info-item {
  display: flex;
  align-items: center;
  gap: 15px;
  margin-bottom: 25px;
}
.info-icon {
  width: 45px;
  height: 45px;
  background: rgba(139, 92, 246, 0.15);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.info-icon svg {
  width: 22px;
  height: 22px;
  stroke: #8b5cf6;
}
.info-text h4 {
  color: #8b5cf6;
  margin-bottom: 4px;
  font-size: 14px;
}
.info-text p {
  color: #ddd;
  margin: 0;
  font-size: 14px;
}

.contact-form {
  background: #14141f;
  border: 1px solid #222;
  border-radius: 15px;
  padding: 30px;
}
.contact-form h3 {
  margin-bottom: 25px;
  font-size: 20px;
}
.contact-form label {
  display: block;
  color: #aaa;
  font-size: 13px;
  margin-top: 15px;
  margin-bottom: 6px;
}
.contact-form input, 
.contact-form textarea {
  width: 100%;
  padding: 12px;
  background: #0a0a12;
  border: 1px solid #333;
  border-radius: 8px;
  color: white;
  font-size: 14px;
  outline: none;
}
.contact-form input:focus,
.contact-form textarea:focus {
  border-color: #8b5cf6;
}
.btn-send {
  width: 100%;
  padding: 14px;
  margin-top: 20px;
  background: #8b5cf6;
  border: none;
  border-radius: 8px;
  color: white;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}
.btn-send:hover {
  background: #7c3aed;
}

/* MAP BOX - KALA + PURPLE */
.map-box {
  background: #14141f;
  border: 1px solid #222;
  border-radius: 15px;
  height: 200px;
  margin-bottom: 20px;
  overflow: hidden;
  position: relative;
}
.map-box iframe {
  width: 100%;
  height: 100%;
  border: none;
  filter: invert(1) hue-rotate(270deg) brightness(0.8) contrast(1.2) saturate(1.5);
}

.social-box {
  background: #14141f;
  border: 1px solid #222;
  border-radius: 15px;
  padding: 25px;
}
.social-box h4 {
  color: #8b5cf6;
  margin-bottom: 8px;
}
.social-box p {
  color: #aaa;
  font-size: 13px;
  margin-bottom: 15px;
}
.social-icons {
  display: flex;
  gap: 12px;
}
.social-icons a {
  width: 38px;
  height: 38px;
  background: #0a0a12;
  border: 1px solid #333;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.3s;
}
.social-icons a svg {
  width: 18px;
  height: 18px;
  stroke: #aaa;
}
.social-icons a:hover {
  background: #8b5cf6;
  border-color: #8b5cf6;
}
.social-icons a:hover svg {
  stroke: white;
}

@media (max-width: 992px) {
  .contact-wrapper {
    grid-template-columns: 1fr;
    padding: 100px 20px 40px;
  }
}
</style>

<div class="contact-wrapper">

  <!-- LEFT: Contact Info -->
  <div class="contact-left">
    <h1>Contact Us</h1>
    <p>We'd love to hear from you! Reach out to us for any inquiries or support.</p>
    
    <div class="info-item">
      <div class="info-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
          <polyline points="22,6 12,13 2,6"></polyline>
        </svg>
      </div>
      <div class="info-text">
        <h4>Email</h4>
        <p>info@decodelabs.com</p>
      </div>
    </div>

    <div class="info-item">
      <div class="info-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
        </svg>
      </div>
      <div class="info-text">
        <h4>Phone</h4>
        <p>+92 300 1234567</p>
      </div>
    </div>

    <div class="info-item">
      <div class="info-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
          <circle cx="12" cy="10" r="3"></circle>
        </svg>
      </div>
      <div class="info-text">
        <h4>Location</h4>
        <p>Lahore, Pakistan</p>
      </div>
    </div>

    <div class="info-item">
      <div class="info-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"></circle>
          <polyline points="12 6 12 12 16 14"></polyline>
        </svg>
      </div>
      <div class="info-text">
        <h4>Working Hours</h4>
        <p>Mon - Fri: 9:00 AM - 6:00 PM</p>
      </div>
    </div>
  </div>

  <!-- CENTER: Form -->
  <div class="contact-form">
    <h3>Send Us a Message</h3>
    <form method="POST">
      <label>Your Name</label>
      <input type="text" name="name" placeholder="Enter your name" required>
      
      <label>Email Address</label>
      <input type="email" name="email" placeholder="Enter your email" required>
      
      <label>Subject</label>
      <input type="text" name="subject" placeholder="Enter subject" required>
      
      <label>Your Message</label>
      <textarea name="message" rows="5" placeholder="Type your message..." required></textarea>
      
      <button type="submit" class="btn-send">
        Send Message 
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="22" y1="2" x2="11" y2="13"></line>
          <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
        </svg>
      </button>
    </form>
  </div>

  <!-- RIGHT: Map + Social -->
  <div class="contact-right">
    <div class="map-box">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d27219.973982034!2d74.358747!3d31.52037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39190483e58107d9%3A0xc23abe6ccc7e2462!2sLahore%2C%20Punjab%2C%20Pakistan!5e0!3m2!1sen!2s!4v1234567890" loading="lazy"></iframe>
    </div>
    
    <div class="social-box">
      <h4>Stay Connected</h4>
      <p>Follow us on our social media platforms</p>
      <div class="social-icons">
        <a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
        <a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg></a>
        <a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
        <a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg></a>
        <a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13c-4 0-8-4-8-4 8 11 13 1 13 1a7.68 7.68 0 0 0 .18-1.32A4.48 4.48 0 0 0 12 9a4.5 4.5 0 0 0 4.5 4.5"></path></svg></a>
      </div>
    </div>
  </div>

</div>

<?php include 'footer.php'; ?>