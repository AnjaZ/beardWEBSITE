
<section class="ftco-menu mb-5 pb-5">
	<div class="container">
		<div class="row d-md-flex">
			<div class="col-lg-12 ftco-animate p-md-5">
				<div class="row">
					<div class="col-md-12 nav-link-wrap mb-5">
						<div class="nav ftco-animate nav-pills 			justify-content-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
								<a class="nav-link active" id="v-pills-0-tab" data-toggle="pill" href="#v-pills-0" role="tab" aria-controls="v-pills-0" aria-selected="true">proizvodi</a>    
								<!--<a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="false">Kits</a>-->
						</div>
					</div>

					<div class="col-md-12 d-flex align-items-center">
				
						<div class="tab-content ftco-animate" id="v-pills-tabContent">

							<div class="tab-pane fade show active" id="v-pills-0" role="tabpanel" aria-labelledby="v-pills-0-tab">

								<div class='container'>
									<div class="row">
										<?php
										include "config/connection.php";
										$upit ="SELECT * FROM proizvodi p INNER JOIN slike s ON p.idSlike=s.idSlike";
										$rezultat = $conn->query($upit);
										$proizvodi=$rezultat->fetchAll();
										foreach($proizvodi as $p):
										?>
											<div class="col-md-3">
													<div class="menu-entry">
																<a href="index.php?page=Product&id=<?=$p->idProizvoda?>" class="img" style="background-image: url(assets/images/<?= $p->putanja ?>);"></a>
																<div class="text text-center pt-4">
																	<h3><a href="index.php?page=Product&id=<?=$p->idProizvoda?>"> <?= $p->naziv ?></a></h3>
																	<p class="price"><span><?= $p->cena ?>din</span></p>
																	
																	<input type="button" class="btn btn-primary btn-outline-primary addtocart" value="Poruci odmah"  data-id="<?= $p->idProizvoda ?>" data-akcija="1">
																	<input type="button" class="btn btn-primary btn-outline-primary addtocart" value="Dodaj u korpu"  data-id="<?= $p->idProizvoda ?>">
																	
																	<input type="hidden" value="1" id="<?= $p->idProizvoda ?>">
																</div>
													</div>
											</div>
										<?php endforeach; ?>
											
											
									</div>
								</div>
								
							</div>
					
						</div>
					</div>
				
				</div>
			</div>
		</div>
	</div>
</section>
	
<section class="ftco-section ftco-services">
    	<div class="container">
    		<div class="row">
          <div class="col-md-6 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
              	<span class="flaticon-choices"></span>
              </div>
              <div class="media-body">
                <h3 class="heading">Jednostavno naručivanje</h3>
                <p>Uvek možete lako naručiti naše proizvode</p>
              </div>
            </div>      
          </div>
          <div class="col-md-6 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
              	<span class="flaticon-delivery-truck"></span>
              </div>
              <div class="media-body">
                <h3 class="heading">Besplatna dostava</h3>
                <p>Isporuka je u roku od dva do tri dana</p>
              </div>
            </div>      
          </div>
         <!-- <div class="col-md-4 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
              	<span class="flaticon-coffee-bean"></span></div>
              <div class="media-body">
                <h3 class="heading">Iz prirode</h3>
                <p>Svi naši proizvodi su sto posto prirodni</p>
              </div>
            </div>    
          </div>
        </div>-->
    	</div>
	</section>