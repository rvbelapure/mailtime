<?php

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

function authenticate_and_fetch_data($username,$password) 
{

	$hostname = '{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX';

	$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

	$date = date ( "d M Y", strToTime ( "-1 week" ) );
	$emails = imap_search ( $inbox, "SINCE \"$date\"");
	$json_data = '';

	if($emails) 
	{
		rsort($emails);
		$post_data = '';
		$arr = array();
		foreach($emails as $email_number) 
		{
			$overview = imap_fetch_overview($inbox,$email_number,0);
			$header = imap_headerinfo($inbox,$email_number);
			$fromaddr = '';
			$unixdate = 0;
			$imp = 0;

			if($header->from)
				$fromaddr =  $header->from[0]->mailbox."@".$header->from[0]->host;
			if($header->udate)
				$unixdate = $header->udate;
			if($header->Flagged == 'F')
				$imp = 1;

			$post_data = array('from' => $fromaddr,
				'date' => $unixdate,
				'important' => $imp);
			array_push($arr, $post_data);
		}
		$json_data = json_encode(array("email" => $arr));
	}
	imap_close($inbox);
	return $json_data;
}
echo authenticate_and_fetch_data($_POST['uname'],$_POST['passwd']);
//echo authenticate_and_fetch_data("mailtimetest","cs8803soc");
?>