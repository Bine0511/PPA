<?php
use \Sidney\Latchet\BaseTopic;

class SessionRoom extends BaseTopic {

	public $session_votes = array();
	public $session_user = array();
	public $session_status = array(); //0=Waiting 1=Voting 2=Speaking
	public $session_userstories = array();

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
		$room = "sessions/" . $connection->PPA->room;
		if(($key = array_search($room, $this->session_status)) !== false){
			$this->session_status = 0;
        	$this->session_userstories = DB::select('select * from userstory where userstory_session_ID = "'.$connection->PPA->room.'"');

		}
		switch($json->act){
			case "start":
				$this->session_status[$room] = 1;
				break;
			case "stop":
				$this->session_status[$room] = 2;
				break;
			case "again":
				$this->session_status[$room] = 0;
				break;
			case "modjoin":
				//list all currently connected subscribers to the new guy
				if(($key = array_search($room, $this->session_user)) !== false){
					foreach ($this->session_user[$room] as $user)
					{
						$msg = array(
							'user_id' => $user,
							'act' => 'join'
						);
						$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array($connection->WAMP->sessionId));
					}
				}
				break;
			case "join":
				$this->session_user[$room][] = $json->user_id;
				$msg = array(
					'user_id' => 'SERVER',
					'act' => 'joininfo',
					'status' => $this->session_status[$room],
					'story' => 'Das is ne Story'
				);
				$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array($connection->WAMP->sessionId));
				break;
			case "leave":
				if(($key = array_search($json->user_id, $this->session_user[$room])) !== false) {
    				unset($this->session_user[$room][$json->user_id]);
				}
				break;
			case "pick":
				$tmp = explode("/", $json->val);
				$value = explode(".", $tmp[1]);
				$this->session_votes[$room][$json->user_id] = $value[0];
				break;
			case "next":
				$this->session_status[$room] = 0;
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