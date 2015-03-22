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
			$avgUsFormat = number_format($avgUs, 2, '.', '');
			$test = DB::table('userstory')->where('userstory_session_ID','=',$sess)->where('userstory_ID', '=', $ustory->userstory_ID)->get();
			
			//eintragen des ergebnisses in der DB
			DB::table('userstory')->where('userstory_session_ID','=',$sess)->where('userstory_ID', '=', $ustory->userstory_ID)->update(array('userstory_average' => $avgUsFormat));
			
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
				$avgTUsFormat = number_format($avgTUs, 2, '.', '');
			
			DB::table('userstory')->where('userstory_session_ID','=',$sess)->where('userstory_ID', '=', $ustory->userstory_ID)->update(array('userstory_time_average' => $avgTUsFormat));
	}
}

//Summe der Durchschnitte
	public function sumAvg($sess){
		$ustory = DB::table('userstory')->where('userstory_session_ID','=',$sess)->get();
		$sum = 0;
		foreach ($ustory as $ustory) {
			$sum += $ustory->userstory_average;
		}
		$sumFormat = number_format($sum, 2, '.', '');
		DB::table('session')->where('session_ID','=',$sess)->update(array('avg_sum'=>$sumFormat));
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
		$baseAvgFormat = number_format($baseAvg, 2, '.', '');
		DB::table('session')->where('session_ID','=',$sessio->session_ID)->update(array('avg_sum_base'=>$baseAvgFormat));
		}
		
	}

//Zeit Durchschnitt durch Vote Durchschnitt (Zeit pro SP für jede US)
	public function timeDivAvg($sess){
		$userstory = DB::table('userstory')->where('userstory_session_ID','=',$sess)->where('userstory_time_average','>',0)->get();
		foreach ($userstory as $userstory) {
			$newEntry = $userstory->userstory_time_average/$userstory->userstory_average;
			$newEntryFormat = number_format($newEntry, 2, '.', '');
			DB::table('userstory')->where('userstory_ID','=',$userstory->userstory_ID)->update(array('userstory_timeavg_div_avg'=>$newEntryFormat));
		}
	}

