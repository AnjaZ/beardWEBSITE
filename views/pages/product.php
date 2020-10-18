<section class="ftco-section down">
	<!--odavde-->		
	<div class="container">
    		<div class="row">
				<?php
					$id= $_GET['id'];
					include "config/connection.php";
					$upit ="SELECT * FROM proizvodi p INNER JOIN slike s ON p.idSlike=s.idSlike WHERE idProizvoda=:id";
					$izvrsenje=$conn->prepare($upit); 
					$izvrsenje->bindParam(":id",$id);
					$rezultat=$izvrsenje->execute();
					$proizvodi=$izvrsenje->fetch();
				
				?>
					<div class="col-lg-6 mb-5 ftco-animate">
						<a href="assets/images/<?= $proizvodi->putanja ?>" class="image-popup"><img src="assets/images/<?= $proizvodi->putanja ?>" class="img-fluid" alt="<?= $proizvodi->alt ?>"></a>
						
					</div>
					<div class="col-lg-6 product-details pl-md-5 ftco-animate">
						<h3><?= $proizvodi->naziv ?></h3>
						
						<p class="price"><span><?= $proizvodi->cena ?>din</span></p>
						<p> <?= $proizvodi->opis ?></p>
						
							<div class="row mt-4">
								<div class="col-md-6">
									<div class="form-group d-flex">
						<div class="select-wrap">
						<!--<div class="icon"><span class="ion-ios-arrow-down"></span></div>
						
						<select name="" id="" class="form-control">
							<option value="">Small</option>
							<option value="">Medium</option>
							<option value="">Large</option>
							<option value="">Extra Large</option>
						</select>-->
						</div>
						</div>
								</div>
								<div class="w-100"></div>
								<div class="input-group col-md-6 d-flex mb-3">
						<span class="input-group-btn mr-2">
							<button type="button" class="quantity-left-minus btn"  data-type="minus" data-field="">
						<i class="icon-minus"></i>
							</button>
							</span>
						<input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">
						<span class="input-group-btn ml-2">
							<button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
							<i class="icon-plus"></i>
						</button>
						</span>
					</div>
					
				
			
					<p><a href="#" data-id='<?= $proizvodi->idProizvoda ?>' class="btn btn-primary py-3 px-5 addcardmore">Dodaj u korpu</a></p>
				
    			</div>
    		</div>
    	</div><!-- dovde-->
</section>

    

