<?php 
session_start();
require_once 'config.php';
if(!isset($_SESSION['admin'])) {
  header('Location: admin_login.php');
  exit();
}

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'applications';

// DELETE
if(isset($_GET['delete']) && isset($_GET['type'])) {
    $id = intval($_GET['delete']);
    $type = $_GET['type'];
    $conn->query("DELETE FROM $type WHERE id=$id");
    header("Location: admin_dashboard.php?tab=$tab");
    exit();
}

// UPDATE - Edit karke save
if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];
    
    if($type == 'applications') {
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $course = $conn->real_escape_string($_POST['course']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $message = $conn->real_escape_string($_POST['message']);
        $conn->query("UPDATE applications SET name='$name', email='$email', course='$course', phone='$phone', message='$message' WHERE id=$id");
    }
    
    if($type == 'users') {
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$id");
    }
    
    if($type == 'contacts') {
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $subject = $conn->real_escape_string($_POST['subject']);
        $message = $conn->real_escape_string($_POST['message']);
        $conn->query("UPDATE contacts SET name='$name', email='$email', subject='$subject', message='$message' WHERE id=$id");
    }
    
    header("Location: admin_dashboard.php?tab=$type");
    exit();
}

// EDIT FORM SHOW
$edit_data = null;
$edit_type = null;
if(isset($_GET['edit']) && isset($_GET['type'])) {
    $id = intval($_GET['edit']);
    $edit_type = $_GET['type'];
    $edit_data = $conn->query("SELECT * FROM $edit_type WHERE id=$id")->fetch_assoc();
}

// Stats
$stats = [
    'applications' => $conn->query("SELECT COUNT(*) as c FROM applications")->fetch_assoc()['c'],
    'users' => $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'],
    'contacts' => $conn->query("SELECT COUNT(*) as c FROM contacts")->fetch_assoc()['c']
];

