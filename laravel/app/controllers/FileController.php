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

	
	public function showPDF()
{
	$this->calculateAvg();
	$this->sumAvg();
	$this->sumAvgBase();

	$user = DB::table('user')->where('user_session_ID','=',1)->get();
	$userstory = DB::table('userstory')->where('userstory_session_ID','=',1)->get();

    $html = '<html><body><table style="text-align:right; border: 2px solid #000; width:100%;"><tr style="border-bottom: 3px solid #000"><td>&nbsp;</td>';
    foreach ($userstory as $userstory) {
    	$html = $html . '<td width="">'.$userstory->userstory_name.'</td>';
    }
    $html = $html. '</tr>';
    
  	foreach ($user as $user)
	{$html = $html . '<tr><td>' . $user->user_name . '</td>';
		$use = DB::table('userstory')->where('userstory_session_ID','=',1)->take(10)->get();
		foreach($use as $use){
			$vote = DB::table('vote')->where('vote_user_ID','=',$user->user_ID)->where('vote_userstory_ID', '=', $use->userstory_ID)->get();
    	foreach ($vote as $vote) {
    		$html = $html.'<td>'.$vote->value.'</td>';
    	}
		}
    	$html = $html . '</tr>';
	}      
	$html = $html . '<tr style="border-top:4px solid #000;"><td><b>Durchschnitt</b></td>';
	$usersavg = DB::table('userstory')->where('userstory_session_ID','=',1)->take(10)->get();
	foreach ($usersavg as $usersavg) {
		$html = $html.'<td><b>'.$usersavg->userstory_average.'</b></td>';
	}
	$html = $html . '</tr></table><br>';



   $html = $html . '<table style="text-align:right; border: 2px solid #000; width:25%;"><tr>';
    $sess = DB::table('session')->where('session_ID','=',1)->get();
    foreach ($sess as $sess) {
    	$html = $html.'<td>Summe Durchschnitte</td>';
    	$html = $html.'<td><b>'.$sess->avg_sum.'</b></td>';
    	$html = $html.'</tr><tr><td>Summe * Avg Base</td>';
    	$html = $html.'<td><b>'.$sess->avg_sum_base.'</b></td>';
    }
    

    $html = $html . '</tr></table>';

        $html = $html . '</body></html>';
    return PDF::load($html, 'A4', 'landscape')->show();
}
}