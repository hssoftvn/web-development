<?php
class Request
{
	// THE only instance of the class
	private static $instance;


	private function __construct() {}

	/**
	*    Returns THE instance of 'Session'.
	*    The session is automatically initialized if it wasn't.
	*    @return    object
	**/
	public static function getInstance()
	{
		if ( !isset(self::$instance))
		{
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	*    Stores datas in the session.
	*    Example: $instance->foo = 'bar';
	*    
	*    @param    name    Name of the datas.
	*    @param    value    Your datas.
	*    @return    void
	**/
	public function __set( $name , $value )
	{
		$_REQUEST[$name] = $value;
	}

	/**
	*    Gets datas from the session.
	*    Example: echo $instance->foo;
	*    
	*    @param    name    Name of the datas to get.
	*    @return    mixed    Datas stored in session.
	**/
	public function __get( $name )
	{
		if ( isset($_REQUEST[$name]))
		{
			return $_REQUEST[$name];
		}
	}

	public function __isset( $name )
	{
		return isset($_REQUEST[$name]);
	}


	public function __unset( $name )
	{
		unset( $_REQUEST[$name] );
	}
	
	public static function RedirectTo($location)
	{
		header('Location: ' . $location);
	}
}

?>