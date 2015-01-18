<?php

class FileController extends Controller
{

	
	public function showPDF()
{
$moderator = DB::table('moderator')->get();


    $html = '<html><body><table>';
  	foreach ($moderator as $moderator)
	{
    	$html = $html . '<tr><td>' . $moderator->moderator_name . '</td><td>'.$moderator->moderator_pw.'</td></tr>';
	}      
    $html = $html . '</table></body></html>';
    return PDF::load($html, 'A4', 'portrait')->show();
}
}