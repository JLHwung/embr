<?php
	if(!isset($_SESSION)){
		session_start();
	}
	include ('lib/twitese.php');
	$title = "Search";
	include ('inc/header.php');

	function getSearch($query, $max_id_str){
		GLOBAL $output;
		$t = getTwitter();
		$result = $t->search($query, $max_id_str);
		$statuses = $result->statuses;
		$max_id_str = end($statuses)->id_str;
		$resultCount = count($statuses);
		if ($resultCount <= 0) {
			echo "<div id=\"empty\">No tweet to display.</div>";
		} else {
			include_once('lib/timeline_format.php');
			$output = '<ol class="timeline" id="allTimeline">';
			foreach ($statuses as $status) {
				$output .= format_timeline($status, $t->username);
			}
			$output .= "</ol><div id=\"pagination\"><a id=\"more\" class=\"round more\" style=\"float: right;\" href=\"search.php?q=".urlencode($query)."&maxid=" . $max_id_str . "\">Next</a></div>";
		}
	}

	if (!loginStatus()) header('location: login.php');
?>
<style>#trend_entries{display:block}</style>
<script src="js/search.js"></script>
<div id="statuses" class="column round-left">

	<form action="search.php" method="get" id="search_form">
		<input type="text" name="q" id="query" value="<?php echo $_GET['q'] ?>" />
		<input type="submit" class="more round" style="width: 103px; margin-left: 10px; display: block; float: left; height: 34px; font-family: tahoma; color: rgb(51, 51, 51);" value="Search">
	</form>
<?php
	$p = 1;
	if (isset($_GET['max_id'])) {
		$max_id = $_GET['max_id'];
	} else {
		$max_id = false;
	}
	$output = '';
	if (isset($_GET['q'])) {
		$q = $_GET['q'];
		getSearch($q, $max_id);
	}
	echo $output;
?>
</div>

<?php 
	include ('inc/sidebar.php');
	include ('inc/footer.php');
?>
