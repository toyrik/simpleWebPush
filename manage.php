<?php 
SESSION_START(); 
include_once 'config/Database.php';
include_once 'class/Notification.php';
include_once 'class/User.php';
$database = new Database();
$db = $database->getConnection();
$notification = new Notification($db);
$user = new User($db);
include('layout/header.php');
?>
<title>Реализация простейшей системы web-push уведомлений с использованием PHP & MySQL</title>
<style>
.borderless tr td {
    border: none !important;
    padding: 2px !important;
}
</style>
<div class="container">		
	<h2>Пример простейшей системы web-push уведомлений с использованием PHP & MySQL</h2>	
	<a href="index.php">На главную</a> | <a href="logout.php">Выход</a>
	<hr>
	<div class="row">
		<div class="col-sm-6">
			<h3>Добавить новое уведомление:</h3>
			<form method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">										
				<table class="table borderless">
					<tr>
						<td>Заголовок</td>
						<td><input type="text" name="title" class="form-control" required></td>
					</tr>	
					<tr>
						<td>Содержание</td>
						<td><textarea name="message" cols="50" rows="4" class="form-control" required></textarea></td>
					</tr>			
					<tr>
						<td>Время отправки</td>
						<td><select name="ntime" class="form-control"><option>Немедленно</option></select> </td>
					</tr>
					<tr>
						<td>Повторять каждые(мин)</td>
						<td><select name="loops" class="form-control">
						<?php 
							for ($i=1; $i<=5 ; $i++) { ?>
								<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td>Повторять (раз)</td>
						<td><select name="loop_every" class="form-control">
						<?php 
						for ($i=1; $i<=60 ; $i++) { ?>
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
						</select> </td>
					</tr>
					<tr>
						<td>Адресат</td>
						<td><select name="user" class="form-control">
						<?php 		
						$allUser = $user->listAll(); 							
						while ($user = $allUser->fetch_assoc()) { 	
						?>
						<option value="<?php echo $user['username'] ?>"><?php echo $user['username'] ?></option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td colspan=1></td>
						<td colspan=1></td>
					</tr>					
					<tr>
						<td colspan=1></td>
						<td><button name="submit" type="submit" class="btn btn-info">Добавить</button></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<?php 
	if (isset($_POST['submit'])) { 
		if(isset($_POST['message']) and isset($_POST['ntime']) and isset($_POST['loops']) and isset($_POST['loop_every']) and isset($_POST['user'])) {
			$notification->title = $_POST['title'];
			$notification->message = $_POST['message'];
			$notification->ntime = date('Y-m-d H:i:s'); 
			$notification->repeat = $_POST['loops']; 
			$notification->nloop = $_POST['loop_every']; 
			$notification->username = $_POST['user'];	
			if($notification->saveNotification()) {
				echo '* save new notification success';
			} else {
				echo 'error save data';
			}
		} else {
			echo '* completed the parameter above';
		}
	} 
	?>
	<h3>Список уведомлений:</h3>
	<table class="table">
		<thead>
			<tr>
				<th>№</th>
				<th>Зарегистрированно</th>
				<th>Заголовок</th>
				<th>Сообщение</th>
				<th>Повторы</th>
				<th>Адресат</th>
			</tr>
		</thead>
		<tbody>
			<?php $notificationCount =1; 
			$notificationList = $notification->listNotification(); 			
			while ($notif = $notificationList->fetch_assoc()) { 	
			?>
			<tr>
				<td><?php echo $notificationCount ?></td>
				<td><?php echo $notif['ntime'] ?></td>
				<td><?php echo $notif['title'] ?></td>
				<td><?php echo $notif['message'] ?></td>
				<td><?php echo $notif['nloop']; ?></td>
				<td><?php echo $notif['username'] ?></td>
			</tr>
			<?php $notificationCount++; } ?>
		</tbody>
	</table>
</div>	
<?php include('layout/footer.php');?>