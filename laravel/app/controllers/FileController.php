<?php

class FileController extends Controller
{
	public $avgs= array();

	public function calculateAvg(){
		$sumvote = 0;
		$avgUs = 0;
		
		$ustory = DB::table('userstory')->take(10)->get();
		foreach ($ustory as $ustory) {
			$vote = DB::table('vote')->where('vote_userstory_ID', '=', $ustory->userstory_ID)->get();
			foreach ($vote as $vote) {
				$sumvote = $sumvote + $vote->value;
			}
			$avgUs = $sumvote/count($vote);
			dd($this->avgs);
			$this->avgs = array_add($this->avgs, $ustory->userstory_ID, $avgUs);
		}
		return $this->avgs;

	}

	
	public function showPDF()
{
	$this->calculateAvg();

	$user = DB::table('user')->take(10)->get();
	$userstory = DB::table('userstory')->take(10)->get();

    $html = '<html><body><table style="text-align:right; border: 2px solid #000; width:90%;"><tr><td>&nbsp;</td>';
    foreach ($userstory as $userstory) {
    	$html = $html . '<td>'.$userstory->userstory_name.'</td>';
    }
    $html = $html. '</tr>';
  	foreach ($user as $user)
	{
		$vote = DB::table('vote')->where('vote_user_id', '=', $user->user_ID)->get();
    	$html = $html . '<tr><td>' . $user->user_name . '</td>';
    	foreach ($vote as $vote) {
    		$html = $html.'<td>'.$vote->value.'</td>';
    	}

    	$html = $html . '</tr>';
	}      
	$html = $html . '<tr style="border-top:4px solid #000;"><td>Avg</td>';
	foreach ($this->avgs as $avgs => $value) {
		$html = $html.'<td>'.$value.'</td>';
	}
	$html = $html . '</tr>';
    $html = $html . '</table></body></html>';
    return PDF::load($html, 'A4', 'landscape')->show();
}
}