<?php include_once('head.tpl'); ?>
<body>
<link rel="stylesheet" href="<?php echo static_url('css/mapbox/leaflet.css'); ?>">
<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo static_url('css/mapbox/leaflet.ie.css'); ?>" /><![endif]-->

<?php include_once('navigation.tpl'); ?>

<section class="v-map">
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

<script>
	var base_url = '<?php echo base_url(); ?>';
	var site_url = '<?php echo site_url(); ?>';
	var static_url = '<?php echo static_url(); ?>';
</script>

<?php include_once('footer.tpl'); ?>

<script src="<?php echo static_url('js/mapbox.min.js?v=300401'); ?>"></script>

</body>
</html>