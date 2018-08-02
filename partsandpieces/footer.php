        </div><!-- #main -->
		<footer id="colophon">
        	<div class="container clearafter">
            	<div class="col right social">
                    <?php wp_nav_menu( array( 'theme_location' => 'social', 'menu_class' => 'socialnav' ) ); ?>
                </div>
                <div class="col nav">
                	<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'footernav') ); ?>
                </div>
                <?php 
	                $param = 'ct-referral-code';
					$thevar = $_GET[$param];
					$tiltparam = '';
					if (isset($_GET[$param])) {
					$tiltparam = '?' . $param . '=' . $thevar;
					}
				?>
                <div class="byline clear">
                	 <span class="copyright">&copy copyright <?php echo date("Y");?> Pixie</span><span class="b"> | </span><a href="/terms-of-use<?php echo $tiltparam;?>">Terms Of Use</a><span class="b"> | </span><a href="/eula<?php echo $tiltparam;?>">EULA</a>
                     <span class="hmgtag">Design and Digital Solutions provided by Horizon Marketing Group, Inc.</span>
                </div>
            </div>
         </footer>
         <!-- #colophon -->
         <!--EI -->
         <?php include('exit.php'); ?>
         
         <!--start individual tracking-->
         
         <?php if(get_field('tracking_scripts')){echo get_field('tracking_scripts');}  ?>
         
         <!-- end individual tracking-->
         <!-- Tilt -->
         <script type="text/javascript" src="https://open.tilt.com/checkout.js"></script>
         <!-- end Tilt -->
         <!-- Kissmetrics for Tilt Form -->
         <script type="text/javascript">
			_kmq.push(['trackSubmit', 'payment_form', 'Tilt Payment Form Submitted']);
			_kmq.push(['trackClick', '.play', 'Video Play Button Clicked']);
			_kmq.push(['trackClick', '.preorder', 'Pre-Order Button Clicked']);
		 </script>
         <!-- end Kissmetrics -->        
         <!-- start sitewide tracking -->
             <!-- adroll-->
             <script type="text/javascript">
            adroll_adv_id = "R6BTOZRFJNFVPGYUPT7VYL";
            adroll_pix_id = "X7NUMGBSQREPXH5WLW3RXE";
            (function () {
            var oldonload = window.onload;
            window.onload = function(){
               __adroll_loaded=true;
               var scr = document.createElement("script");
               var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
               scr.setAttribute('async', 'true');
               scr.type = "text/javascript";
               scr.src = host + "/j/roundtrip.js";
               ((document.getElementsByTagName('head') || [null])[0] ||
                document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
               if(oldonload){oldonload()}};
            }());
            </script>
 			<!-- /adroll-->
            <!-- google -->
            <script type="text/javascript">
			/* <![CDATA[ */
			var google_conversion_id = 961318823;
			var google_custom_params = window.google_tag_params;
			var google_remarketing_only = true;
			/* ]]> */
			</script>
			<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
			</script>
			<noscript>
			<div style="display:inline;">
			<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/961318823/?value=0&amp;guid=ON&amp;script=0"/>
			</div>
			</noscript>
            <script>
			  	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			
				ga('create', 'UA-52486279-1', 'auto', {'allowLinker': true});
				ga('require', 'linker');
				ga('linker:autoLink', ['pixie.tilt.com'] );
				ga('send', 'pageview');
			</script>
            <!-- /google -->
            
<?php
$productions_hosts = array(
    'www.pixie-technology.com',
    'pixie-technology.com',
    'www.getpixie.com',
    'getpixie.com',
    'www.pixie-www.herokuapp.com',
    'pixie-www.herokuapp.com'
);

$production = in_array($_SERVER['SERVER_NAME'], $productions_hosts);
if ($production) {
	KM::record('Site Visit'); 
?>
        <!--KM tracking-->
        <script>
			_kmq.push(["record","Viewed page",{"ID":<?php echo get_the_ID(); ?>,"Title":"<?php echo get_the_title( $ID ); ?>"}]);
        </script>
<?php
}
else{
	echo('<!--stage-->');
}
?>

		<!-- end sitewide tracking -->
<?php wp_footer(); ?>
</body>
</html>