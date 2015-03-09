<?php
use \Sidney\Latchet\BaseConnection;

class Connection extends BaseConnection {

	public function open($connection)
	{
		$connection->PPA = new \StdClass;
    	$connection->PPA->name  = $connection->WAMP->sessionId;
		echo "New connection established. User: ";
		echo $connection->PPA->name;
		echo "\n";
	}

	public function close($connection)
	{
		$arr = array('user_id' => $connection->PPA->user_id, 'act' => 'leave');
		$room = $connection->PPA->room;
		$json = json_encode($arr);

		Latchet::publish('sessions/lobby', $arr);
		echo "Connection closed. User: ";
		echo $connection->PPA->name;
		echo "\n";
	}

	public function error($connection, $exception)
	{
		//close the connection
		$connection->close();
		echo $exception->getMessage() + "Outch! \n";
	}
}
