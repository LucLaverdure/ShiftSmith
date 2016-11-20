<?php
function addNameToCards($txt) {
	$txt = strrev($txt);
	$str_pos = strpos($txt, "-");
	$txt = substr($txt,0,$str_pos);
	$txt = strrev($txt);
	return 	$txt .= ' Looch';
}
class game_room extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if ((q('0')=="room") && (q(1) != "") && $this->getcache('login', 'user_id') > 0) {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$db = new Database();
		$db::connect();
		
		$room_title = q(1);

		$data = $db::queryResults("SELECT l.id lobbi_id, l.admin_id lobby_admin_id, l.title title,
									l.password lobbi_pwd, l.date_created, l.max_players, l.game_started, COUNT(lu.user_id) players_in
									FROM lobby l
									LEFT JOIN lobby_user lu ON lu.lobby_id = l.id
									WHERE l.title = '".$db::param(urldecode(loochtext(q(1))))."'
									GROUP BY l.id
									");

		// verify if room exists
		if ($data===false) {
			saveText(0, $this->getcache('login', 'user_id'), " *|* joins no such room as it doesn`t exist *|* ");
			redirect('/lobby');
		}

		$data = $data[0];
				
		// verify if game has started
		if ($data['game_started']=='Y') {
			saveText(0, $this->getcache('login', 'user_id'), ' *|* can\'t join a game in progress *|* ');
			redirect('/game/'.urlencode($data['title']));
		}

		// if password given, save encrypted password to session
		if (isset($_POST['lobby_pwd'])) {
			$this->setcache('login', 'lobby_pwd', md5($_POST['lobby_pwd']));
		}

		// if password given
		if ((trim($data['lobbi_pwd']) == '') || ($data['lobbi_pwd'] == $this->getcache('login', 'lobby_pwd')) ) {
			// correct password or no password needed
		} else {
			saveText(0, $this->getcache('login', 'user_id'), ' *|* didn\'t provide the right password *|* ');
			redirect('/lobby');
		}
		
		// verify maximum number of players
		if ((int) $data['players_in'] >= (int) $data['max_players']) {
			$counted_user_in = $db::queryResults("SELECT user_id FROM lobby_user 	WHERE lobby_id='".$data['lobbi_id']."'
																AND user_id='".$db::param($this->getcache('login', 'user_id'))."';");
			// omitted user +1
			if (count($counted_user_in) <= 0 || $counted_user_in === false) {
				if ((int) $data['players_in'] + 1 > (int) $data['max_players']) {
					saveText(0, $this->getcache('login', 'user_id'), ' *|* cannot join a full room! *|* ');
					redirect('/lobby');
				}
			}  else {
				if ((int) $data['players_in'] > (int) $data['max_players']) {
					saveText(0, $this->getcache('login', 'user_id'), ' *|* cannot join a full room! *|* ');
					redirect('/lobby');
				}
			}
		}
				
		// safely accessed room
		$this->setcache('lobby', 'id', $data['lobbi_id']);

		$this->addModel('posts', array());
		$this->addModel('room', 'title', $data['title']);
		
		// add player if not already in the room
		$counted_user_in = $db::queryResults("SELECT user_id FROM lobby_user 	WHERE lobby_id='".$db::param($this->getcache('lobby', 'id'))."'
															AND user_id='".$db::param($this->getcache('login', 'user_id'))."';");;
		if (count($counted_user_in) <= 0 || $counted_user_in === false) {
			$db::queryResults("INSERT INTO lobby_user(lobby_id, user_id)
								VALUES ('".$db::param($this->getcache('lobby', 'id'))."',
								'".$db::param($this->getcache('login', 'user_id'))."')");
		}
		// get all players from current lobby
		$players = $db::queryResults("SELECT u.id id, u.`uname` user, u.preferred_color color,
									u.games_won won, u.games_even tied, u.games_lost lost,
									l.typeName looch, lu.ready
						   FROM lobby_user lu
						   LEFT JOIN user u ON u.id = lu.user_id
						   LEFT JOIN looch l ON l.id = u.race_id
						   WHERE lu.lobby_id LIKE '".$db::param($this->getcache('lobby', 'id'))."'
						   ORDER BY lu.joined_on ASC", true);

		if ($players !== false) {			
			foreach ($players as $player) {
				if ($this->getcache('login', 'user_id') == $player['id']) {
					$this->addModel('stats','readyDisplay', ($player['ready']=='Y') ? ' style="display:none;"' : '');
					$this->addModel('stats','readyChecked', ($player['ready']=='Y') ? ' checked="checked"' : '');
					$this->addModel('stats','readybox', $player['ready']);
				}
			}
		} else {
			$players = array();
		}		
		
		$max_players = (int) $data['max_players'];
		for($i=count($players);$i<$max_players;++$i) {
			$blank_player = array();
			$blank_player['user'] = '[Empty]';
			$blank_player['color'] = 'ddd';
			$blank_player['won'] = '-';
			$blank_player['tied'] = '-';
			$blank_player['lost'] = '-';
			$blank_player['looch'] = '';
			$blank_player['ready'] = 'N';
			$players[] = $blank_player;
		}
		
		// add placeholder players
		$this->addModel('players', $players);

		$indeck = "c.is_in_deck = 'Y'";
		$outdeck = "c.is_in_deck = 'N'";
		
		$decksql = "SELECT c.id, l.typeName looch, c.is_in_deck, c.text, u.preferred_color color,
											
		(SELECT e.title FROM looch_element le LEFT JOIN element e ON e.id=le.element_id WHERE le.slot=1 AND le.looch_id = l.id LIMIT 1) as slot1,
		(SELECT e.title FROM looch_element le LEFT JOIN element e ON e.id=le.element_id WHERE le.slot=2 AND le.looch_id = l.id LIMIT 1) as slot2,
		(SELECT e.title FROM looch_element le LEFT JOIN element e ON e.id=le.element_id WHERE le.slot=3 AND le.looch_id = l.id LIMIT 1) as slot3
										FROM user_card c
										LEFT JOIN user cu ON c.related_user_id = cu.id
										LEFT JOIN user u ON u.id = c.user_id
										LEFT JOIN looch l ON c.looch_id = l.id
										WHERE c.user_id='".$db::param($this->getcache('login', 'user_id'))."'
										AND ?
										ORDER BY RAND(1000000)";
		$in_deck_sql = str_replace('?', $indeck, $decksql);
		$out_deck_sql = str_replace('?', $outdeck, $decksql);
				
		// add deck cards of current player for him to prepare his deck
		$deck_cards = $db::queryResults($in_deck_sql, true);
		if ($deck_cards !== false) {
			$this->modResultsModel($deck_cards, 'text', 'addNameToCards', 'name');
			$this->addModel('indeckcards', $deck_cards);
			$this->addModel('stats', 'count', count($deck_cards));
		} else {
			$this->addModel('indeckcards', array());
			$this->addModel('stats', 'count', 0);
		}

		
		// add deck cards of current player for him to prepare his deck
		$out_cards = $db::queryResults($out_deck_sql, true);
		if ($out_cards !== false) {
			$this->addModel('sidedeckcards', $out_cards);
			$this->addModel('sidestats', 'count', count($out_cards));
		} else {
			$this->addModel('sidedeckcards', array());
			$this->addModel('sidestats', 'count', 0);
		}
		
		// render room
		$this->loadView('default-theme/room.tpl');
	}
}

class players_ready extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if ((q('0')=="ajax") && (q(1) == "status") && $this->getcache('login', 'user_id') > 0 && $this->getcache('lobby', 'id') > 0) {
			return 1;	// priority 1
		}
		else return false;
	}
	
	function execute() {
		$db = new Database();
		$db::connect();

		$lobby_id = (int) $this->getcache('lobby', 'id');
		$user_id = (int)  $this->getcache('login', 'user_id');

		$player_ready = $db::queryResults("SELECT lu.user_id player_id, lu.ready ready_flag, COUNT(uc.id) cards_counted, l.game_started
										FROM lobby_user lu
										LEFT JOIN lobby l
											ON l.id = lu.lobby_id
										LEFT JOIN user_card uc
											ON lu.user_id = uc.user_id
											AND uc.is_in_deck = 'Y'
										WHERE lu.user_id = '".$user_id."'
											AND lu.lobby_id = '".$lobby_id."'
										GROUP BY lu.user_id
										ORDER BY lu.joined_on
										LIMIT 1;");
		$operation_successful = false;
		if ($player_ready !== false) {
			if (q(2)=='ready') {
				// verify game has not started if user has 25 cards in deck, and set status to ready
				foreach ($player_ready as $player) {
					if (($player['cards_counted'] == '25') && ($player['game_started'] == 'N') && ($player['ready_flag'] == 'N')) {
						$db::queryResults("UPDATE lobby_user SET ready = 'Y' WHERE
																					lobby_id = '".$lobby_id."'
																					AND user_id = '".$user_id."';");
						$operation_successful = true;
					}
				}
			} else {
				// verify game hasn`t started, and set status to not ready
				foreach ($player_ready as $player) {
					if ($player['game_started'] == 'N' && $player['ready_flag'] == 'Y') {
						$db::queryResults("UPDATE lobby_user SET ready = 'N' WHERE
																					lobby_id = '".$lobby_id."'
																					AND user_id = '".$user_id."';");
						$operation_successful = true;
					}
				}
			}
		}
		
		echo ($operation_successful == true) ? 'true' : 'false';
		die();
	}
}
class exit_game_room extends Controller {

	function validate() {
		// Activate home controller for /home and /home/*
		if ((q('0')=="lobby") && (q(1) == "exit")) {
			return 1;
		}
		else return false;
	}
	
	function execute() {
		$db = new Database();
		$db::connect();

		$lobby_id = (int) $this->getcache('lobby', 'id');
		$user_id = (int)  $this->getcache('login', 'user_id');

		$user_data = $db::queryResults("SELECT lu.ready, l.game_started
								FROM lobby_user lu
								LEFT JOIN lobby l
									ON l.id = lu.lobby_id
								WHERE lu.user_id = '".$user_id."'
									AND lu.lobby_id = '".$lobby_id."'
								ORDER BY lu.joined_on
								LIMIT 1;");

		
		if ($user_data !==false) {
			$data = $user_data[0];
			
			if ($data['game_started']=='N' && $data['ready']=='N') {
				// if game hasn`t started and player isn't ready
				$db::queryResults("DELETE FROM lobby_user WHERE user_id = '".$db::param($this->getcache('login', 'user_id'))."';");
				$this->setcache('lobby', 'id', '0');
			} elseif ($data['game_started']=='Y') {
				// when game has started
				// wrap up game for leaving player
				$db::queryResults("DELETE FROM lobby_user WHERE user_id = '".$db::param($this->getcache('login', 'user_id'))."';");
				$this->setcache('lobby', 'id', '0');
			}
		}
		
		redirect("/lobby");
	}
}
		
class get_players_status extends Controller {

	function validate() {
		// Activate home controller for /home and /home/*
		if ((q('0')=="ajax") && (q(1) == "players" && q(2)=='status') && $this->getcache('login', 'user_id') > 0 && $this->getcache('lobby', 'id') > 0) {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		// get current room startus
		$db = new Database();
		$db::connect();
		
		$lobby_id = (int) $this->getcache('lobby', 'id');

		$room = $db::queryResults("SELECT max_players
									FROM lobby
									WHERE id = '".$lobby_id."'
									LIMIT 1");
		$room = $room[0];

		$playersdb = $db::queryResults("SELECT u.id, u.`uname` user, u.preferred_color color,
									u.games_won won, u.games_even tied, u.games_lost lost,
									l.typeName looch, lu.ready ready
						   FROM lobby_user lu
						   LEFT JOIN user u ON u.id = lu.user_id
						   LEFT JOIN looch l ON l.id = u.race_id
						   WHERE lu.lobby_id LIKE '".$db::param($lobby_id)."'
						   ORDER BY lu.joined_on ASC", true);

		if ($playersdb !== false) {								   
			$players = $playersdb;
		} else {
			$players = array();
		}		
		
		
		$max_players = (int) $room['max_players'];

		for($i=count($players);$i<$max_players;++$i) {
			$blank_player = array();
			$blank_player['user'] = '[Empty]';
			$blank_player['color'] = 'ddd';
			$blank_player['won'] = '-';
			$blank_player['tied'] = '-';
			$blank_player['lost'] = '-';
			$blank_player['looch'] = '';
			$blank_player['ready'] = 'N';
			$players[] = $blank_player;
		}
		
		// add placeholder players
		$this->addModel('players', $players);

				// get current room status
		$players_status = $db::queryResults("SELECT lu.user_id player_id, lu.ready ready_flag,
											COUNT(uc.id) cards_counted, l.game_started, l.max_players, l.title game_title
										FROM lobby_user lu
										LEFT JOIN lobby l
											ON l.id = lu.lobby_id
										LEFT JOIN user_card uc
											ON lu.user_id = uc.user_id
											AND uc.is_in_deck = 'Y'
										WHERE lu.lobby_id = '".$lobby_id."'
										GROUP BY lu.user_id
										ORDER BY lu.joined_on;");
		$title = '';
		$players_ready = 0;
		$max_players = -1;
		$player_ids = array();
		if ($players_status !== false) {
				foreach ($players_status as $player) {
					if ($player['ready_flag'] == 'Y' && $player['cards_counted'] == 25) {
						$players_ready++;
						$max_players = $player['max_players'];
						if ($title=='') $title = $player['game_title'];
						$player_ids[] = (int) $player['player_id'];
					}
				}
		}

		// when all players are ready, start game
		if ($players_ready == $max_players ) {
			
			// MAIN EVENTS STARTING THE GAME OCCURS HERE
			
			$db::queryResults("UPDATE lobby SET game_started='Y' WHERE id='".$lobby_id."' LIMIT 1;");
			
			$this->setcache('lobby', 'started', 'Y');

			$turns = array();
			$i=1;
			foreach ($player_ids as $id) {
				$turns[] = $i;
				$i++;
			}
			
			shuffle($turns);
			
			foreach ($player_ids as $id) {
				$db::queryResults("UPDATE lobby_user SET turn_index = '".array_pop($turns)."'
									WHERE user_id='".$id."'
									AND lobby_id='".$lobby_id."' LIMIT 1;");
			}	
			

			$players_status = $db::queryResults("UPDATE user_card
												SET stack_index = (RAND() * 999999999 + 1),
												is_in_hand='N', is_discarded = 'N', is_defeated='N'
												WHERE user_id IN (".implode(',',$player_ids).")
												AND is_in_deck='Y'");
												
			
			
			$db::queryResults("UPDATE lobby SET game_started='Y' WHERE id='".$lobby_id."' LIMIT 1;");
			
			echo '/game/on';
		} else {
			$this->loadView('default-theme/players.ajax.tpl');
		}
	}	
}
