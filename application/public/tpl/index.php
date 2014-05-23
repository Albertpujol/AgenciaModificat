<!DOCTYPE html>
session::init();
<html lang="ca">
<head>
	<title>trav agency</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="{APP_W}/application/public/css/estil.css">
	<!-- jQuery library (served from Google) -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script> 
        <script type="text/javascript" src="{APP_W}/application/public/tpl/main.js"></script>
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

        <?php
        
                if(!isset($_SESSION["usuari"]))
                {
               
                echo"<div id='container'>";
                echo"<div id='header'>";
                echo"<div id='ident'><ul><li><form method='POST' action='{APP_W}/index/login'>";
                echo"Email:<input type='text' name='email' id='email' required=''>";
                echo"password:<input type='password' name='password' id='password' required=''>";
                echo"<input type='submit' value='entrar' name='entrar'><a href='{APP_W}/register'>Registrar-se</a></li></ul></div>";
                        
                echo"</form>";
                echo"<div id='ident'><ul><li><a href=''>Login&nbsp;</a></li><li><a href=''>&nbsp;Cistell</a></li></ul></div>";
               // echo"<h1 style='margin-bottom:0;'>Travel Agency</h1>";
		echo"</div>";
                }else{
                /*if(Session::get('loggged' == true))
                {
                   echo Session::get('User')-> getNom();
                }*/
                   
                   echo"<div id='header'>";
                    echo"<p>Benvingut: ".$_SESSION["usuari"]."</p>";
                    echo"</div>";
                   echo"<div id='ident'><ul><li><a href='index/logout'>Tancar sessio&nbsp;</a></li></div>";
                }
                ?>
    
               <?php
                //if(isset($_SESSION["usuari"]))
               // {
                ?>
		    
                <html>
                <body>
	        <div id="menu">
			<ul>
				<a href='{APP_W}/index/view_hotels'><li>Hotels</li></a>
				<a href="{APP_W}/index/view_plans"><li>Plans</li></a>
				<a href="{APP_W}/index/view_vols"><li>Vols</li></a>
                                <a href="{APP_W}/reservas/cistell"><li>Cistell</li></a>
			</ul>;
			</div>
                    
                  <?php
                //}
                ?>
                 
		<div id="content" >
                    <div id="slide">
                        <ul class="bxslider">
                            <li><img src="{APP_W}/application/public/img/pic1.jpg" /></li>
                            <li><img src="{APP_W}/application/public/img/pic2.jpg" /></li>
                            <li><img src="{APP_W}/application/public/img/pic3.jpg" /></li>
                            <li><img src="{APP_W}/application/public/img/pic1.jpg" /></li>
                        </ul>
                    </div>
                    <div id="rss">
                        <load>Loading...</load>
                    </div>
                </div>
                    
                    
                    
                    

		<div id="footer" >
		<h6>Copyright © Albagency</h6></div>

	</div>
 </body>
</html>
                