<div class="container__tab">
		<div class="tab__wrapper">
			<div class="nav__tabs">
				<button data-tab="0" class="nav__tab active">Скидки</button>
				<button data-tab="1" class="nav__tab">Хиты</button>
				<button data-tab="2" class="nav__tab">Новинки</button>
			</div>
			<div class="tab-content">
				<div data-tab-content="0" class="tab-pane active">
					<div class="products__container">
						<?php 
						echo do_shortcode('[sale_products]'); 
						?>
					</div>		
					<a class='tabProduct__btn'>Показать еще</a>
				</div>
				<div data-tab-content="1" class="tab-pane">
					<div class="products__container">
						<?php 
						echo do_shortcode('[featured_products per_page="12" columns="4"]'); 
						?>
					
					</div>
					<a class='tabProduct__btn'>Показать еще</a>
				</div>
				<div data-tab-content="2" class="tab-pane">
					<div class="products__container">
							<?php 
						echo do_shortcode('[recent_products per_page="12" columns="4"]'); 
						?>
					</div>
					<a class='tabProduct__btn' >Показать еще</a>
				</div>
			</div>
		</div>
</div>