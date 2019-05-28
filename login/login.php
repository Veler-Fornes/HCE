<?php session_start();
if (isset($_SESSION['usuario']))
{
	header('Location: index.php');
}
$errores='';
if($_SERVER['REQUEST_METHOD']=='POST')
{
	$usuario=filter_var(strtolower($_POST['usuario']),FILTER_SANITIZE_STRING);
	$password=$_POST['password'];
	try
	{
		$conexion=new PDO('mysql:host=localhost;port=3306;dbname=devlab_hce','root','roottoor');
	}
	catch (PDOException $e)
	{
		echo "Error:".$e->getMessage();
	}
	$stamement=$conexion->prepare('SELECT * FROM usuarios WHERE usuario=:usuario and password=:password');
	$stamement->execute(array(':usuario'=>$usuario,':password'=>$password));
	$resultado=$stamement->fetch();
	if($resultado!==false)
	{
		$_SESSION['usuario']=$usuario;
		header('Location:index.php');
	}else
	{
		$errores.='<li>Datos incorrectos</li>';
	}
}
require 'views/login.view.php';
?>