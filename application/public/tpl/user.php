<!DOCTYPE html>
<html lang="ca">
<head>
	<title>trav agency-users</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="{APP_W}/application/public/css/estil.css">
	<!-- jQuery library (served from Google) -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <!-- bxSlider Javascript file -->
        <script src="{APP_W}/application/public/js/jquery.bxslider.min.js"></script>
        <!-- bxSlider CSS file -->
        <link href="{APP_W}/application/public/css/jquery.bxslider.css" rel="stylesheet" />
        <script>
            $(document).ready(function(){
                $('.bxslider').bxSlider();
            });
        </script>
</head>
<body>

	<div id="container">

		<div id="header">
                    <div id="ident"><ul><li><a href="#">Login&nbsp;</a></li><li><a href="#">&nbsp;Cistell</a></li></ul></div>
			<h1 style="margin-bottom:0;">Travel Agency - Users</h1>
		</div>
		
		<div id="menu">
			<ul>
				<a href="#"><li>Hotels</li></a>
				<a href="#"><li>Clients</li></a>
				<a href="#"><li>Plans</li></a>
				<a href="#"><li>Vols</li></a>
			</ul>
			</div>

		<div id="content" >
                    <div id="slide">
                        <ul class="bxslider">
                            <li><img src="{APP_W}/application/public/img/pic1.jpg" /></li>
                            <li><img src="{APP_W}/application/public/img/pic2.jpg" /></li>
                            <li><img src="{APP_W}/application/public/img/pic3.jpg" /></li>
                            <li><img src="{APP_W}/application/public/img/pic1.jpg" /></li>
                        </ul>
                    </div>
		Content goes here</div>

		<div id="footer" >
		<h6>Copyright © Albagency</h6></div>

	</div>
 
</body>
</html>