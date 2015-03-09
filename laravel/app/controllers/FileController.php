<?php

class FileController extends Controller
{


//Durchschnitt der User Story Punkte berechnen
	public function calculateAvg($sess){
		//userstories der aktuellen session
		$ustory = DB::table('userstory')->where('userstory_session_ID','=',$sess)->get();
		//für jede userstory den durchschnitt der votes berechnen

		foreach ($ustory as $ustory) {
			$sumvote = 0;
			$avgUs = 0;
			
			$count = 0;
			//alle votes der aktuellen userstory
			$vote = DB::table('vote')->where('vote_userstory_ID', '=', $ustory->userstory_ID)->where('vote_session_ID','=',$sess)->get();
			foreach ($vote as $vote) {
				if($vote->value != '?' && $vote->value != 'coffee'){
				//summe und anzahl der votes die nicht '?' oder 'coffee' sind
				$sumvote = $sumvote + $vote->value;
				$count += 1;
			}
			}
			//durchschnitt berechnen
			$avgUs = $sumvote/$count;
			$test = DB::table('userstory')->where('userstory_session_ID','=',$sess)->where('userstory_ID', '=', $ustory->userstory_ID)->get();
			
			//eintragen des ergebnisses in der DB
			DB::table('userstory')->where('userstory_session_ID','=',$sess)->where('userstory_ID', '=', $ustory->userstory_ID)->update(array('userstory_average' => $avgUs));
			
		}
	}

//Durchschnitt der Time votes pro Userstory berechnen, s.o.
	public function calcTimeAvg($sess){
		$ustory = DB::table('userstory')->where('userstory_session_ID','=',$sess)->get();
		foreach ($ustory as $ustory) {
			$sumTvote = 0;
			$avgTUs = 0;
			$Tcount = 0;
			$timevote = DB::table('timevote')->where('timevote_userstory_ID', '=', $ustory->userstory_ID)->where('timevote_session_ID','=',$sess)->whereNotNull('timevote_value')->get();
			foreach ($timevote as $timevote) {
				if($timevote->timevote_value != '?'){
					$sumTvote = $sumTvote + $timevote->timevote_value;
					$Tcount += 1;
				}
			} 
				$avgTUs = $sumTvote/$Tcount;

			
			DB::table('userstory')->where('userstory_session_ID','=',$sess)->where('userstory_ID', '=', $ustory->userstory_ID)->update(array('userstory_time_average' => $avgTUs));
	}
}

//Summe der Durchschnitte
	public function sumAvg($sess){
		$ustory = DB::table('userstory')->where('userstory_session_ID','=',$sess)->get();
		$sum = 0;
		foreach ($ustory as $ustory) {
			$sum += $ustory->userstory_average;
		}
		DB::table('session')->where('session_ID','=',$sess)->update(array('avg_sum'=>$sum));
	}

//Durchschnittswert der Votes der Base-Userstory
	public function sumAvgBase($sess){
		$baseAvg = 0;
		$baseSum = 0;
		$baseCount = 0;
		$sessio = DB::table('session')->where('session_ID','=',$sess)->get();
		foreach ($sessio as $sessio) {
			$baseVote = DB::table('vote')->where('vote_userstory_ID','=',$sessio->session_basestory_id)->get();
			foreach ($baseVote as $baseVote) {
				$baseSum = $baseSum + $baseVote->value;
				$baseCount += 1;
			}
		$baseAvg = $baseSum/$baseCount;
		DB::table('session')->where('session_ID','=',$sessio->session_ID)->update(array('avg_sum_base'=>$baseAvg));
		}
		
	}

//Zeit Durchschnitt durch Vote Durchschnitt
	public function timeDivAvg($sess){
		$userstory = DB::table('userstory')->where('userstory_session_ID','=',$sess)->where('userstory_time_average','>',0)->get();
		foreach ($userstory as $userstory) {
			$newEntry = $userstory->userstory_time_average/$userstory->userstory_average;
			DB::table('userstory')->where('userstory_ID','=',$userstory->userstory_ID)->update(array('userstory_timeavg_div_avg'=>$newEntry));
		}
	}

//Durchschnitt der timeDivAvg
	public function avgTimeDivAvg($sess){
			$sumTDA = 0;
			$avgTDA = 0;
			$TDAcount = 0;
		$ustory = DB::table('userstory')->where('userstory_session_ID','=',$sess)->where('userstory_time_average','>',0)->get();
		foreach ($ustory as $ustory) {
			$sumTDA = $sumTDA + $ustory->userstory_timeavg_div_avg;
			$TDAcount += 1;
		}
			$avgTDA = $sumTDA/$TDAcount;
			DB::table('session')->where('session_ID', '=', $ustory->userstory_session_ID)->update(array('avg_time_div_avg' => $avgTDA));
			
		
	}

//Zeit berechnen
	public function calcTime($sess){
		//aktuelle session
		$sessi = DB::table('session')->where('session_id','=',$sess)->get();
		foreach ($sessi as $sessi) {
			$us = DB::table('userstory')->get();
			//alle userstories
			foreach ($us as $us) {
				//durchschnitts votes der userstory * Durchschnitt der Zeit pro SP
				$calcTime = $us->userstory_average*$sessi->avg_time_div_avg;
				DB::table('userstory')->where('userstory_ID','=',$us->userstory_ID)->update(array('calc_time' => $calcTime ));
			}
		}
	}

//summe der berechneten zeiten
	public function sumCalcTime($sess){
		$sessi = DB::table('session')->where('session_id','=',$sess)->get();
		foreach ($sessi as $sessi) {
			$us = DB::table('userstory')->get();
			$sum = 0;
			foreach ($us as $us) {
				$sum = $sum + $us->calc_time;
			}
			DB::table('session')->where('session_ID','=',$sessi->session_ID)->update(array('sum_calc_time' => $sum ));
		}
	}
	
