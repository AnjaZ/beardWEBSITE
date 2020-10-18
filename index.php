<?php
  include "views/fixed/head.php";
  include "views/fixed/nav.php";
  include "config/connection.php";

  if(isset($_GET['page'])){
    switch($_GET['page'])
    {
		case 'Početna': 
			include "views/pages/home.php";
			break;
		case 'Pitanja': 
			include "views/pages/blog.php";
			break;
		case 'Product': 
			include "views/pages/product.php";
			break;
		case 'Prodavnica': 
			include "views/pages/shop.php";
			break;
		case 'Cart': 
			include "views/pages/cart.php";
			break;
		case 'Checkout': 
			include "views/pages/checkout.php";
			break;
		// case 'Kontakt': 
		// 	include "views/pages/contact.php";
		// 	break;
		case 'Rezultati': 
			include "views/pages/gallery.php";
			break;
		default:
			include "views/pages/home.php";
    }
	} else {
		include "views/pages/home.php";
	}
	include "views/fixed/footer.php";
?>

    

