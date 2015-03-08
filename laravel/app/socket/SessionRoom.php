<?php
use \Sidney\Latchet\BaseTopic;

class SessionRoom extends BaseTopic {

	public function subscribe($connection, $topic, $roomid = null)
	{
	    echo "Session:";
	    echo $roomid;
	    echo "\n";
	    $connection->PPA->room = $roomid;
	}

	public function publish($connection, $topic, $message, array $exclude, array $eligible)
	{

		$json = json_decode($message);
		$connection->PPA->user_id = $json->user_id;
		$this->broadcast($topic, $message);
	}

	public function call($connection, $id, $topic, array $params)
	{
		
	}

	public function unsubscribe($connection, $topic)
	{
		
	}

}