	public function showPDF($sess)
{
	$this->calculateAvg($sess);
	$this->calcTimeAvg($sess);
	$this->sumAvg($sess);
	$this->sumAvgBase($sess);
	$this->timeDivAvg($sess);
	$this->avgTimeDivAvg($sess);
	$this->calcTime($sess);
	$this->sumCalcTime($sess);

//Vote Tabelle
	$html = '<html><head><meta charset="utf-8"><style>.family{font-family:Helvetica;} h1{font-size: 50px;} .table{margin:auto;}</style></head><body class="family">';
	$html = $html.'<h1>Ergebnis</h1>';
	$sessio = DB::table('session')->where('session_ID','=',$sess)->get();
	foreach ($sessio as $sessio) {
	//Teilnehmer Tabelle
		$html = $html.'<table>';

		//moderator ausgeben
		$moderator = DB::table('moderator')->where('moderator_ID','=',$sessio->session_moderator_ID)->get();
		foreach ($moderator as $moderator) {
			$html = $html.'<tr><td style="font-weight:bold;color:#9b0000;font-size:28px;">'.$moderator->moderator_name.'</td></tr>';
		}

		//alle user ausgeben
		$user = DB::table('user')->where('user_session_ID','=',$sessio->session_ID)->get();
		foreach ($user as $user) {
			$html = $html.'<tr><td style="font-size:28px;">'.$user->user_name.'</td></tr>';
		}

		$html = $html.'</table>';

	//Vote Tabellen
		//Userstory Tabellen erstellen
		$ustory = DB::table('userstory')->where('userstory_session_ID','=',$sessio->session_ID)->get();
		foreach ($ustory as $ustory) {
			$html = $html.'<table><thead><tr><td>User</td><td>'.$ustory->$userstory_name.'</td></tr></thead>';


			//alle User
			$user = DB::table('user')->where('user_session_ID','=',$sessio->session_ID)->get();
			foreach ($user as $user) {
				//vote des users zur userstory
				$vote = DB::table('vote')->where('vote_user_ID','=',$user->user_ID)->where('vote_userstory_ID','=',$ustory->userstory_ID)->get();
				foreach ($vote as $vote) {
					$html = $html.'<tr><td>'.$user->user_name.'</td><td>'.$vote->value.'</td></tr>';
				}
				
			}

			$html = $html.'</table>';
		}
	}
	

	/*
	$user = DB::table('user')->where('user_session_ID','=',$sess)->get();
	$userstory = DB::table('userstory')->where('userstory_session_ID','=',$sess)->get();


	$html = $html.'<table style="text-align:right; border: 2px solid #000; width:100%;"><tr style="border-bottom: 3px solid #000"><td><b>Punkte Schätzung</b></td>';
	foreach ($userstory as $userstory) {
		$html = $html . '<td width="">'.$userstory->userstory_name.'</td>';
	}
	$html = $html. '</tr>';
	
	foreach ($user as $user)
	{$html = $html . '<tr><td>' . $user->user_name . '</td>';

		$use = DB::table('userstory')->where('userstory_session_ID','=',$sess)->get();
		foreach($use as $use){
			$vote = DB::table('vote')->where('vote_user_ID','=',$user->user_ID)->where('vote_userstory_ID', '=', $use->userstory_ID)->get();
		foreach ($vote as $vote) {
			$html = $html.'<td>'.$vote->value.'</td>';
		}
		}
		$html = $html . '</tr>';
	}      
	$html = $html . '<tr style="border-top:4px solid #000;"><td><b>Durchschnitt</b></td>';
	$usersavg = DB::table('userstory')->where('userstory_session_ID','=',$sess)->get();
	foreach ($usersavg as $usersavg) {
		$html = $html.'<td><b>'.$usersavg->userstory_average.'</b></td>';
	}
	$html = $html . '</tr></table><br>';

//TimeVote Tabelle
	$users = DB::table('user')->where('user_session_ID','=',$sess)->get();
	$userstorys = DB::table('userstory')->where('userstory_session_ID','=',$sess)->where('userstory_time_average','>',0)->get();
	$html = $html . '<table style="text-align:right; border: 2px solid #000; width:100%;"><tr style="border-bottom: 3px solid #000"><td><b>Zeitschätzung</b></td>';
	foreach ($userstorys as $userstorys) {
		$html = $html . '<td width="">'.$userstorys->userstory_name.'</td>';
	}
	$html = $html. '</tr>';
	
	foreach ($users as $users)
	{$html = $html . '<tr><td>' . $users->user_name . '</td>';
		$use = DB::table('userstory')->where('userstory_session_ID','=',$sess)->get();
		foreach($use as $use){
			$timevote = DB::table('timevote')->where('timevote_user_ID','=',$users->user_ID)->where('timevote_userstory_ID', '=', $use->userstory_ID)->get();
		foreach ($timevote as $timevote) {
			$html = $html.'<td>'.$timevote->timevote_value.'</td>';
		}
		}
		$html = $html . '</tr>';
	}      
	$html = $html . '<tr style="border-top:4px solid #000;"><td><b>Durchschnitt</b></td>';
	$usersavg = DB::table('userstory')->where('userstory_session_ID','=',$sess)->where('userstory_time_average','>',0)->get();
	foreach ($usersavg as $usersavg) {
		$html = $html.'<td><b>'.$usersavg->userstory_time_average.'</b></td>';
	}
	
	$html = $html . '</tr></table><br>';



	//Avg Time Table
	$userstory = DB::table('userstory')->where('userstory_session_ID','=',$sess)->get();
	$html = $html.'<table style="text-align:right; border: 2px solid #000; width:100%;"><tr style="border-bottom: 3px solid #000"><td><b>Zeit berechnet</b></td>';
	foreach ($userstory as $userstory) {
		$html = $html . '<td width="">'.$userstory->userstory_name.'</td>';
	}
	$html = $html. '</tr><tr>';
	$avgs = DB::table('userstory')->where('userstory_session_ID','=',$sess)->get();
		$html = $html . '<td>Zeit (min)</td>';
	foreach ($avgs as $avgs) {
		$html = $html . '<td>'.$avgs->calc_time.'</td>';
	}
	$html = $html . '</tr></table><br>';

//Sum & Rechnungs Tabelle
   $html = $html . '<table style="text-align:right; border: 2px solid #000; width:25%;"><tr>';
	$sess = DB::table('session')->where('session_ID','=',$sess)->get();
	foreach ($sess as $sess) {
		
		$html = $html.'<td>Avg Timeavg/PointAvg</td>';
		$html = $html.'<td><b>'.$sess->avg_time_div_avg.'</b></td></tr>';
		$html = $html.'<tr><td>Zeit Gesamt</td>';
		$html = $html.'<td><b>'.$sess->sum_calc_time.'</b></td></tr>';
	}
	$html = $html . '</table><br>';
*/
		$html = $html . '</body></html>';
	return PDF::load($html, 'A4', 'landscape')->show();
}
}