<?php

use Classes\DB;

require_once('classes/DB.php');
require_once('templates/header.php');

if(isset($_POST['fact-body'])) {
	$body = htmlspecialchars($_POST['fact-body']);

	DB::_query('INSERT INTO facts (body) VALUES (:body)', [ 'body' => $body ]);
}

?>

<section class="facts">
	<div class="container">
		<?php
			// Select random column.
			$facts = DB::_query('SELECT facts.body, facts.id FROM facts ORDER BY RAND() LIMIT 1');
			
			foreach ($facts as $fact) {
				echo "<p data-id=".$fact['id'].">".$fact['body']."</p>";
			}
		?>
	</div>
	<div class="votes">
		<i class="fa fa-thumbs-up"></i>
		<i class="fa fa-thumbs-down"></i>
	</div>
	<span href="#" class="create-fact">Share your fact!</span>
</section>

<section class="facts-editor hide">
	<h1>Share your fact</h1>
	<span class="fa fa-arrow-left hide-facts-editor"></span>
	<div class="facts-editor-container">
		<form action="<?php htmlentities($_SERVER['PHP_SELF']) ?>" method="POST">
			<textarea name="fact-body" cols="30" rows="10" placeholder="What's going on?"></textarea>
			<input type="submit" value="Publish" />
		</form>
	</div>
</section>

<section class="facts-results hide">
	<div class="downvotes">
		<div class="score">
			<span></span>
		</div>
	</div>
	<div class="upvotes">
		<div class="score">
			<span></span>
		</div>
	</div>
</section>

<?php require_once('templates/footer.php'); ?>