<?php
use \Sidney\Latchet\BaseTopic;

class SessionRoom extends BaseTopic {

	// Stores the ID of the moderator
	public $modid;

	// Stores the votes to the current story of each room | SYNTAX: [room][userid]=votevalue
	public $session_votes = array();

	// Stores all users of each room | SYNTAX: [room][KEY]=userid
	public $session_user = array();

	// Stores the current status, storyid and max-storyid of each room
	// SYNTAX: [room]['status']=statusid or [room]['storyid']=currentstoryid or [room]['max-storyid']=max-storyid
	// statusid has following values: 0=Waiting 1=Voting 2=Discussing
	public $session_vars = array();

	// Stores all Userstories of each room | SYNTAX: [room][storyid]->userstory_name or [room][storyid]->userstory_description
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
		$connection->PPA->user_id = $json->user_id;
		$roomstring = "sessions/" . $connection->PPA->room;
		$room = strval($connection->PPA->room);
		if(($booltmp= array_key_exists($room, $this->session_vars)) == false){
			$this->session_vars[$room]['status'] = 0;
        	$this->session_userstories[$room] = DB::select('select userstory_ID, userstory_name, userstory_description from userstory where userstory_session_ID = "'.$connection->PPA->room.'"');
			$this->session_vars[$room]['storyid'] = 0;
			$this->session_vars[$room]['max-storyid'] = count($this->session_userstories[$room]);
		}
		switch($json->act){
			case "start":
				$this->broadcast($topic, $message);
				$this->session_vars[$room]['status'] = 1;
				break;
			case "stop":
				$this->broadcast($topic, $message);
				$this->session_vars[$room]['status'] = 2;
				$this->sendVotesToClients($connection, $room, $topic);
				break;
			case "again":
				$this->broadcast($topic, $message);
				$this->session_vars[$room]['status'] = 0;
				if(($booltmp= array_key_exists($room, $this->session_votes[$room])) !== false) {
    				unset($this->session_votes[$room]);
				}
				break;
			case "modjoin":
				$this->sendConnectedUsers($connection, $room, $topic);
				$this->sendStatus($connection, $room, $topic);
				break;
			case "join":
				$this->broadcast($topic, $message, $exclude = array(), $eligible = $this->modid);
				$this->session_user[$room][] = $json->user_id;
				$this->sendStatus($connection, $room, $topic);
				break;
			case "leave":
				$this->broadcast($topic, $message, $exclude = array(), $eligible = $this->modid);
				if(($booltmp= array_key_exists($json->user_id, $this->session_user[$room])) !== false) {
    				unset($this->session_user[$room][$json->user_id]);
				}
				break;
			case "pick":
				$this->broadcast($topic, $message, $exclude = array(), $eligible = $this->modid);
				$tmp = explode("/", $json->val);
				$value = explode(".", $tmp[1]);
				$this->session_votes[$room][$json->user_id] = $value[0];
				break;
			case "next":
				$this->session_vars[$room]['status'] = 0;
				$this->broadcastNewStory($connection, $room, $topic);
				break;
			default:
				break;
		}
	}

	public function call($connection, $id, $topic, array $params)
	{
		
	}

	public function unsubscribe($connection, $topic)
	{
		
	}

	public function sendConnectedUsers($connection, $room, $topic){
		//list all currently connected users to the moderator
		$booltmp= array_key_exists($room, $this->session_user);
		if($booltmp!== false){
			foreach ($this->session_user[$room] as $user)
			{
				$msg = array(
					'user_id' => $user,
					'act' => 'prejoin'
				);
				$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array($connection->WAMP->sessionId));
			}
		}
	}

	public function sendStatus($connection, $room, $topic){
		$msg = array(
			'user_id' => 'SERVER',
			'act' => 'joininfo',
			'status' => $this->session_vars[$room]['status'],
			'story' => $this->session_userstories[$room][$this->session_vars[$room]['storyid']]->userstory_name,
			'desc' => $this->session_userstories[$room][$this->session_vars[$room]['storyid']]->userstory_description
		);
		$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array($connection->WAMP->sessionId));
	}

	public function sendVotesToClients($connection, $room, $topic){
		$booltmp= array_key_exists($room, $this->session_votes);
		if($booltmp!== false){
			$keys = array_keys($this->session_votes[$room]);
			foreach($keys as $key) {
				$msg = array(
					'user_id' => $key,
					'act' => 'voteinfo',
					'val' => $this->session_votes[$room][$key]
				);
				$this->broadcast($topic, json_encode($msg), $exclude = array($connection->WAMP->sessionId), $eligible = array());
			}
		}
	}

	public function broadcastNewStory($connection, $room, $topic){
		if ($this->session_vars[$room]['max-storyid'] == $this->session_vars[$room]['storyid']){
			// Weiterleitung auf Endseite

		}else{
			$this->session_vars[$room]['storyid']++;
			$msg = array(
				'user_id' => 'SERVER',
				'act' => 'next',
				'story' => $this->session_userstories[$room][$this->session_vars[$room]['storyid']]->userstory_name,
				'desc' => $this->session_userstories[$room][$this->session_vars[$room]['storyid']]->userstory_description
			);
			$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array());
		}
	}
}