<?php 

require_once 'koneksi.php';

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = mysqli_real_escape_string($koneksi, $_POST['password']);

$query = mysqli_query($koneksi, "SELECT * FROM tbl_pengguna WHERE username = '$username'");

if($query->num_rows > 0){
	$row = mysqli_fetch_assoc($query);
	if(password_verify($password, $row['password']) and $row['level']==1){
		$_SESSION['auth_admin'] = true;
		$_SESSION['id'] = $row['id'];
		$_SESSION['level'] = 1;
		$_SESSION['nama'] = $row['nama'];
		$_SESSION['username'] = $row['username'];

		header('Location: admin/index.php');

	}else if(password_verify($password, $row['password']) and $row['level']==2){
		$_SESSION['auth_admin'] = true;
		$_SESSION['id'] = $row['id'];
		$_SESSION['level'] = 2;
		$_SESSION['nama'] = $row['nama'];
		$_SESSION['username'] = $row['username'];
		header('Location: operator/index.php');

	} else {
		$_SESSION['gagal'] = 'Password salah!';
		header('Location: login.php');
	}
} else {
	$_SESSION['gagal'] = 'Username tidak ditemukan!';
	header('Location: login.php');
}