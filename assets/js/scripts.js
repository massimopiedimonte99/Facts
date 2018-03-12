$(document).ready(function() {
	
	// Display facts editor to create facts once you click on "Share your fact!"
	$('.create-fact').on('click', () => {
		$('.facts-editor').addClass('show-flex');
	});

	// Hide facts editor once you click on the left arrow.
	$('.hide-facts-editor').on('click', () => {
		if($('.facts-editor').has('.show-flex')) $('.facts-editor').removeClass('show-flex')
		$('.facts-editor').addClass('hide');
	});

	// Make an AJAX call to display the results and generate another random fact.
	function showVoteResults() {
		let factID = $('.facts').find('.container').find('p').attr('data-id'), t;

		$.ajax({
			type: 'POST',
			url: 'ajax_facts.php',
			data: { factID },
			success: function(data) {
				// results[0] => upvotes
				// results[1] => downvotes
				let results = JSON.parse(data);

				// Change text value.
				$('.facts-results').find('.upvotes').find('.score').find('span').html(results[0] + '%');
				$('.facts-results').find('.downvotes').find('.score').find('span').html(results[1] + '%');

				// Modify width of result bars according to the real results
				let count_upvotes = 50;
				let count_downvotes = 50;
				t = setInterval(() => {
					$('.facts-results').find('.upvotes').css('width', count_upvotes + '%');
					$('.facts-results').find('.downvotes').css('width', count_downvotes + '%');
					if(count_upvotes < results[0]) count_upvotes++;
					if(count_upvotes > results[0]) count_upvotes--;
					if(count_upvotes == results[0]) clearInterval(t);

					count_downvotes = 100 - count_upvotes;
				}, 10)	
				
				$('.facts-results').addClass('show-flex');
			}
		});

		
		
		setTimeout(() => { 
			$('.facts-results').removeClass('show-flex');
			$.ajax({
				type: 'POST',
				url: 'ajax_facts.php',
				success: function(data) {
					$('.facts').find('.container').html(data);
				}
			});
		}, 3000);
	}

	// Like system.
	$('.fa-thumbs-up').on('click', () => {
		let factID = $('.facts').find('.container').find('p').attr('data-id');

		$.ajax({
			type: 'POST',
			url: 'ajax_likes.php',
			data: { factID },
			success: function(data) {
				showVoteResults();
			}
		});
	});

	$('.fa-thumbs-down').on('click', () => {
		let factID = $('.facts').find('.container').find('p').attr('data-id');
		let downvote = true;

		$.ajax({
			type: 'POST',
			url: 'ajax_likes.php',
			data: { factID, downvote },
			success: function(data) {
				showVoteResults();
			}
		});
	});

});