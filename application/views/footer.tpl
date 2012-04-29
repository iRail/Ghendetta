<?php 
    // get current user
    $ci = &get_instance();
    $user = $ci->auth->current_user();
?>

<script>
	var base_url = '<?php echo base_url(); ?>';
	var site_url = '<?php echo rtrim(site_url(), '/') . '/'; ?>';
	var static_url = '<?php echo static_url(); ?>';

<?php if($user): ?>
	var user = '<?php echo $user['fsqid']; ?>';
<?php endif; ?>
</script>

<script src="<?php echo static_url('js/jquery.js'); ?>"></script>
<script src="<?php echo static_url('js/application.min.js?v=240401'); ?>"></script>

<script type="text/javascript">
	var _gaq=[['_setAccount','UA-30544866-1'],['_trackPageview']];

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>