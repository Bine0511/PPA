<?php
use \Sidney\Latchet\BaseTopic;

class SessionRoom extends BaseTopic {

	public function subscribe($connection, $topic, $roomid = null)
	{
	    echo "Session:";
	    echo $roomid;
	    echo "\n";
	}

	public function publish($connection, $topic, $message, array $exclude, array $eligible)
	{
		$this->broadcast($topic, $message);
	}

	public function call($connection, $id, $topic, array $params)
	{
		
	}

	public function unsubscribe($connection, $topic)
	{
		
	}

}