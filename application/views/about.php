<?php include_once('head.tpl'); ?>
<body>
<?php include_once('navigation.tpl'); ?>

<section class="container v-about" role="main">
	<div class="row">

		<nav class="c12 pageNav">
			<h1>About Ghendetta</h1>
			<ul>
				<li><a href="#howtoplay">How to Play</a></li>
				<li><a href="#origin">Game Origin</a></li>
				<li><a href="#technical">Technical Stuff</a></li>
				<li><a href="#name">Why &ldquo;Ghendetta&rdquo;?</a></li>
				<li><a href="#team">Team Awesome</a></li>
				<li><a href="#contact">Questions?</a></li>
			</ul>
		</nav>

		<div class="c7">
			<article id="howtoplay">
			   <h2>How to Play</h2>
				<p>
			        <strong>How do you play Ghendetta?</strong> Simple. You <a href="<?php echo site_url('foursquare'); ?>">log in with your foursquare account</a>. If you do not have an account, you can <a href="https://foursquare.com/signup/" rel="external" title="Sign up for a Foursquare account">sign up for one</a>.
				</p>

				<h3>The Clans</h3>
				<p>
					There are four clans in the game: the <em class="hawks">#Hawks</em>, the <em class="wolves">#Wolves</em>, the <em class="panthers">#Panthers</em> and the <em class="snakes">#Snakes</em>. You will start as an associate in the weakest clan in order to maintain the balance between the clans. Check-ins on Foursquare will be displayed as Battles on your map. Only the last seven days count. So you can lose territory quickly. Be loyal to your clan and your <a href="http://en.wikipedia.org/wiki/Caporegime" rel="external">Capo</a>. Fight as many battles as possible. Try to keep your clan&rsquo;s districts and try to take away districts of other clans by battling in their area. Finally, <strong>try to conquer the entire city</strong>.
			    </p>

				<h3>The Rules</h3>
			    <p>
			        Every Foursquare check-in counts as a battle. Every battle within a district also counts as one battle for that particular district. A clan can take over a district when the total number of battles fought by all of the clan members exceeds the number of battles fought by the former ruling clan. The <em>Capo</em> of a clan is the clan member with the highest score within that clan. Do you like some healthy competition? Then battle hard and try to become the next Capo.
				</p>
				<p>
					We encourage you to plan events or meetings with your fellow associates. It&#x27;s a great way to get to know new districts of our favourite city, make new friends, but above all: conquer new districts! Don&#x27;t forget: your battles will count <strong>for seven days</strong> only. So be sure to go back if you don&#x27;t want to lose your district.
			    </p>
			</article>

			<article id="origin">
			    <h2>Game Origin</h2>
			    <p>
					The basics of Ghendetta were entirely conceived and built in little under six hours at <a href="http://appsforghent.be" rel="external">Apps For Ghent 2012</a>. We have continued developing the game since then.
				</p>
				<p>
					The city of Ghent made a lot of data publicly available in 2011 and 2012. In order to promote the use of this data, the city helped organize Apps For Ghent for the second time in 2012. Teams of students were asked to compete in a hackathon to create a prototype of an application that uses Open Data. We entered the competition under the moniker &ldquo;Team <a href="http://irail.be" rel="external">iRail</a>&rdquo;. By the end of the day, we presented a working prototype of Ghendetta to a professional jury. We finished second, but we decided to continue developing the game because we really believed in its potential.
			    </p>
			</article>

			<article id="technical">
			    <h2>Technical Stuff</h2>
			    <p>
			        Now, for the geeky part. What technologies are we using? As much Open Source Software as is possible! Ghendetta runs on a regular <abbr title="Linux, Apache, MySQL and PHP">LAMP</abbr>-stack, hosted by <a href="http://ilibris.be" rel="external">iLibris</a>, thanks to <a href="http://irail.be" rel="external">iRail</a>. The entire game is built with the <a href="http://codeigniter.com" rel="external">CodeIgniter</a> PHP framework. And of course we use the <a href="http://developers.foursquare.com" rel="external">Foursquare API</a>. Check-ins are pushed to our application by Foursquare itself, so our data and displayed maps are always up-to-date. The beautiful maps by <a href="http://mapbox.com" rel="external">MapBox</a> are created by <a href="http://www.openstreetmap.org" rel="external">OpenStreetMaps</a> and contributors under a <a href="http://creativecommons.org/licenses/by-sa/2.0" rel="license">CC-BY-SA</a> license. The front-end is entirely HTML5.
			    </p>
			</article>
		</div>

		<div class="c5 last sidebar">
			<div class="inner">
				<article id="name">
				    <h2>Ghent + Vendetta</h2>
					<dl>
						<dt>Ghent |g&#x25B;nt|</dt><dd>[:A city in Belgium].</dd>
					    <dt>Vendetta |v&#x25B;n&#x2C8;d&#x25B;t&#x259;|</dt><dd>[:A blood feud between families or clans].</dd>
					</dl>
				</article>

				<article id="team">
					<h2>Team Awesome</h2>
					<ul class="cf">
						<li>
							<a href="http://twitter.com/account/redirect_by_id?id=65640580">
								<img src="https://api.twitter.com/1/users/profile_image?screen_name=hannesvdvreken&amp;size=bigger" width="73" height="73" alt="Hannes" />
								Hannes <b>Developer</b>
							</a>
						</li>
						<li>
							<a href="http://twitter.com/account/redirect_by_id?id=22241784">
								<img src="https://api.twitter.com/1/users/profile_image?screen_name=jenssegers&amp;size=bigger" width="73" height="73" alt="Jens" />
								Jens <b>Developer</b>
							</a>
						</li>
						<li>
							<a href="http://twitter.com/account/redirect_by_id?id=112554087">
								<img src="https://api.twitter.com/1/users/profile_image?screen_name=choisissez&amp;size=bigger" width="73" height="73" alt="Miet" />
								Miet <b>Designer</b>
							</a>
						</li>
						<li>
							<a href="http://twitter.com/account/redirect_by_id?id=20909514">
								<img src="https://api.twitter.com/1/users/profile_image?screen_name=xavez&amp;size=bigger" width="73" height="73" alt="Xavier" />
								Xavier <b>Designer</b>
							</a>
						</li>
					</ul>
				</article>

				<article id="contact">
					<h2>Questions?</h2>
				    <p>
				        Just ask via
				        <a href="http://twitter.com/account/redirect_by_id?id=537343166">Twitter</a>,
				        <a href="https://www.facebook.com/pages/Ghendetta/346514788727493">Facebook</a> or by
				        <a href="<?php echo site_url('email'); ?>">Email</a>.
				    </p>
					<p class="twitter">
						<a href="https://twitter.com/Ghendetta" class="twitter-follow-button" data-show-count="false" data-lang="en" data-size="large">Follow Ghendetta</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;
							js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</p>
				</article>
			</div>
		</div>
	</div>
</section>

<?php include_once('footer.tpl'); ?>

</body>
</html>