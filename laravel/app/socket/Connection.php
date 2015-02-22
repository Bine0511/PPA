<?php
use \Sidney\Latchet\BaseConnection;

class Connection extends BaseConnection {

	public function open($connection)
	{
		echo "New connection established. User: " . $connection->WAMP->session_id . " \n";
	}

	public function close($connection)
	{
		echo "Connection closed. User: " . $connection->WAMP->session_id . " \n";
	}

	public function error($connection, $exception)
	{
		//close the connection
		$connection->close();
		echo $exception->getMessage();
		throw new Exception($exception);
	}
}
