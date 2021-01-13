<?php 
ob_start();
SESSION_START();
$message = '';
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    
    include_once 'config/Database.php';
    include_once 'class/User.php';

    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $user->username = $_POST['username'];
    $user->password = $_POST['password'];	
    
    if($user->login()) {
        $_SESSION['username'] = $user->username;
        header("Location:index.php");
    } else {
        $message = "Invalid username or password!";
    }
}
include('layout/header.php');
?>
<title>Реализация простейшей системы web-push уведомлений с использованием PHP & MySQL</title>
<div class="container">		
    <h2>Вход:</h2>
    <div class="row">
        <div class="col-sm-4">
            <form method="post">
                <div class="form-group">
                <?php if ($message ) { ?>
                    <div class="alert alert-warning"><?php echo $message; ?></div>
                <?php } ?>
                </div>
                <div class="form-group">
                    <label for="username">Пользователь:</label>
                    <input type="username" class="form-control" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input type="password" class="form-control" name="password" required>
                </div>  
                <button type="submit" name="login" class="btn btn-default">Авторизация</button>
            </form><br>
            
            <strong>Администратор для создания уведомлений и назначения их пользователю:</strong><br>
            <strong>Пользователь:</strong> admin <br>
            <strong>Пароль:</strong> 12345
            <br><br>
            <strong>Пользователь для получения уведомлений:</strong><br>
            <strong>Пользователь:</strong> test <br>
            <strong>Пароль:</strong> 12345			
        </div>
    </div>
</div>	
<?php include('layout/footer.php');?>