// Data fetch based on tab
$data = $conn->query("SELECT * FROM $tab ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Panel - DecodeLabs</title>
<style>
* {margin:0; padding:0; box-sizing:border-box;}
body {
  background: #0a0a12;
  color: white;
  font-family: Arial, sans-serif;
  padding: 40px;
}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 40px;
  padding-bottom: 20px;
  border-bottom: 1px solid #222;
}
.header h1 {color: #8b5cf6; font-size: 32px;}
.header h1 span {color: white;}
.logout {
  background: #ff4d4d;
  padding: 12px 25px;
  border-radius: 10px;
  color: white;
  text-decoration: none;
  font-weight: 600;
}
.logout:hover {background: #e63939;}

/* TABS */
.tabs {
  display: flex;
  gap: 15px;
  margin-bottom: 30px;
  border-bottom: 2px solid #222;
  padding-bottom: 15px;
}
.tab {
  padding: 12px 25px;
  background: #14141f;
  border: 1px solid #333;
  border-radius: 10px;
  color: #aaa;
  text-decoration: none;
  font-weight: 600;
  transition: 0.3s;
}
.tab.active {
  background: #8b5cf6;
  border-color: #8b5cf6;
  color: white;
}
.tab:hover {border-color: #8b5cf6;}

/* STATS */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-bottom: 40px;
}
.stat-card {
  background: #14141f;
  border: 1px solid #222;
  border-radius: 15px;
  padding: 25px;
  text-align: center;
}
.stat-card h3 {
  color: #aaa;
  font-size: 13px;
  margin-bottom: 8px;
  text-transform: uppercase;
}
.stat-card h2 {
  color: #8b5cf6;
  font-size: 36px;
  font-weight: 700;
}

/* EDIT FORM */
.edit-form {
  background: #14141f;
  border: 2px solid #8b5cf6;
  border-radius: 15px;
  padding: 30px;
  margin-bottom: 30px;
}
.edit-form h3 {
  color: #8b5cf6;
  margin-bottom: 20px;
  font-size: 22px;
}
.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 15px;
}
.edit-form label {
  display: block;
  color: #aaa;
  font-size: 13px;
  margin-bottom: 6px;
  margin-top: 10px;
}
.edit-form input, .edit-form textarea {
  width: 100%;
  padding: 12px;
  background: #0a0a12;
  border: 1px solid #333;
  border-radius: 8px;
  color: white;
  outline: none;
}
.edit-form input:focus, .edit-form textarea:focus {border-color: #8b5cf6;}
.btn-group {
  display: flex;
  gap: 10px;
  margin-top: 20px;
}
.btn-save {
  padding: 12px 30px;
  background: #8b5cf6;
  border: none;
  border-radius: 8px;
  color: white;
  font-weight: 600;
  cursor: pointer;
}
.btn-cancel {
  padding: 12px 30px;
  background: #333;
  border: none;
  border-radius: 8px;
  color: white;
  text-decoration: none;
  font-weight: 600;
}

/* TABLE */
.table-box {
  background: #14141f;
  border: 1px solid #222;
  border-radius: 15px;
  padding: 30px;
  overflow-x: auto;
}
.table-box h2 {
  margin-bottom: 25px;
  color: #8b5cf6;
}
table {
  width: 100%;
  border-collapse: collapse;
  min-width: 800px;
}
th {
  background: #8b5cf6;
  padding: 15px;
  text-align: left;
  font-weight: 600;
  font-size: 12px;
  text-transform: uppercase;
}
td {
  padding: 15px;
  border-bottom: 1px solid #222;
  font-size: 13px;
}
tr:hover {background: #1a1a2a;}

.btn-edit {
  background: #8b5cf6;
  color: white;
  padding: 6px 12px;
  border-radius: 6px;
  text-decoration: none;
  font-size: 12px;
  margin-right: 5px;
}
.btn-del {
  background: #ff4d4d;
  color: white;
  padding: 6px 12px;
  border-radius: 6px;
  text-decoration: none;
  font-size: 12px;
}

.no-data {
  text-align: center;
  padding: 50px;
  color: #666;
}

@media (max-width: 992px) {
  body {padding: 20px;}
  .stats-grid {grid-template-columns: 1fr;}
  .form-grid {grid-template-columns: 1fr;}
  .tabs {flex-wrap: wrap;}
}
</style>
</head>
<body>

<div class="header">
  <h1>Admin <span>Panel</span></h1>
  <a href="logout_admin.php" class="logout">Logout</a>
</div>

<!-- TABS -->
<div class="tabs">
  <a href="?tab=applications" class="tab <?php echo $tab=='applications'?'active':'';?>">
    Applications (<?php echo $stats['applications'];?>)
  </a>
  <a href="?tab=users" class="tab <?php echo $tab=='users'?'active':'';?>">
    Users (<?php echo $stats['users'];?>)
  </a>
  <a href="?tab=contacts" class="tab <?php echo $tab=='contacts'?'active':'';?>">
    Contact Messages (<?php echo $stats['contacts'];?>)
  </a>
</div>

<!-- STATS -->
<div class="stats-grid">
  <div class="stat-card">
    <h3>Total Applications</h3>
    <h2><?php echo $stats['applications'];?></h2>
  </div>
  <div class="stat-card">
    <h3>Registered Users</h3>
    <h2><?php echo $stats['users'];?></h2>
  </div>
  <div class="stat-card">
    <h3>Contact Messages</h3>
    <h2><?php echo $stats['contacts'];?></h2>
  </div>
</div>

<!-- EDIT FORM -->
<?php if($edit_data) { ?>
<div class="edit-form">
  <h3>Edit <?php echo ucfirst($edit_type);?></h3>
  <form method="POST">
    <input type="hidden" name="id" value="<?php echo $edit_data['id'];?>">
    <input type="hidden" name="type" value="<?php echo $edit_type;?>">
    
    <div class="form-grid">
      <div>
        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($edit_data['name']);?>" required>
      </div>
      <div>
        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($edit_data['email']);?>" required>
      </div>
      
      <?php if($edit_type == 'applications') { ?>
      <div>
        <label>Course</label>
        <input type="text" name="course" value="<?php echo htmlspecialchars($edit_data['course']);?>" required>
      </div>
      <div>
        <label>Phone</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($edit_data['phone']);?>" required>
      </div>
      <div style="grid-column: span 2;">
        <label>Message</label>
        <textarea name="message" rows="4" required><?php echo htmlspecialchars($edit_data['message']);?></textarea>
      </div>
      <?php } ?>
      
      <?php if($edit_type == 'contacts') { ?>
      <div style="grid-column: span 2;">
        <label>Subject</label>
        <input type="text" name="subject" value="<?php echo htmlspecialchars($edit_data['subject']);?>" required>
      </div>
      <div style="grid-column: span 2;">
        <label>Message</label>
        <textarea name="message" rows="4" required><?php echo htmlspecialchars($edit_data['message']);?></textarea>
      </div>
      <?php } ?>
    </div>
    
    <div class="btn-group">
      <button type="submit" name="update" class="btn-save">Save Changes</button>
      <a href="?tab=<?php echo $tab;?>" class="btn-cancel">Cancel</a>
    </div>
  </form>
</div>
<?php } ?>

<!-- DATA TABLE -->
<div class="table-box">
  <h2><?php echo ucfirst($tab);?> Data</h2>
  
  <?php if($data->num_rows > 0) { ?>
  <table>
    <tr>
      <th>ID</th>
      <?php if($tab == 'applications' || $tab == 'users' || $tab == 'contacts') echo '<th>Name</th><th>Email</th>'; ?>
      <?php if($tab == 'applications') echo '<th>Course</th><th>Phone</th><th>Message</th>'; ?>
      <?php if($tab == 'contacts') echo '<th>Subject</th><th>Message</th>'; ?>
      <?php if($tab == 'applications' || $tab == 'contacts') echo '<th>Date</th>'; ?>
      <th>Action</th>
    </tr>
    
    <?php while($row = $data->fetch_assoc()) { ?>
    <tr>
      <td>#<?php echo $row['id'];?></td>
      
      <?php if($tab == 'applications' || $tab == 'users' || $tab == 'contacts') { ?>
      <td><?php echo htmlspecialchars($row['name']);?></td>
      <td><?php echo htmlspecialchars($row['email']);?></td>
      <?php } ?>
      
      <?php if($tab == 'applications') { ?>
      <td style="color:#8b5cf6; font-weight:600;"><?php echo htmlspecialchars($row['course']);?></td>
      <td><?php echo htmlspecialchars($row['phone']);?></td>
      <td><?php echo substr(htmlspecialchars($row['message']), 0, 40);?>...</td>
      <?php } ?>
      
      <?php if($tab == 'contacts') { ?>
      <td><?php echo htmlspecialchars($row['subject']);?></td>
      <td><?php echo substr(htmlspecialchars($row['message']), 0, 40);?>...</td>
      <?php } ?>
      
      <?php if($tab == 'applications' || $tab == 'contacts') { ?>
      <td><?php echo date('d M Y', strtotime($row['applied_at'] ?? $row['sent_at']));?></td>
      <?php } ?>
      
      <td>
        <a href="?tab=<?php echo $tab;?>&edit=<?php echo $row['id'];?>&type=<?php echo $tab;?>" class="btn-edit">Edit</a>
        <a href="?tab=<?php echo $tab;?>&delete=<?php echo $row['id'];?>&type=<?php echo $tab;?>" class="btn-del" onclick="return confirm('Delete this record?')">Delete</a>
      </td>
    </tr>
    <?php } ?>
  </table>
  <?php } else { ?>
  <div class="no-data">No data found in <?php echo $tab;?> table.</div>
  <?php } ?>
</div>

</body>
</html>