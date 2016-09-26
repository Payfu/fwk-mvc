<!DOCTYPE html>
<html lang="<?= App::getInstance()->lang; ?>">
  <head>
    <meta charset="utf-8">
    <title><?= $metaTitle ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $metaDescription ?>">
    <meta name="author" content="<?= App::getInstance()->author; ?>">
    <link rel="icon" type="image/png" href="favicon.png" />

    <!-- Le styles --> 
    <?php if(isset($scripts_css)){ echo $scripts_css; } ?>
    


  </head>
  <body>
 
	  <!-- Nav Bar -->
<nav class="navbar navbar-fixed-top navbar-light bg-faded">
	
	<div class="col-xs-12 hidden-sm-up">
		<a class="navbar-brand" href="#" id="logo">Name</a>
		<button class="navbar-toggler hidden-sm-up pull-right" type="button" data-toggle="collapse" data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle navigation">
		&#9776;
		</button>
	</div>
    
    
  <div class="collapse navbar-toggleable-xs" id="mobile-menu">
    
    <ul class="nav navbar-nav">
        <li class="nav-item">
        <a class="nav-link page-scroll" href="#home">Accueil</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link page-scroll" href="#particulier">Particuliers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link page-scroll" href="#pro">Professionnels</a>
      </li>
        
        <li class="nav-item hidden-sm-down" id="li-logo">
        <h1 class="nav-logo"><a href="">Name</a></h1>
      </li>
        
      <li class="nav-item">
        <a class="nav-link page-scroll" href="#portfolio">Portfolio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link page-scroll" href="#retrouvez">Retrouvez-nous</a>
      </li>
        <li class="nav-item">
        <a class="nav-link page-scroll" href="#contact">Contact</a>
      </li>
    </ul>
  </div>
</nav>
      

      

    <!-- container -->
    <div class="container-fluid">
        <?= $content; ?>
	    
	    
	    <!-- Footer -->
	    <footer class="section-footer">
		<div class="row">
			<div class="container">
				<div class="col-xs-12 copyright">
					<p><strong><?= App::getInstance()->copyright; ?></strong></p>
				</div>
			</div>
		</div>
	    </footer>
    </div>

     

    <!-- js scripts -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js"></script>  
    
<?php if(isset($scripts_js)){ echo $scripts_js; } ?>

    <!-- Google analytics -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-xxxxxx', 'auto');
      ga('send', 'pageview');

    </script>
  </body>
</html>

