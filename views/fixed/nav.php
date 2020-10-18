<body>
  	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
		<img src="assets/images/logo.jpg" alt="logo" height="5%" width="7%">
	      <a class="navbar-brand mar" href="index.php">Viking<small>spirit</small></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
			
	        <ul class="navbar-nav ml-auto">
			<?php
				include "config/connection.php";
				$upit = "SELECT * FROM navigacija";
				$rezultat = $conn->query($upit);
				foreach($rezultat as $li) {
					if($li->naziv!="Cart"){
					echo "<li class='nav-item'><a href='$li->link?page=$li->naziv' class='nav-link'>$li->naziv</a></li>";
					}else{
					echo "<li class='nav-item cart'><a href='$li->link?page=$li->naziv' class='nav-link'><span class='icon icon-shopping_cart'></span><span class='bag d-flex justify-content-center align-items-center brojukorpi'>   </span></a></li>";
					} 
				}
			?>
			</ul>

	      </div>
		  </div>
	  </nav>