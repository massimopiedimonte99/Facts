<?php

use Classes\DB;

require_once('classes/DB.php');

// Increase upvotes.
if(isset($_POST['factID']) && !isset($_POST['downvote'])) {
	$fact_id = htmlspecialchars($_POST['factID']);

	DB::_query('UPDATE facts SET upvotes = upvotes + 1 WHERE id = :fact_id', [ 'fact_id' => $fact_id ]);
}

// Increase downvotes.
if(isset($_POST['factID']) && isset($_POST['downvote'])) {
	$fact_id = htmlspecialchars($_POST['factID']);

	DB::_query('UPDATE facts SET downvotes = downvotes + 1 WHERE id = :fact_id', [ 'fact_id' => $fact_id ]);
}