	</div>
	<div id="footer">
<?php

	// Add some function only active on the 
	// "php-addressbook.sourceforge.net" Demopage.

if($_SERVER['SERVER_NAME'] == "php-addressbook.sourceforge.net") { ?>
	<div class="right">
		<div id="download">
			<a href="../download"><b>Download</b></a> <?php echo "v$version"; ?>
		</div><br class="clear" />
	</div>
<?php } ?>
			<ul>
				<li><a href="http://sourceforge.net/projects/php-addressbook/">php-addressbook</a> <a href="notes.htm">v<?php echo $version; ?></a></li>
			</ul>
	</div>
</div>
<?php

	// Add some function only active on the 
	// "php-addressbook.sourceforge.net" Demopage.

if ($_SERVER['SERVER_NAME'] == "php-addressbook.sourceforge.net") { ?>
<script type="text/javascript" src="http://www.ohloh.net/projects/25477/widgets/project_partner_badge">
// ohloh.net "Project Value" integration
</script>
<script type="text/javascript">
	// Google-Analytics integration
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
	var pageTracker = _gat._getTracker("UA-6220233-1");
	pageTracker._trackPageview();
</script>        
<?php } ?>
	</body>
</html> 

<!-- 
Copyright Notice:
This script was written by Rob Minto, and is free to use and distribute under GPL. 
Any improvements, please email rob(at)widgetmonkey.com. 
Keep software free. 
And please leave this copyright notice. Thanks.

Major update 2007 by Olivier Chatelain, feel free to use and distribute under GPL. 
Any improvements, please email chatelao(at)users.sourceforge.net. 

Updated 2009 - Complete theme redesign by Leighton West. Any theme problems,
please email retrorobot(at)users.sourceforge.net.

Major contribution Mark James ("famfamfam"-icons)
For more details see: http://www.famfamfam.com/lab/icons/silk/
-->
