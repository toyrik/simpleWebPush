<?php 
SESSION_START();
include('layout/header.php');
?>
<title>Реализация простейшей системы web-push уведомлений с использованием PHP & MySQL</title>
<script src="js/notification.js"></script>
<?php include('layout/container.php');?>
<div class="container">		
    <h2>Пример простейшей системы web-push уведомлений с использованием PHP & MySQL</h2>	
    <h3>Пользователь </h3>
    <?php if(isset($_SESSION['username']) && $_SESSION['username']) { ?>
        <strong <?php if($_SESSION['username'] != 'admin') { ?> id="loggedIn" <?php } ?>><?php echo $_SESSION['username']; ?></strong> | <a href="logout.php">Выход</a>
    <?php } else { ?>
        <a href="login.php">Вход</a>
    <?php } ?>
    <hr> 
    <?php if (isset($_SESSION['username']) && $_SESSION['username']) { ?>
        <h4>Добро пожаловать!</h4>
        
        
    <?php if(isset($_SESSION['username']) && $_SESSION['username'] == 'admin') { ?>
        <a href="manage.php">Управление уведомлениями</a>  <?php } ?>

    <?php } ?>	
    
</div>	
<?php include('layout/footer.php');?>






