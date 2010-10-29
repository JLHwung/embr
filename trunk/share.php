<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Share to Embr</title>
<style type="text/css">
body {
h2 {
p {
a:active, a:focus {
a {
a:hover {
#tip {
#tip b {
#share {
#textbox {
#url {
.title {
table tr td {
#message {
#textbox:hover, #url:hover {
.more {
.more:hover{background-position:left -78px;border:1px solid #bbb;text-decoration:none}
.more:active{background-position:left -38px;color:#666}
.more.loading{background-color:#fff;background-image:url(../img/ajax.gif);background-position:50% 50%;background-repeat:no-repeat;border:1px solid #eee;cursor:default!important}
.more::-moz-focus-inner{border:0}
.round{-moz-border-radius:8px;border-radius:8px}
#shareBtn {
</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(function(){leaveWord();
	$("#textbox").focus();
	$("#textbox").keydown(function(){leaveWord(140);}).keyup(function(){leaveWord(140);})
});

function leaveWord(num) {
	if (!num) num = 140;
	var leave = num-$("#textbox").val().length;
	if (leave < 0) {
		$("#tip").html("<b>-" + (-leave) + "</b>");
	} else {
		$("#tip").html("<b>" + leave + "</b>");
		if (leave > 40) { 
			$("#tip, #tip b").css("color","#CCC");
		} else if(leave > 20) {
			$("#tip, #tip b").css("color","#CAA");
		} else if(leave > 10) {
			$("#tip, #tip b").css("color","#C88");
		} else if(leave > 0) {
			$("#tip, #tip b").css("color","#C44");
		} else {
			$("#tip, #tip b").css("color","#E00");
		}
	}
}
</script>
</head>

<body>
<?php
	if(!isset($_SESSION)){
		session_start();
	}
	include ('lib/twitese.php');
	$t = getTwitter();
	if ( isset($_POST['status']) ) {
		$status = $_POST['status'];
		if (mb_strlen($status,'utf-8') > 140) {
			$status = mb_substr($status, 0, 140, 'utf-8');
		}
		$shortUrl = shortUrl($_POST['url']);
		if ($shortUrl) {
			$status .= $shortUrl;
		} else {
			$status .= ' ' . $_POST['url'];
		}
		$result = $t->update($status);
	}
	
	$text = '';
	
	if ( isset($_GET['u']) ) {
		$url = $_GET['u'];
	}
	
	if ( isset($_GET['t']) ) {
		$title = $_GET['t'];
		$text = $_GET['t'];
	}
	
	if ( isset($_GET['d']) ) {
		$select = $_GET['d'];
		if ( trim($select) != "" ) $text = $select;
	}
	
	$text = $text;
	
	$siteUrl = str_replace('share', 'index', 'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER['PHP_SELF']);
	?>
	
<?php	
	function shareUrl($url, $type = "orzse") {
                switch ($type) {
                        case 'isgd':
                                $request = 'http://is.gd/api.php?longurl=' . rawurlencode($url);
                                $result = processCurl( $request );
                                if ($result) return $result;
                                else return false;
                                break;
                        case 'aacx':
                                $request = 'http://aa.cx/api.php?url=' . rawurlencode($url);
                                $result = processCurl( $request );
                                if ($result) return $result;
                                else return false;
                                break;
			case 'orzse':
                                $request = 'http://orz.se/api.php?format=simple&action=shorturl&url=' . 				rawurlencode($url);
                                $result = processCurl( $request );
                                if ($result) return $result;
                                else return false;
                                break;
                        default:
                                return false;
                }
        }

	?>
<div id="share">

	<?php if ( !$t->username ) {?>
		<div id="message">Please <a href="login.php" target="_blank">login</a> first.</div>
	<?php } else if ( isset($_POST['status']) ) { 
			if ($result) {
	?>
				<div id="message">Successfully shared your stuff on Rabr! <a href="javascript:window.close()">Close</a></div>
					<script type="text/javascript">
					setTimeout("window.close()",1000);
					</script>
		<?php } else { ?>
				<div id="message">Failed to share your stuff, please try again. <a href="javascript:window.history.go(-1)">Go Back</a></div>
		<?php 
			}
	   } else { 
	?>
		<form action="share.php" method="post">
		<table>
			<tr>
				<td colspan="2"><h2>Share to Rabr</h2><span id="tip"><b>140</b></span></td>
			</tr>
			<tr>
				<td><input type="text" name="url" id="url" disabled="ture" value="<?php echo $url?>"/></td>
			</tr>
			<tr>
			<td><textarea name="status" id="textbox"><?php echo $text?> <?php if (strlen($url)>30) echo shareUrl($url, "orzse"); else echo $url ?></textarea></td>
			</tr>
			<tr>
			<td>
				<input class="more round" id="shareBtn" type="submit" value="Share" />
				</td>
			</tr>
		</table>
		</form>
	<?php } ?>
</div>
</body>
</html>