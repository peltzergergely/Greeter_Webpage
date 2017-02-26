<!DOCTYPE html>
<html>
	<head>
		<title>Greeter</title>
		<!-- including the css and the google font -->
		<link href="https://fonts.googleapis.com/css?family=Roboto:500" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="script.js"></script>
		
		  <title>Greeter</title>
    <!-- You can use Open Graph tags to customize link previews.
    Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
  <meta property="og:url"           content="http://greeter.hostei.com/test.php" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Greeter" />
  <meta property="og:description"   content="SMS greetings - school project" />
  <meta property="og:image"         content="" />
	</head>
	<body>
	<!-- Facebook SDK -->
		<script>
			window.fbAsyncInit = function() {
				FB.init({
					appId      : '419230158424214',
					xfbml      : true,
					version    : 'v2.8'
				});
			FB.AppEvents.logPageView();
			};

		(function(d, s, id){
			 var js, fjs = d.getElementsByTagName(s)[0];
			 if (d.getElementById(id)) {return;}
			 js = d.createElement(s); js.id = id;
			 js.src = "//connect.facebook.net/en_US/sdk.js";
			 fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>
	<!-- End of Facebook SDK -->

		  <!-- Your share button code -->
  <div class="fb-share-button" 
    data-href="http://www.your-domain.com/your-page.html" 
    data-layout="button_count">
  </div>
  <!-- jsfiddlecode from here --> 
<script>
    function fbShare(url, title, descr, image, winWidth, winHeight) {
        var winTop = (screen.height / 2) - (winHeight / 2);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&p[url]=' + url + '&p[images][0]=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
    }
</script>
<a href="javascript:fbShare('http://jsfiddle.net/stichoza/EYxTJ/', 'Fb Share', 'Facebook share popup', 'http://goo.gl/dS52U', 520, 350)">Share</a>
  
	</body>
</html>
	