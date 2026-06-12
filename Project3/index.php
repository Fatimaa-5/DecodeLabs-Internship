<?php
session_start();
include 'db.php';

$page = isset($_GET['page'])? $_GET['page'] : 'dashboard';
$search = isset($_GET['search'])? $_GET['search'] : '';
$filter = isset($_GET['filter'])? $_GET['filter'] : 'all';

// Anime query
$query = "SELECT * FROM anime WHERE 1=1";
if($search!= '') $query.= " AND title LIKE '%$search%'";
if($filter!= 'all') $query.= " AND status = '$filter'";
$query.= " ORDER BY added_date DESC";
$result = mysqli_query($conn, $query);

// Stats
$total = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM anime"));
$watching = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM anime WHERE status='watching'"));
$completed = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM anime WHERE status='completed'"));
$onhold = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM anime WHERE status='onhold'"));
$dropped = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM anime WHERE status='dropped'"));

// Settings
$set = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM settings WHERE id=1"));

// Notifications
$notif = mysqli_query($conn, "SELECT * FROM notifications ORDER BY created_at DESC LIMIT 5");
$notif_count = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM notifications WHERE is_read=0"));
?>
<!DOCTYPE html>
<html>
<head>
<title>Anime Watchlist Tracker</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
body{
  background: linear-gradient(rgba(10,10,10,0.6), rgba(10,10,10,0.6)),
              url('uploads/img1.jpeg') no-repeat center fixed;
  background-size: cover;
  color:#fff;
  display:flex;
  min-height:100vh;
}

