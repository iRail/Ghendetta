<!doctype html>
<html>
<head>
	<title>Ghendetta</title>
	<meta charset="utf-8">
	
	<link rel="stylesheet" href="css/1140.css" media="screen" />
	<link rel="stylesheet" href="css/styles.css" media="screen" />
	<script src="js/css3-mediaqueries.js"></script>

</head>
<body>

<div id="sidebar">
	<img src="img/logo.png" id="logo">
	
	<div id="login">
		<p id="welcome">Welcome, Godfather!</p>
	</div>
	
	<?php if(!$this->ghendetta->current_user()): ?>
		<a href="<?php echo site_url('foursquare/auth'); ?>"><img src="img/connect-white.png" id="foursquare"></a>
	<?php else: ?>
		<a href="#" class="button">Manage your Clan</a>
	<?php endif; ?>
	
	<div id="leadingclans">
		<ul>
			<li><img src="img/wapenschild4.png">Turtles</li>
			<li><img src="img/wapenschild2.png">iRail</li>
			<li><img src="img/wapenschild3.png">GhentMob</li>
			<li><img src="img/wapenschild1.png">DriveBy</li>
		</ul>
	</div>
</div>

<div id="map_canvas"></div>

<script src="js/jquery.js"></script>
<script src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="js/application.js"></script>
<script src="js/battlefield.js"></script>
<script>
var battlefield = <?php echo json_encode($battlefield); ?>;

$(document).ready(function() {
    visualize(battlefield);
});
</script>

</body>
</html>