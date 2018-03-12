<?php

use Classes\DB;

require_once('classes/DB.php');

if(!isset($_POST['factID'])) {
	$facts = DB::_query('SELECT facts.body, facts.id FROM facts ORDER BY RAND() LIMIT 1');
			
	foreach ($facts as $fact) {
		echo "<p data-id=".$fact['id'].">".$fact['body']."</p>";
	}
}

if(isset($_POST['factID'])) {
	$fact_id = htmlspecialchars($_POST['factID']);

	$total_upvotes = DB::_query('SELECT facts.upvotes FROM facts WHERE id = :fact_id', [ 'fact_id' => $fact_id ])[0]['upvotes'];
	$total_downvotes = DB::_query('SELECT facts.downvotes FROM facts WHERE id = :fact_id', [ 'fact_id' => $fact_id ])[0]['downvotes'];

	$total = $total_upvotes + $total_downvotes;

	$total_upvotes_percentage = intval(($total_upvotes * 100) / $total);
	$total_downvotes_percentage = intval(($total_downvotes * 100) / $total);

	$results = array($total_upvotes_percentage, $total_downvotes_percentage);

	echo json_encode($results);
}