.sidebar{
  width:260px;
  background: rgba(17,17,17,0.85);
  backdrop-filter: blur(10px);
  border-right:2px solid #E10600;
  position:fixed;
  height:100vh;
  overflow-y:auto;
  transition:0.3s;
  z-index:100;
}
.sidebar h2{padding:25px 20px;color:#E10600;font-size:28px;border-bottom:1px solid #333}
.sidebar a{display:flex;align-items:center;gap:12px;padding:15px 20px;color:#aaa;text-decoration:none;transition:0.3s;font-size:15px}
.sidebar a.active,.sidebar a:hover{background:#E10600;color:#fff}
.sidebar i{width:20px;text-align:center}

.main{
  margin-left:260px;
  padding:25px;
  width:calc(100% - 260px);
  transition:0.3s;
}

.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;flex-wrap:wrap;gap:15px}
.search-box{display:flex;gap:8px}
.search-box input{padding:10px 15px;border-radius:8px;border:1px solid #333;background:#1a1a1a;color:#fff;width:280px}
.btn-red{background:#E10600;border:none;padding:10px 20px;border-radius:8px;color:#fff;cursor:pointer;font-weight:600}
.btn-red:hover{background:#ff1a1a}

.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:15px;margin-bottom:30px}
.card{
  background: rgba(26,26,26,0.6);
  backdrop-filter: blur(8px);
  padding:20px;
  border-radius:12px;
  border:1px solid #333;
}
.card h3{color:#888;font-size:14px;margin-bottom:8px}
.card h2{color:#E10600;font-size:32px}

.anime-list{
  background: rgba(26,26,26,0.6);
  backdrop-filter: blur(8px);
  padding:20px;
  border-radius:12px;
}

.anime-list input,.anime-list select{
  background: #0a0a0a;
  border: 2px solid #333;
  border-radius: 8px;
  color: #fff;
  transition: 0.3s;
}
.anime-list input:focus,.anime-list select:focus{
  border-color: #E10600;
  outline: none;
  box-shadow: 0 0 10px rgba(225,6,0,0.3);
}

.anime-item{
  display:flex;
  gap:15px;
  padding:15px;
  border-bottom:1px solid #333;
  align-items:center;
  flex-wrap:nowrap;
}
.anime-item img{
  width:60px;
  height:80px;
  border-radius:8px;
  object-fit:cover;
  flex-shrink:0;
}
.anime-item > div:nth-child(2){flex:1;min-width:150px}
.anime-item > div:nth-child(3){white-space:nowrap}
.anime-item > div:nth-child(4){
  display:flex;
  gap:12px;
  margin-left:15px;
  flex-shrink:0;
}
.anime-item > div:nth-child(4) a{
  font-size:18px;
  padding:5px;
  text-decoration:none;
}

.status{padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600}
.status.watching{background:#ff4444}
.status.completed{background:#00c851}
.status.onhold{background:#ffbb33}
.status.dropped{background:#666}

.modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.9);justify-content:center;align-items:center;z-index:999}
.modal-content{background:#1a1a1a;padding:30px;border-radius:12px;width:90%;max-width:500px;border:2px solid #E10600}
.modal-content input,.modal-content select{width:100%;padding:12px;margin:8px 0;border-radius:6px;border:1px solid #333;background:#0a0a0a;color:#fff}

.filter-tabs a{color:#888;margin-right:15px;text-decoration:none;padding:8px 12px;border-radius:6px}
.filter-tabs a.active{background:#E10600;color:#fff}
.section{display:none}
.section.active{display:block}
.notif-dropdown{display:none;position:absolute;right:0;top:40px;background:#1a1a1a;border:1px solid #333;border-radius:8px;width:280px;max-height:300px;overflow-y:auto;padding:10px}

.menu-toggle{
  display:none;
  position:fixed;
  top:20px;
  left:20px;
  background:#E10600;
  border:none;
  color:#fff;
  font-size:24px;
  padding:8px 12px;
  border-radius:8px;
  cursor:pointer;
  z-index:999;
}

@media(max-width:768px){
.sidebar{width:70px}
.sidebar a span,.sidebar h2{display:none}
.main{margin-left:70px;width:calc(100% - 70px);padding:15px}
.search-box input{width:150px}
.stats{grid-template-columns:repeat(2,1fr)}
.anime-item{flex-wrap:wrap}
.anime-item > div:nth-child(4){margin-left:75px;margin-top:10px}
@media(max-width:500px){
.menu-toggle{display:block}
.sidebar{left:-260px}
.sidebar.active{left:0}
.main{margin-left:0;width:100%;padding-top:70px}
.stats{grid-template-columns:1fr}
</style>
</head>
<body>

<button class="menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>

<div class="sidebar">
  <h2><i class="fas fa-tv"></i> ANIME</h2>
  <a href="?page=dashboard" class="<?php echo $page=='dashboard'?'active':''?>"><i class="fas fa-home"></i> <span>Dashboard</span></a>
  <a href="?page=watchlist" class="<?php echo $page=='watchlist'?'active':''?>"><i class="fas fa-list"></i> <span>My Watchlist</span></a>
  <a href="#" onclick="openModal('add')"><i class="fas fa-plus"></i> <span>Add Anime</span></a>
  <a href="?page=genres" class="<?php echo $page=='genres'?'active':''?>"><i class="fas fa-mask"></i> <span>Genres</span></a>
  <a href="?page=settings" class="<?php echo $page=='settings'?'active':''?>"><i class="fas fa-gear"></i> <span>Settings</span></a>
</div>

<div class="main">
  <!-- DASHBOARD -->
  <div class="section <?php echo $page=='dashboard'?'active':''?>">
    <div class="topbar">
      <form class="search-box" method="GET">
        <input type="hidden" name="page" value="<?php echo $page;?>">
        <input type="text" name="search" placeholder="Search anime..." value="<?php echo $search;?>">
        <button class="btn-red" type="submit"><i class="fas fa-search"></i></button>
      </form>
      <div style="display:flex;gap:20px;align-items:center;position:relative">
        <div style="cursor:pointer" onclick="toggleNotif()">
          <i class="fas fa-bell"></i> <span style="background:red;border-radius:50%;padding:2px 6px;font-size:12px"><?php echo $notif_count;?></span>
          <div class="notif-dropdown" id="notifBox">
            <?php while($n=mysqli_fetch_assoc($notif)){ echo "<p style='padding:8px;border-bottom:1px solid #333;font-size:13px'>".$n['message']."</p>"; }?>
          </div>
        </div>
        <div style="display:flex;gap:10px;align-items:center;cursor:pointer">
          <img src="<?php echo $set['profile_pic'] && file_exists($set['profile_pic'])? $set['profile_pic'] : 'https://ui-avatars.com/api/?name='.urlencode($set['username']).'&background=E10600&color=fff&size=40';?>"
               style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid #E10600">
          <span><?php echo $set['username'];?></span> <i class="fas fa-chevron-down"></i>
        </div>
      </div>
    </div>

    <h1>Welcome back, <span style="color:#E10600">Anime Fan!</span> <i class="fas fa-fire" style="color:#ff4444"></i></h1>
    <p style="color:#888;margin-bottom:25px">Track. Watch. Enjoy. Repeat.</p>

    <div class="stats">
      <div class="card"><h3><i class="fas fa-tv"></i> Total Anime</h3><h2><?php echo $total;?></h2><small>Shows in list</small></div>
      <div class="card"><h3><i class="fas fa-play"></i> Watching</h3><h2><?php echo $watching;?></h2><small>Currently watching</small></div>
      <div class="card"><h3><i class="fas fa-check-circle"></i> Completed</h3><h2><?php echo $completed;?></h2><small>Amazing anime</small></div>
      <div class="card"><h3><i class="fas fa-pause"></i> On Hold</h3><h2><?php echo $onhold;?></h2><small>Paused for now</small></div>
      <div class="card"><h3><i class="fas fa-times-circle"></i> Dropped</h3><h2><?php echo $dropped;?></h2><small>Not for me</small></div>
    </div>

    <h2 style="margin:25px 0 15px"><i class="fas fa-clock"></i> Recently Added</h2>
    <div class="anime-list">
      <?php $recent = mysqli_query($conn, "SELECT * FROM anime ORDER BY added_date DESC LIMIT 4");
      while($r=mysqli_fetch_assoc($recent)){?>
      <div class="anime-item">
        <img src="<?php echo!empty($r['image_url']) && file_exists($r['image_url'])? $r['image_url'] : 'https://via.placeholder.com/60x80/1a1a1a/E10600?text=No+Img';?>">
        <div style="flex:1">
          <h4><?php echo $r['title'];?></h4>
          <small style="color:#888"><i class="fas fa-calendar"></i> <?php echo date('j M Y', strtotime($r['added_date']));?></small>
        </div>
      </div>
      <?php }?>
    </div>
  </div>

  <!-- WATCHLIST -->
  <div class="section <?php echo $page=='watchlist'?'active':''?>">
    <div style="display:flex;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:15px">
      <h2><i class="fas fa-list"></i> My Watchlist</h2>
      <button class="btn-red" onclick="openModal('add')"><i class="fas fa-plus"></i> Add Anime</button>
    </div>

    <div class="filter-tabs" style="margin-bottom:15px">
      <a href="?page=watchlist&filter=all" class="<?php echo $filter=='all'?'active':''?>">All (<?php echo $total;?>)</a>
      <a href="?page=watchlist&filter=watching" class="<?php echo $filter=='watching'?'active':''?>">Watching (<?php echo $watching;?>)</a>
      <a href="?page=watchlist&filter=completed" class="<?php echo $filter=='completed'?'active':''?>">Completed (<?php echo $completed;?>)</a>
      <a href="?page=watchlist&filter=onhold" class="<?php echo $filter=='onhold'?'active':''?>">On Hold (<?php echo $onhold;?>)</a>
      <a href="?page=watchlist&filter=dropped" class="<?php echo $filter=='dropped'?'active':''?>">Dropped (<?php echo $dropped;?>)</a>
    </div>

    <div class="anime-list">
      <?php if(mysqli_num_rows($result)==0) echo "<p style='text-align:center;padding:40px;color:#666'>No anime found</p>";
      while($row = mysqli_fetch_assoc($result)){?>
      <div class="anime-item">
        <img src="<?php echo!empty($row['image_url']) && file_exists($row['image_url'])? $row['image_url'] : 'https://via.placeholder.com/60x80/1a1a1a/E10600?text=No+Img';?>">
        <div>
          <h3><?php echo $row['title'];?></h3>
          <p style="color:#888;font-size:13px"><i class="fas fa-tags"></i> <?php echo $row['genres'];?></p>
          <p style="color:#888;font-size:12px"><i class="fas fa-calendar"></i> <?php echo $row['episodes_watched'];?> / <?php echo $row['total_episodes'];?> Episodes</p>
        </div>
        <div>
          <span class="status <?php echo $row['status'];?>"><?php echo strtoupper($row['status']);?></span>
          <span style="color:#FFD700;margin-left:10px"><i class="fas fa-star"></i> <?php echo $row['rating'];?></span>
        </div>
        <div>
          <a href="#" onclick="openModal('edit',<?php echo $row['id'];?>,'<?php echo addslashes($row['title']);?>','<?php echo addslashes($row['genres']);?>',<?php echo $row['episodes_watched'];?>,<?php echo $row['total_episodes'];?>,<?php echo $row['rating'];?>,'<?php echo $row['image_url'];?>','<?php echo $row['status'];?>')" style="color:#E10600"><i class="fas fa-edit"></i></a>
          <a href="delete.php?id=<?php echo $row['id'];?>" onclick="return confirm('Delete this anime?')" style="color:red"><i class="fas fa-trash"></i></a>
        </div>
      </div>
      <?php }?>
    </div>
  </div>

  <!-- GENRES -->
  <div class="section <?php echo $page=='genres'?'active':''?>">
    <h2><i class="fas fa-mask"></i> Top Genres</h2>
    <div class="anime-list" style="margin-top:20px">
      <?php $genres = mysqli_query($conn, "SELECT genres, COUNT(*) as c FROM anime GROUP BY genres ORDER BY c DESC LIMIT 5");
      while($g=mysqli_fetch_assoc($genres)){?>
      <div class="anime-item">
        <div style="flex:1">
          <h4><i class="fas fa-tag"></i> <?php echo $g['genres']?: 'Unknown';?></h4>
          <div style="background:#333;height:6px;border-radius:3px;margin-top:5px">
            <div style="background:#E10600;width:<?php echo $g['c']*10;?>%;height:100%;border-radius:3px"></div>
          </div>
        </div>
        <h3><?php echo $g['c'];?></h3>
      </div>
      <?php }?>
    </div>
  </div>

  <!-- SETTINGS -->
  <div class="section <?php echo $page=='settings'?'active':''?>">
    <h2><i class="fas fa-gear"></i> Settings</h2>
    <?php if(isset($_GET['saved'])) echo "<p style='color:#00c851;margin-bottom:15px'><i class='fas fa-check'></i> Settings saved successfully!</p>";?>

    <div class="anime-list" style="margin-top:20px;max-width:700px;padding:40px">
      <form action="settings.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="old_pic" value="<?php echo $set['profile_pic'];?>">

        <div style="text-align:center;margin-bottom:35px">
          <img src="<?php echo $set['profile_pic'] && file_exists($set['profile_pic'])? $set['profile_pic'] : 'https://ui-avatars.com/api/?name='.urlencode($set['username']).'&background=E10600&color=fff&size=128';?>"
               id="previewPic"
               style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:4px solid #E10600;margin-bottom:15px">
          <br>
          <label class="btn-red" style="cursor:pointer;display:inline-block">
            <i class="fas fa-camera"></i> Change Profile Picture
            <input type="file" name="profile_pic" accept="image/*" style="display:none" onchange="previewImage(event)">
          </label>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">
          <div>
            <label style="display:block;margin-bottom:8px;font-weight:600"><i class="fas fa-user"></i> Username</label>
            <input type="text" name="username" value="<?php echo $set['username'];?>" required style="width:100%;padding:14px;font-size:15px">
          </div>
          <div>
            <label style="display:block;margin-bottom:8px;font-weight:600"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" name="email" value="<?php echo $set['email'];?>" style="width:100%;padding:14px;font-size:15px">
          </div>
        </div>

        <div style="margin-bottom:25px">
          <label style="display:block;margin-bottom:8px;font-weight:600"><i class="fas fa-palette"></i> Theme Color</label>
          <select name="theme" style="width:100%;padding:14px;font-size:15px">
            <option value="dark" <?php echo $set['theme']=='dark'?'selected':''?>>🔴 Dark Red - Anime Vibe</option>
            <option value="blue" <?php echo $set['theme']=='blue'?'selected':''?>>🔵 Dark Blue</option>
            <option value="purple" <?php echo $set['theme']=='purple'?'selected':''?>>🟣 Purple Night</option>
          </select>
        </div>

        <button type="submit" class="btn-red" style="width:100%;padding:15px;font-size:16px">
          <i class="fas fa-save"></i> Save All Settings
        </button>
      </form>
    </div>
  </div>
</div>

<!-- ADD/EDIT MODAL -->
<div class="modal" id="animeModal">
  <div class="modal-content">
    <h2 id="modalTitle"><i class="fas fa-plus"></i> Add New Anime</h2>
    <form id="animeForm" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" id="animeId">
      <input name="title" id="title" placeholder="Anime Title" required>
      <input name="genres" id="genres" placeholder="Genres: Action, Fantasy">
      <input name="episodes_watched" id="ep_watched" type="number" placeholder="Episodes Watched">
      <input name="total_episodes" id="total_ep" type="number" placeholder="Total Episodes">
      <input name="rating" id="rating" type="number" step="0.1" min="0" max="10" placeholder="Rating 0-10">

      <label style="margin-top:10px;display:block"><i class="fas fa-image"></i> Upload Image</label>
      <input type="file" name="image" accept="image/*">
      <small style="color:#888">Or Image URL: </small>
      <input name="image_url" id="image_url" placeholder="https://...">

      <select name="status" id="status">
        <option value="watching">Watching</option>
        <option value="completed">Completed</option>
        <option value="onhold">On Hold</option>
        <option value="dropped">Dropped</option>
      </select>
      <button type="submit" class="btn-red"><i class="fas fa-save"></i> Save Anime</button>
      <button type="button" onclick="closeModal()" style="background:#333;margin-left:10px"><i class="fas fa-times"></i> Cancel</button>
    </form>
  </div>
</div>

<script>
function openModal(type,id='',title='',genres='',ep='',total='',rating='',img='',status=''){
  document.getElementById('animeModal').style.display='flex';
  if(type=='add'){
    document.getElementById('modalTitle').innerHTML='<i class="fas fa-plus"></i> Add New Anime';
    document.getElementById('animeForm').action='add_anime.php';
    document.getElementById('animeForm').reset();
  } else {
    document.getElementById('modalTitle').innerHTML='<i class="fas fa-edit"></i> Edit Anime';
    document.getElementById('animeForm').action='update_anime.php';
    document.getElementById('animeId').value=id;
    document.getElementById('title').value=title;
    document.getElementById('genres').value=genres;
    document.getElementById('ep_watched').value=ep;
    document.getElementById('total_ep').value=total;
    document.getElementById('rating').value=rating;
    document.getElementById('image_url').value=img;
    document.getElementById('status').value=status;
  }
}
function closeModal(){document.getElementById('animeModal').style.display='none'}
function toggleNotif(){let box=document.getElementById('notifBox');box.style.display=box.style.display=='block'?'none':'block'}
function toggleSidebar(){document.querySelector('.sidebar').classList.toggle('active')}
function previewImage(event){
  const reader = new FileReader();
  reader.onload = function(){document.getElementById('previewPic').src = reader.result}
  reader.readAsDataURL(event.target.files[0]);
}
window.onclick=function(e){if(e.target==document.getElementById('animeModal'))closeModal()}
</script>
</body>
</html>