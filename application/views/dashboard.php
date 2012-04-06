<?php include_once('head.tpl'); ?>
<body>
<link rel="stylesheet" href="<?php echo static_url('css/mapbox/leaflet.css'); ?>">
<?php include_once('navigation.tpl'); ?>

<section class="v-dashboard" role="main">
	<h1 class="logo"><img src="<?php echo static_url('img/intro.svg'); ?>" alt="Ghendetta" /></h1>

		<?php if(!$this->ghendetta->current_user()): ?>
		<p class="foursquare">
			<a href="<?php echo site_url('foursquare'); ?>">Connect &amp; Conquer</a>
			Connect with Foursquare and play.
		</p>
		<div class="message notice">
			<p><strong>Warning:</strong> play at your own risk. This is very much &beta;. Lives (or game data) might be lost. <small>But we respect your privacy, and your Foursquare data is safe!</small></p>
		</div>
		<?php else: ?>
		<p class="clan">You are with the <a href="/clan" style="background:#<?php echo $clan['color']; ?>"><?php echo $clan['name']; ?></a> clan.</p>
		<div class="tutorial">
			<dl class="legend cf">
				<dt><img src="<?php echo static_url('img/ico_battle.png'); ?>" alt="" /></dt>
				<dd>Your battles</dd>
			</dl>
			<h2>How To Play</h2>
			<p>Every visit to another district (check-in on Foursquare) gives you a chance to take away a district from a rivaling clan.</p>
		</div>
		<?php endif; ?>

	<ul class="leaderboard cf">
		<?php foreach($clans as $clan): ?>
		<li><img src="<?php echo $clan['logo']; ?>" alt="" /><?php echo $clan['name']; ?></li>
		<?php endforeach; ?>
	</ul>
</section>

<section id="map" class="v-dashboard-map"></section>

<?php include_once('footer.tpl'); ?>

<script src="<?php echo static_url('js/mapbox.min.js?v=010401'); ?>"></script>

</body>
</html>