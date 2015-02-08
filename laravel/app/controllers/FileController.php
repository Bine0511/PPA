<?php

class FileController extends Controller
{



	public function calculateAvg(){
		$ustory = DB::table('userstory')->where('userstory_session_ID','=',1)->get();
		foreach ($ustory as $ustory) {
			$sumvote = 0;
			$avgUs = 0;
			
			$count = 0;
			$vote = DB::table('vote')->where('vote_userstory_ID', '=', $ustory->userstory_ID)->get();
			foreach ($vote as $vote) {
				//dd($vote->value);
				$sumvote = $sumvote + $vote->value;
				$count += 1;
			}

			
			$avgUs = $sumvote/$count;
			DB::table('userstory')->where('userstory_ID', '=', $ustory->userstory_ID)->update(array('userstory_average' => $avgUs));
			
		}
	}

	public function calcTimeAvg(){
		$ustory = DB::table('userstory')->where('userstory_session_ID','=',1)->get();
		foreach ($ustory as $ustory) {
			$sumTvote = 0;
			$avgTUs = 0;
			$Tcount = 0;
			$timevote = DB::table('timevote')->where('timevote_userstory_ID', '=', $ustory->userstory_ID)->whereNotNull('timevote_value')->get();
			foreach ($timevote as $timevote) {
					$sumTvote = $sumTvote + $timevote->timevote_value;
					$Tcount += 1;
			}
			if($Tcount != NULL){
				$avgTUs = $sumTvote/$Tcount;
			}else{
				$avgTUs = 0;
			}
			
			DB::table('userstory')->where('userstory_ID', '=', $ustory->userstory_ID)->update(array('userstory_time_average' => $avgTUs));
	}
}

	public function sumAvg(){
		$ustory = DB::table('userstory')->where('userstory_session_ID','=',1)->get();
		$sum = 0;
		foreach ($ustory as $ustory) {
			$sum += $ustory->userstory_average;
		}
		DB::table('session')->where('session_ID','=',1)->update(array('avg_sum'=>$sum));
	}

