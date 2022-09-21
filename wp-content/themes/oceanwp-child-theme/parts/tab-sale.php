   <div class="tabSale__wrapper">
               <div class="navSale__tabs">
                    <button data-tab="0" class="navSale__tab active">Все</button>
                    <button data-tab="1" class="navSale__tab">Скидки</button>
                    <button data-tab="2" class="navSale__tab">Распродажа</button>
               </div>
               <div class="tabSale-content">
                    <div data-tab-content="0" class="tabSale-pane active">
                         <div class="tab-pane__content">
                           <?php 
						$sales = new WP_Query([
							'post_type' => 'stock'	
						]);
						$posts = $sales -> posts ;?>
						<?php foreach( $posts as $my_post ): ?>
							
							 <div class="cards__stocks"> 
								<?php
								$cards = carbon_get_post_meta( $my_post->ID, 'crb_stock' );
								?>
								<?php foreach( $cards as $card ): ?>
								 <div class="card__stock">
									<img src="<?php echo $card[ 'crb_image' ] ?>"/>
									<div class="stock__title"><?php echo $card[ 'title' ] ?></div>
									<div class="stock__time"><?php echo $card[ 'time' ] ?></div>	
								</div>
								 <?php endforeach; ?>
							 </div>			
					<?php endforeach; ?>
                         </div>
                    </div>
               <div data-tab-content="1" class="tabSale-pane">
                    <div class="tab-pane__content">
						<?php 
						$sales = new WP_Query([
							'post_type' => 'stock'	
						]);
						$posts = $sales -> posts ;?>
						<?php foreach( $posts as $my_post ): ?>
							<?php if($my_post->post_title == "Скидки"):?>
							 <div class="cards__stocks"> 
								<?php
								$cards = carbon_get_post_meta( $my_post->ID, 'crb_stock' );
								?>
								<?php foreach( $cards as $card ): ?>
								 <div class="card__stock">
									<img src="<?php echo $card[ 'crb_image' ] ?>"/>
									<div class="stock__title"><?php echo $card[ 'title' ] ?></div>
									<div class="stock__time"><?php echo $card[ 'time' ] ?></div>	
								</div>
								 <?php endforeach; ?>
							 </div>			
							<?php endif; ?>	
					<?php endforeach; ?>
                         </div>
                    </div>
                    <div data-tab-content="2" class="tabSale-pane">
                         <div class="tab-pane__content">
                           <?php 
						$sales = new WP_Query([
							'post_type' => 'stock'	
						]);
						$posts = $sales -> posts ;?>
						<?php foreach( $posts as $my_post ): ?>
							<?php if($my_post->post_title == "Распродажа"):?>
							 <div class="cards__stocks"> 
								<?php
								$cards = carbon_get_post_meta( $my_post->ID, 'crb_stock' );
								?>
								<?php foreach( $cards as $card ): ?>
								 <div class="card__stock">
									<img src="<?php echo $card[ 'crb_image' ] ?>"/>
									<div class="stock__title"><?php echo $card[ 'title' ] ?></div>
									<div class="stock__time"><?php echo $card[ 'time' ] ?></div>	
								</div>
								 <?php endforeach; ?>
							 </div>			
							<?php endif; ?>	
					<?php endforeach; ?>
                         </div>
                    </div>      
               </div>
          </div>