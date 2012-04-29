<?php include_once('head.tpl'); ?>
<body>
<link rel="stylesheet" href="<?php echo static_url('css/mapbox/leaflet.css'); ?>">
<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo static_url('css/mapbox/leaflet.ie.css'); ?>" /><![endif]-->

<?php include_once('navigation.tpl'); ?>

<section class="v-dashboard" role="main">
	<h1 class="logo"><img src="<?php echo static_url('img/intro.svg'); ?>" alt="Ghendetta" /></h1>

	<?php if(!$this->auth->current_user()): ?>

	<p class="foursquare">
		<a href="<?php echo site_url('foursquare'); ?>">Connect &amp; Conquer</a>
		Connect with Foursquare and play.
	</p>
	<div class="message notice tutorial">
		<h2>How to Play</h2>
		<p>Connect. Check in. Watch the map.</p>
	</div>
	<div class="message">
		<p><strong>Warning:</strong> play at your own risk. This is very much &beta;. Lives (or game data) might be lost. <small>But we respect your privacy, and your Foursquare data is safe!</small></p>
	</div>

	<?php else: ?>

	<p class="clan">
		<img src="<?php echo $clan['shield']; ?>" height="48" />
		You are with the<br /><a href="<?php echo site_url('clan'); ?>" style="background:#<?php echo $clan['color']; ?>"><?php echo $clan['name']; ?></a> clan.
	</p>

	<section class="notifications">
	<?php foreach($notifications as $notification): ?>
		<article class="n-<?php echo $notification['type']; ?> <?php echo $notification['read'] ? 's-read' : 's-new'; ?>">
			<p>
				<?php
				switch($notification['type']) {
				    case 'region_lost':
				        echo $notification['data']['clan'] . ' just took <strong class="region">' . $notification['data']['region'] . '</strong> from us. Revenge will be sweet! <span class="date">' . date('j M H:i', $notification['date']) . '</span>';
				        break;
				    case 'region_won':
				        echo '<strong class="region">' . $notification['data']['region'] . '</strong> is now ' . $notification['data']['clan'] . ' territory. Like a boss. <span class="date">' . date('j M H:i', $notification['date']) . '</span>';
				        break;
				    case 'new_capo':
				        echo 'Swear oath before your new leader. <strong>' . $notification['data']['name'] . '</strong> just became Capo of your clan. <span class="date">' . date('j M H:i', $notification['date']) . '</span>';
						break;
					case 'rank_won':
				        echo 'Your fellow associate <strong>' . $notification['data']['name'] . '</strong> was just promoted. <span class="date">' . date('j M H:i', $notification['date']) . '</span>';
				        break;
                    case 'message':
				        echo 'Your capo <strong>' . $notification['data']['name'] . '</strong> says:<br /><strong>&quot;'. $notification['data']['message'] .'&quot;</strong><span class="date"><br />' . date('j M H:i', $notification['date']) . '</span></span>';
				        break;
				}
				?>
			</p>
		</article>
	<?php endforeach; ?>
	</section>

	<?php endif; ?>

</section>

<section class="v-dashboard-map">
	<h2 class="btn js-toggle-legend">Legend</h2></a>

	<div class="legend-holder cf">
		<dl class="legend">
			<?php if($this->auth->current_user()): ?>
			<dt class="chk battles"><img src="<?php echo static_url('img/ico_battle.svg'); ?>" alt="" /></dt>
				<dd class="chk battles">My Battles <input type="checkbox" /></dd>
			<dt class="chk specials"><img src="<?php echo static_url('img/ico_arena.svg'); ?>" alt="" /></dt>
				<dd class="chk specials">Arena <input type="checkbox" /></dd>
			<?php endif; ?>
			<?php foreach($clans as $clan): ?>
			<dt><img src="<?php echo $clan['shield']; ?>" alt="<?php echo $clan['name']; ?>" /></dt>
				<dd><?php echo $clan['name']; ?></dd>
			<?php endforeach; ?>
		</dl>
	</div>
	<div id="map"></div>
</section>

<?php include_once('footer.tpl'); ?>

<script src="<?php echo static_url('js/mapbox.min.js?v=300401'); ?>"></script>

</body>
</html>
