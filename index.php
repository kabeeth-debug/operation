<?php
if(session_status()===PHP_SESSION_NONE) session_start();
require_once 'includes/db.php';
if(isset($_SESSION['uid'])){header("Location: dashboard.php");exit;}

$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $stmt=$pdo->prepare("SELECT * FROM users WHERE email=?");
  $stmt->execute([trim($_POST['email'])]);
  $u=$stmt->fetch();
  if($u && password_verify($_POST['password'],$u['password'])){
    $_SESSION['uid']=$u['id'];$_SESSION['name']=$u['full_name'];
    $_SESSION['role']=$u['role'];$_SESSION['room']=$u['assigned_room'];
    header("Location: dashboard.php");exit;
  }
  $err="Invalid email or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login — AL-Manthera Hospital</title>
  <link rel="stylesheet" href__="/theater/assets/style.css">
  <link rel="stylesheet" href__="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="login-page">
  <div class="login-card">
    <div class="login-logo">
      <div class="icon">🏥</div>
      <h1>AL-Manthera Hospital</h1>
      <p>Theater Management System</p>
    </div>

    <?php if($err): ?>
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?=$err?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="you@hospital.com" required autofocus>
      </div>
      <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn btn-primary btn-lg btn-block" style="margin-top:8px">
        <i class="fas fa-sign-in-alt"></i> Login
      </button>
    </form>
  </div>
</div>
</body>
</html>
