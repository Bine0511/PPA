<?php
use \Sidney\Latchet\BaseTopic;

class SessionRoom extends BaseTopic {

	// Stores the ID of the moderator
	public $modid;

	// Stores the votes to the current story of each room | SYNTAX: [room][userid]=votevalue
	public $session_votes = array();

	// Stores the timevotes to the current story of each room | SYNTAX: [room][userid]=timevotevalue
	public $session_timevotes = array();

	// Stores all users of each room | SYNTAX: [room][KEY]=userid
	public $session_user = array();

	// Stores the current status, storyid and max-storyid of each room
	// SYNTAX: [room]['status']=statusid or [room]['storyid']=currentstoryid or [room]['max-storyid']=max-storyid or [room]['timecounter'] = timecounter
	// statusid has following values: 0=Waiting 1=Voting 2=Discussing 3=Mod is choosing Timevote-Stories
	public $session_vars = array();

	// Stores all Userstories of each room | SYNTAX: [room][storyid]->userstory_name or [room][storyid]->userstory_description
	public $session_userstories = array();

	public $session_timestories = array();

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
			$this->session_vars[$room]['mode'] = "norm";
			$basetemp = DB::select('select session_basestory_ID from session where session_ID = "'.$connection->PPA->room.'"');
			$this->session_vars[$room]['base-id'] = $basetemp[0]->session_basestory_ID;
        	$this->session_userstories[$room] = DB::select('select userstory_ID, userstory_name, userstory_description from userstory where userstory_session_ID = "'.$connection->PPA->room.'"AND userstory_ID<>"'.$this->session_vars[$room]['base-id'].'"');
			$this->session_vars[$room]['storyid'] = 0;
			$this->session_vars[$room]['max-storyid'] = count($this->session_userstories[$room]);
			$this->session_vars[$room]['base-title'] = 0;
			$this->session_vars[$room]['base-desc'] = 0;
			$this->session_vars[$room]['timefirst'] = 0; // 0 = first, 1 = not
		}
		switch($json->act){
			case "start":
				if($this->session_vars[$room]['mode'] == "time"){
					$json->act = "timestart";
					$this->broadcast($topic, json_encode($json));
				}else{
					$this->broadcast($topic, $message);
				}
				$this->session_vars[$room]['status'] = 1;
				break;
			case "stop":
				if($this->session_vars[$room]['mode'] == "time"){
					$json->act = "timestop";
					$this->broadcast($topic, json_encode($json));
					$this->sendTimeVotesToClients($connection, $room, $topic);
				}else{
					$this->broadcast($topic, $message);
					$this->sendVotesToClients($connection, $room, $topic);
				}
				$this->session_vars[$room]['status'] = 2;
				break;
			case "again":
				if($this->session_vars[$room]['mode'] == "time"){
					$json->act = "timeagain";
					$this->broadcast($topic, json_encode($json));
				}else{
					$this->broadcast($topic, $message);
				}
				$this->session_vars[$room]['status'] = 0;
				if(($booltmp=array_key_exists($room, $this->session_votes)) !== false) {
    				unset($this->session_votes[$room]);
				}
				break;
			case "modjoin":
				$this->sendStatus($connection, $room, $topic);
				$this->sendConnectedUsers($connection, $room, $topic);
				break;
			case "join":
				$this->broadcast($topic, $message, $exclude = array(), $eligible = $this->modid);
				$this->session_user[$room][$json->user_id] = $json->user_name;
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
				if($this->session_vars[$room]['mode'] == "time"){
					if(isset($json->val)){
						$this->session_timevotes[$room][$json->user_id] = $json->val;
					}else{
						$this->session_timevotes[$room][$json->user_id] = "?";
					}
				}else{
					if(isset($json->val)){
						$tmp = explode("/", $json->val);
						$value = explode(".", $tmp[1]);
						if($value[0] == "fragezeichen"){
							$this->session_votes[$room][$json->user_id] = "?";
						}else{
							$this->session_votes[$room][$json->user_id] = $value[0];
						}
					}else{
						$this->session_votes[$room][$json->user_id] = "?";
					}
				}	
				break;
			case "next":
				$this->session_vars[$room]['status'] = 0;
				if($this->session_vars[$room]['mode'] == "norm"){
					if(array_key_exists($room, $this->session_votes)) {
						$this->insertStories($room);
    					unset($this->session_votes[$room]);
					}
					$this->broadcastNewStory($connection, $room, $topic);
					echo "hi";
				}
				if($this->session_vars[$room]['mode'] == "time"){
					var_dump($this->session_vars[$room]);
					if(($booltmp=array_key_exists($room, $this->session_timevotes)) !== false) {
						$this->insertTimeStories($room);
    					unset($this->session_timevotes[$room]);
					}
					$this->broadcastNewTimeStory($connection, $room, $topic);
				}
				break;
			case "timechosen":
				foreach($this->session_userstories[$room] as $story){
					if($story->userstory_ID == $json->storyid){
						$this->session_timestories[$room][]=$story;
					}
				}
				break;
			case "timefwd":
				$this->session_vars[$room]['mode'] = "time";
				$this->session_vars[$room]['status'] = 0;
				$this->session_vars[$room]['storyid'] = 0;
				$this->session_vars[$room]['max-storyid'] = count($this->session_timestories[$room]);
				$this->broadcastNewTimeStory($connection, $room, $topic);
				$this->sendConnectedUsers($connection, $room, $topic);
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
			$keys = array_keys($this->session_user[$room]);
			foreach($keys as $user) {
				$msg = array(
					'user_id' => $user,
					'user_name' => $this->session_user[$room][$user],
					'act' => 'prejoin'
				);
				$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array($connection->WAMP->sessionId));
			}
		}
	}

	public function sendStatus($connection, $room, $topic){
		if($this->session_vars[$room]['mode'] == "ende"){
			// Abstimmung endet
			$msg = array(
				'user_id' => 'SERVER',
				'act' => 'ende'
			);
			$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array());
			return;
		}
		if($this->session_vars[$room]['mode'] == "time"){
			switch($this->session_vars[$room]['status']){
				case 0:
				case 1:
				case 2:
					$msg = array(
						'user_id' => 'SERVER',
						'act' => 'joininfo',
						'mode' => $this->session_vars[$room]['mode'],
						'status' => $this->session_vars[$room]['status'],
						'story' => $this->session_timestories[$room][$this->session_vars[$room]['storyid']]->userstory_name,
						'desc' => $this->session_timestories[$room][$this->session_vars[$room]['storyid']]->userstory_description
					);
					$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array($connection->WAMP->sessionId));
					break;
				case 3:
					$msg = array(
						'user_id' => 'SERVER',
						'act' => 'joininfo',
						'mode' => $this->session_vars[$room]['mode'],
						'status' => $this->session_vars[$room]['status']
					);
					$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array($connection->WAMP->sessionId));
					break;
				default:
					break;
			}
		}else{
			switch($this->session_vars[$room]['status']){
				case 0:
				case 1:
				case 2:
					$msg = array(
						'user_id' => 'SERVER',
						'act' => 'joininfo',
						'mode' => $this->session_vars[$room]['mode'],
						'status' => $this->session_vars[$room]['status'],
						'story' => $this->session_userstories[$room][$this->session_vars[$room]['storyid']]->userstory_name,
						'desc' => $this->session_userstories[$room][$this->session_vars[$room]['storyid']]->userstory_description
					);
					$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array($connection->WAMP->sessionId));
					break;
				case 3:
					$msg = array(
						'user_id' => 'SERVER',
						'act' => 'joininfo',
						'mode' => $this->session_vars[$room]['mode'],
						'status' => $this->session_vars[$room]['status'],
						'stories' => $this->session_userstories[$room]
					);
					$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array($connection->WAMP->sessionId));
					break;
				default:
					break;
			}	
		}
		
	}

	public function sendVotesToClients($connection, $room, $topic){
		$booltmp= array_key_exists($room, $this->session_votes);
		if($booltmp!== false){
			$keys = array_keys($this->session_votes[$room]);
			foreach($keys as $key) {
				$vote_val = $this->session_votes[$room][$key];
				if($this->session_votes[$room][$key] == "?"){
					$vote_val = "fragezeichen";
				}
				$msg = array(
					'user_id' => $key,
					'user_name' => $this->session_user[$room][$key],
					'act' => 'voteinfo',
					'val' => $vote_val
				);
				$this->broadcast($topic, json_encode($msg), $exclude = array($connection->WAMP->sessionId), $eligible = array());
			}
		}
	}

	public function sendTimeVotesToClients($connection, $room, $topic){
		$booltmp= array_key_exists($room, $this->session_timevotes);
		if($booltmp!== false){
			$keys = array_keys($this->session_timevotes[$room]);
			foreach($keys as $key) {
				$msg = array(
					'user_id' => $key,
					'user_name' => $this->session_user[$room][$key],
					'act' => 'timevoteinfo',
					'val' => $this->session_timevotes[$room][$key]
				);
				$this->broadcast($topic, json_encode($msg), $exclude = array($connection->WAMP->sessionId), $eligible = array());
			}
		}
	}

	public function broadcastNewStory($connection, $room, $topic){
		$this->session_vars[$room]['storyid']++;
		if ($this->session_vars[$room]['max-storyid'] == $this->session_vars[$room]['storyid']){
			// Moderator muss Timevote-Stories wählen
			$this->session_vars[$room]['status'] = 3;
			$msg = array(
				'user_id' => 'SERVER',
				'act' => 'time',
				'stories' => $this->session_userstories[$room]
			);
			$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array($connection->WAMP->sessionId));
		}else{
			$msg = array(
				'user_id' => 'SERVER',
				'act' => 'next',
				'story' => $this->session_userstories[$room][$this->session_vars[$room]['storyid']]->userstory_name,
				'desc' => $this->session_userstories[$room][$this->session_vars[$room]['storyid']]->userstory_description
			);
			$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array());
		}
	}

	public function broadcastNewTimeStory($connection, $room, $topic){
		if ($this->session_vars[$room]['timefirst'] == 0){
			$this->session_vars[$room]['timefirst'] =1 ;
		}else{
			$this->session_vars[$room]['storyid']++;
		}
		if ($this->session_vars[$room]['max-storyid'] == $this->session_vars[$room]['storyid']){

			$this->session_vars[$room]['mode'] ="ende";
			// Abstimmung endet
			$msg = array(
				'user_id' => 'SERVER',
				'act' => 'ende'
			);
			$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array());
		}else{
			$msg = array(
				'user_id' => 'SERVER',
				'act' => 'timenext',
				'story' => $this->session_timestories[$room][$this->session_vars[$room]['storyid']]->userstory_name,
				'desc' => $this->session_timestories[$room][$this->session_vars[$room]['storyid']]->userstory_description
			);
			$this->broadcast($topic, json_encode($msg), $exclude = array(), $eligible = array());
		}
	}

	public function insertStories($room){
		$id = $this->session_vars[$room]['storyid'];
		$storyid = $this->session_userstories[$room][$id]->userstory_ID;
		$keys = array_keys($this->session_votes[$room]);
		foreach($keys as $userid) {
			$value = $this->session_votes[$room][$userid];
			// (vote_user_ID, vote_userstory_id, vote_session_id, value)
			DB::insert("insert into vote values ('".$userid."', '".$storyid."', '".$room."', '".$value."')");
		}
	}

	public function insertTimeStories($room){
		$id = $this->session_vars[$room]['storyid'];
		$storyid = $this->session_timestories[$room][$id]->userstory_ID;
		$keys = array_keys($this->session_timevotes[$room]);
		foreach($keys as $userid) {
			$value = $this->session_timevotes[$room][$userid];
			// (timevote_user_ID, timevote_userstory_id, timevote_session_id, timevote_value)
			DB::insert("insert into timevote values ('".$userid."', '".$storyid."', '".$room."', '".$value."')");
		}
	}
}