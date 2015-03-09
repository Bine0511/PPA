<?php
use \Sidney\Latchet\BaseTopic;

class SessionRoom extends BaseTopic {

	protected $vote_arr = array();
	protected $users = array();
	protected $status = 0; //0=Waiting 1=Voting 2=Speaking
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
		echo var_dump($json);
		switch($json->act){
			case "start":
				$status = 1;
				break;
			case "stop":
				$status = 2;
				break;
			case "modjoin":
				$arr = array("user_id" => "SERVER", "act" => "userlist", "users" => $users);
				//Latchet::publish('sessions/lobby', $arr);
				break;
			case "join":
				$users[] = $json->user_id;
				break;
			case "leave":
				array_diff($users, [$json->user_id]);
				break;
			case "pick":
				break;
			case "next":
				echo var_dump($json);
				$keys = array_keys($json->votes);
				foreach($keys as $key) {
				    $vote_arr[$key] = $json->votes[$key];
				}
				break;
			default:
				break;
		}
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