	public function sumAvgBase(){
		$baseAvg = 0;
		$baseSum = 0;
		$baseCount = 0;
		$sessio = DB::table('session')->where('session_ID','=',1)->get();
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

	public function timeDivAvg(){
		$userstory = DB::table('userstory')->where('userstory_session_ID','=',1)->where('userstory_time_average','>',0)->get();
		foreach ($userstory as $userstory) {
			$newEntry = $userstory->userstory_time_average/$userstory->userstory_average;
			DB::table('userstory')->where('userstory_ID','=',$userstory->userstory_ID)->update(array('userstory_timeavg_div_avg'=>$newEntry));
		}
	}

	public function avgTimeDivAvg(){
			$sumTDA = 0;
			$avgTDA = 0;
			$TDAcount = 0;
		$ustory = DB::table('userstory')->where('userstory_session_ID','=',1)->where('userstory_time_average','>',0)->get();
		foreach ($ustory as $ustory) {
			$sumTDA = $sumTDA + $ustory->userstory_timeavg_div_avg;
			$TDAcount += 1;
		}
			$avgTDA = $sumTDA/$TDAcount;
			DB::table('session')->where('session_ID', '=', $ustory->userstory_session_ID)->update(array('avg_time_div_avg' => $avgTDA));
			
		
	}

	public function calcTime(){
		$sess = DB::table('session')->where('session_id','=',1)->get();
		foreach ($sess as $sess) {
			$us = DB::table('userstory')->get();
			foreach ($us as $us) {
				$calcTime = $us->userstory_average*$sess->avg_time_div_avg;
				DB::table('userstory')->where('userstory_ID','=',$us->userstory_ID)->update(array('calc_time' => $calcTime ));
			}
		}
	}

	public function sumCalcTime(){
		$sess = DB::table('session')->where('session_id','=',1)->get();
		foreach ($sess as $sess) {
			$us = DB::table('userstory')->get();
			$sum = 0;
			foreach ($us as $us) {
				$sum = $sum + $us->calc_time;
			}
			DB::table('session')->where('session_ID','=',$sess->session_ID)->update(array('sum_calc_time' => $sum ));
		}
	}

	public function buildPDF(){
		
	}

	
	public function showPDF()
{
	$this->calculateAvg();
	$this->calcTimeAvg();
	$this->sumAvg();
	$this->sumAvgBase();
	$this->timeDivAvg();
	$this->avgTimeDivAvg();
	$this->calcTime();
	$this->sumCalcTime();

	$this->buildPDF();

//Vote Tabelle
	$user = DB::table('user')->where('user_session_ID','=',1)->get();
	$userstory = DB::table('userstory')->where('userstory_session_ID','=',1)->get();


	$html = '<html><head><meta charset="utf-8"></head><body><table style="text-align:right; border: 2px solid #000; width:100%;"><tr style="border-bottom: 3px solid #000"><td><b>Punkte Schätzung</b></td>';
	foreach ($userstory as $userstory) {
		$html = $html . '<td width="">'.$userstory->userstory_name.'</td>';
	}
	$html = $html. '</tr>';
	
	foreach ($user as $user)
	{$html = $html . '<tr><td>' . $user->user_name . '</td>';
		$use = DB::table('userstory')->where('userstory_session_ID','=',1)->get();
		foreach($use as $use){
			$vote = DB::table('vote')->where('vote_user_ID','=',$user->user_ID)->where('vote_userstory_ID', '=', $use->userstory_ID)->get();
		foreach ($vote as $vote) {
			$html = $html.'<td>'.$vote->value.'</td>';
		}
		}
		$html = $html . '</tr>';
	}      
	$html = $html . '<tr style="border-top:4px solid #000;"><td><b>Durchschnitt</b></td>';
	$usersavg = DB::table('userstory')->where('userstory_session_ID','=',1)->get();
	foreach ($usersavg as $usersavg) {
		$html = $html.'<td><b>'.$usersavg->userstory_average.'</b></td>';
	}
	$html = $html . '</tr></table><br>';

//TimeVote Tabelle
	$users = DB::table('user')->where('user_session_ID','=',1)->get();
	$userstorys = DB::table('userstory')->where('userstory_session_ID','=',1)->where('userstory_time_average','>',0)->get();
	$html = $html . '<table style="text-align:right; border: 2px solid #000; width:100%;"><tr style="border-bottom: 3px solid #000"><td><b>Zeitschätzung</b></td>';
	foreach ($userstorys as $userstorys) {
		$html = $html . '<td width="">'.$userstorys->userstory_name.'</td>';
	}
	$html = $html. '</tr>';
	
	foreach ($users as $users)
	{$html = $html . '<tr><td>' . $users->user_name . '</td>';
		$use = DB::table('userstory')->where('userstory_session_ID','=',1)->get();
		foreach($use as $use){
			$timevote = DB::table('timevote')->where('timevote_user_ID','=',$users->user_ID)->where('timevote_userstory_ID', '=', $use->userstory_ID)->get();
		foreach ($timevote as $timevote) {
			$html = $html.'<td>'.$timevote->timevote_value.'</td>';
		}
		}
		$html = $html . '</tr>';
	}      
	$html = $html . '<tr style="border-top:4px solid #000;"><td><b>Durchschnitt</b></td>';
	$usersavg = DB::table('userstory')->where('userstory_session_ID','=',1)->where('userstory_time_average','>',0)->get();
	foreach ($usersavg as $usersavg) {
		$html = $html.'<td><b>'.$usersavg->userstory_time_average.'</b></td>';
	}
	
	$html = $html . '</tr></table><br>';



	//Avg Time Table
	$userstory = DB::table('userstory')->where('userstory_session_ID','=',1)->get();
	$html = $html.'<table style="text-align:right; border: 2px solid #000; width:100%;"><tr style="border-bottom: 3px solid #000"><td><b>Zeit berechnet</b></td>';
	foreach ($userstory as $userstory) {
		$html = $html . '<td width="">'.$userstory->userstory_name.'</td>';
	}
	$html = $html. '</tr><tr>';
	$avgs = DB::table('userstory')->where('userstory_session_ID','=',1)->get();
		$html = $html . '<td>Zeit (min)</td>';
	foreach ($avgs as $avgs) {
		$html = $html . '<td>'.$avgs->calc_time.'</td>';
	}
	$html = $html . '</tr></table><br>';

//Sum & Rechnungs Tabelle
   $html = $html . '<table style="text-align:right; border: 2px solid #000; width:25%;"><tr>';
	$sess = DB::table('session')->where('session_ID','=',1)->get();
	foreach ($sess as $sess) {
		
		$html = $html.'<td>Avg Timeavg/PointAvg</td>';
		$html = $html.'<td><b>'.$sess->avg_time_div_avg.'</b></td></tr>';
		$html = $html.'<tr><td>Zeit Gesamt</td>';
		$html = $html.'<td><b>'.$sess->sum_calc_time.'</b></td></tr>';
	}
	$html = $html . '</table><br>';

		$html = $html . '</body></html>';
	return PDF::load($html, 'A4', 'landscape')->show();
}
}