//Durchschnitt der timeDivAvg (Durchschnitt Zeit Pro SP)
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
			$avgTDAFormat = number_format($avgTDA, 2, '.', '');
			DB::table('session')->where('session_ID', '=', $ustory->userstory_session_ID)->update(array('avg_time_div_avg' => $avgTDAFormat));
			
		
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
				$calcTimeFormat = number_format($calcTime, 2, '.', '');
				DB::table('userstory')->where('userstory_ID','=',$us->userstory_ID)->update(array('calc_time' => $calcTimeFormat ));
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
			$sum = $sum/2;
			$sumFormat = number_format($sum, 2, '.', '');
			DB::table('session')->where('session_ID','=',$sessi->session_ID)->update(array('sum_calc_time' => $sumFormat ));
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
	$html = '<html><head><meta charset="utf-8"><style>.links{text-align:left;} .rechts{text-align:right;} tfoot{font-size: 24px; border-top: 2px #9b0000 solid; color:#9b0000;} thead{height: 90%;border-bottom: 2px #9b0000 solid} table{width:100%; text-align:center; margin-bottom: 20px;} .family{font-family:Helvetica;} .headers{font-weight:bold;color:#9b0000;font-size:28px;} h1{font-size: 50px;} h2{color:#9b0000; font-size:45px; page-break-before:always;} td{width:50%} .ustry{width:100%; border:2px #000 solid; text-align:center; font-size:23px;} .table{margin:auto;}</style></head><body class="family">';
	$html = $html.'<h1>Zusammenfassung</h1>';
	$sessio = DB::table('session')->where('session_ID','=',$sess)->get();
	foreach ($sessio as $sessio) {
	//Teilnehmer Tabelle
		$html = $html.'<table>';

		//moderator ausgeben
		$moderator = DB::table('moderator')->where('moderator_ID','=',$sessio->session_moderator_ID)->get();
		foreach ($moderator as $moderator) {
			$html = $html.'<tr class="headers"><td>'.$moderator->moderator_name.'</td></tr>';
		}

		//alle user ausgeben
		$user = DB::table('user')->where('user_session_ID','=',$sessio->session_ID)->get();
		foreach ($user as $user) {
			$html = $html.'<tr><td style="font-size:28px;">'.$user->user_name.'</td></tr>';
		}

		$html = $html.'</table>';

	//Vote Tabellen
		$html = $html.'<h2>Storypoints</h2>';
		//Userstory Tabellen erstellen
		$ustory = DB::table('userstory')->where('userstory_session_ID','=',$sessio->session_ID)->get();
		foreach ($ustory as $ustory) {
			$html = $html.'<table class="ustry"><thead  class="headers"><tr><td>User</td><td>'.$ustory->userstory_name.'</td></tr></thead>';


			//alle User
			$user = DB::table('user')->where('user_session_ID','=',$sessio->session_ID)->get();
			foreach ($user as $user) {
				//vote des users zur userstory
				$vote = DB::table('vote')->where('vote_user_ID','=',$user->user_ID)->where('vote_userstory_ID','=',$ustory->userstory_ID)->get();
				foreach ($vote as $vote) {
					if($vote->value != 'coffee' && $vote->value != '?'){
						$voteVal = (Double)$vote->value;
						$voteValFormat = number_format($voteVal, 2, '.', '');
					}else{
						$voteValFormat = $vote->value;
					}
					
					$html = $html.'<tr><td>'.$user->user_name.'</td><td class="rechts">'.$voteValFormat.'</td></tr>';
				}
				
			}
			$html = $html.'<tfoot><tr><td>Durchschnitt</td><td class="rechts">'.$ustory->userstory_average.'</td></tr></tfoot>';
			$html = $html.'</table>';
		}

	//Timevote Tabellen
		$html = $html.'<h2>Timevotes</h2>';
		//Userstory (nur mit timevotes) Tabellen erstellen
		$ustory = DB::table('userstory')->where('userstory_session_ID','=',$sessio->session_ID)->where('userstory_time_average','>',0)->get();
		foreach ($ustory as $ustory) {
			$html = $html.'<table class="ustry"><thead class="headers"><tr><td>User</td><td>'.$ustory->userstory_name.'</td></tr></thead>';


			//alle User
			$user = DB::table('user')->where('user_session_ID','=',$sessio->session_ID)->get();
			foreach ($user as $user) {
				//timevote des users zur userstory
				$timevote = DB::table('timevote')->where('timevote_user_id','=',$user->user_ID)->where('timevote_userstory_id','=',$ustory->userstory_ID)->get();
				foreach ($timevote as $timevote) {
					$timevoteVal = $timevote->timevote_value;
					$timevoteValFormat = number_format($timevoteVal, 2, '.', '');
					$html = $html.'<tr><td>'.$user->user_name.'</td><td class="rechts">'.$timevoteValFormat.' min.</td></tr>';
				}
				
			}
			$html = $html.'<tfoot><tr><td>Durchschnitt</td><td class="rechts">'.$ustory->userstory_time_average.' min.</td></tr></tfoot>';

			$html = $html.'</table>';
		}

		//Berechnete Zeiten
		$html = $html.'<h2>Berechnete Zeit</h2>';
		//alle userstorys

		$ustory = DB::table('userstory')->where('userstory_session_ID','=',$sessio->session_ID)->get();
		foreach ($ustory as $ustory) {
			$html = $html.'<table class="ustry"><thead class="headers"><tr><td>'.$ustory->userstory_name.'</td></tr></thead>';
			$html = $html.'<tr><td>'.$ustory->calc_time.' min.</td></tr></table>';
		}

		//Ergebnis Tabelle
		$html = $html.'<h2>Ergebnis</h2>';
		$html = $html.'<table class="ustry">';
			$html = $html.'<thead class="headers"><tr><td>Basestory</td></tr></thead>';
			$ustory = DB::table('userstory')->where('userstory_session_ID','=',$sessio->session_ID)->where('userstory_ID','=',$sessio->session_basestory_id)->get();
			foreach ($ustory as $ustory) {
				$html = $html.'<tr><td>'.$ustory->userstory_name.'</td></tr>';
			}
		$html = $html.'</table>';

		$html = $html.'<table class="ustry">';
		$html = $html.'<tr><td class="links">Durchschnitts Basestorypoints</td><td class>'.$sessio->avg_sum_base.'</td></tr>';
		$html = $html.'<tr><td class="links">Summe Durchschnitts Storypoints</td><td>'.$sessio->avg_sum.'</td></tr>';
		$html = $html.'<tr><td class="links">Zeit pro Storypoint</td><td>'.$sessio->avg_time_div_avg.' min.</td></tr>';
		$html = $html.'</table>';


		$html = $html.'<table class="ustry"><thead class="headers"><tr><td>Berechnete Zeit gesamt</td></tr></thead><tr><td>'.$sessio->sum_calc_time.' min.</td></tr></table>';
	}
	
		$html = $html.'<figure style="page-break-before:always; position:relative; left:10%; top:5%;"><img src="images/PPA_Logo-800-500.png"/></figure><figcaption style="position:relative; left:20%;">PlanningPokerApp - Larissa Reitler, Manuela Greifoner, Sabine Schimpf, Markus Zwettler</figcaption>';
		
		$html = $html . '</body></html>';
	return PDF::load($html, 'A4', 'landscape')->show();
}
}