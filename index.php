<?php
require __DIR__.'/config.php';
if (user()) redirect(user()['role']==='admin'?'admin.php':'partner.php');
$error=null;
if($_SERVER['REQUEST_METHOD']==='POST'){
 $s=$db->prepare('SELECT * FROM users WHERE email=? LIMIT 1'); $s->execute([trim($_POST['email']??'')]); $u=$s->fetch();
 if($u && password_verify($_POST['password']??'',$u['password'])){$_SESSION['user']=$u;redirect($u['role']==='admin'?'admin.php':'partner.php');}
 $error='Email o password non corretti.';
}
layout_start('Login');
?><div class="container" style="max-width:460px"><div class="card"><h1>Partner Sales Hub</h1><p class="muted">Accedi al pannello della piattaforma.</p><?php if($error) echo '<p style="color:#b42318">'.e($error).'</p>'; ?><form method="post"><label>Email</label><input type="email" name="email" required><label>Password</label><input type="password" name="password" required><button class="btn" type="submit">Accedi</button></form></div></div><?php layout_end(); ?>
