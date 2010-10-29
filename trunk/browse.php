<?php 
	include ('lib/twitese.php');
	$title = "Public";
	include ('inc/header.php');
	if (!loginStatus()) header('location: login.php');
?>

<script type="text/javascript" src="js/browse.js"></script>

<div id="statuses" class="column round-left">

	<h2 id="browse_title">See what people are saying about…</h2>
	<div class="clear"></div>
	
	<?php 
		$t = getTwitter();
		$p = 1;
		if (isset($_GET['p'])) {
			$p = (int) $_GET['p'];
			if ($p <= 0) $p = 1;
		}
	
		$statuses = $t->browse($p);
		if ($statuses === false) {
			header('location: error.php');exit();
		} 
		$empty = count($statuses) == 0? true: false;
		if ($empty) {
			echo "<div id=\"empty\">No tweet to display.</div>";
		} else {
			$output = '<ol class="timeline" id="allTimeline">';
			
			foreach ($statuses as $status) {
				$date = formatDate($status->created_at);
				$text = formatText($status->text);
				
				$output .= "
					<li>
						<span class=\"status_author\">
							<a href=\"user.php?id=$status->screen_name\" target=\"_blank\"><img src=\"".getAvatar($status->profile_img_url)."\" title=\"$status->screen_name\" /></a>
						</span>
						<span class=\"status_body\">
							<span class=\"status_id\">$status->id</span>
							<span class=\"status_word\"><a class=\"user_name\" href=\"user.php?id=$status->screen_name\">$status->screen_name</a> $text </span>
							";
				$output .= recoverShortens($text);
				$output .= "
							<span class=\"actions\">
								<a class=\"replie_btn\" href=\"a_reply.php?id=$status->id\">Reply</a><a class=\"rt_btn\" href=\"a_rt.php?id=$status->id\">Retweet</a><a class=\"favor_btn\" href=\"a_favor.php?id=$status->id\">Favorite</a></span>
						<span class=\"status_info\">
								<span class=\"source\">via $status->source</span>
								<span class=\"date\"><a href=\"status.php?id=$status->id\" target=\"_blank\">$date</a></span>
						    </span>
						</span>
					</li>
				";
			}
			
			$output .= "</ol><div id=\"pagination\">";

			if ($p >1) $output .= "<a id=\"more\" class=\"round more\" style=\"float: left;\" href=\"browse.php?p=" . ($p-1) . "\">Back</a>";
			if (!$empty) $output .= "<a id=\"more\" class=\"round more\" style=\"float: right;\" href=\"browse.php?p=" . ($p+1) . "\">Next</a>";
			
			$output .= "</div>";
			
			echo $output;
		}
		
		
		
	?>
</div>

<?php 
	include ('inc/sidebar.php');
?>

<?php 
	include ('inc/footer.php');
?>