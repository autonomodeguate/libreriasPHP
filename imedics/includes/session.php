<?php

class session
{
	public $usuario_id;
	private $logueado = false;
	
	function __construct()
	{
		session_start();
		$this->verificar_sesion();  
	}
	
	public function esta_logueado()
	{
		return $this->logueado;
	}
	
	public function loguearse($usuario)
	{
		if($usuario)
		{
			$this->usuario = $_SESSION['usuario_id'] = $usuario->id;
			$this->logueado = true;
		}
	}
	
	private function verificar_sesion()
	{
		if(isset($_SESSION['usuario_id']))
		{
			$this->usuario_id = $_SESSION['usuario_id'];
			$this->logueado = true;
		}
		else
		{
			unset($this->usuario_id);
			$this->logueado = false;
		}
	}
}

$sesion = new session();

?>