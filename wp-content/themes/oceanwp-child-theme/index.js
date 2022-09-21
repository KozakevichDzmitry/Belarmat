document.addEventListener("DOMContentLoaded", () => {
	console.log(1);
	const tabNavs = document.querySelector(".tab__wrapper");
	const tabsBtn = document.querySelectorAll(".nav__tab ");
	const tabsContent = document.querySelectorAll(".tab-pane");
	if (tabNavs) {
		tabNavs.addEventListener("click", (e) => {
			if (e.target.classList.contains("nav__tab")) {
				const tabsPath = e.target.dataset.tab;
				tabsHandler(tabsPath);
			}
		});
	}
	const tabsHandler = (press) => {
		tabsBtn.forEach((el) => {
			el.classList.remove("active");
		});
		document.querySelector(`[data-tab="${press}"]`).classList.add("active");
		tabsContent.forEach((el) => {
			el.classList.remove("active");
		});
		document
			.querySelector(`[data-tab-content="${press}"]`)
			.classList.add("active");
	};
	
	const tabSaleNavs = document.querySelector(".tabSale__wrapper"); 
     const tabsSaleBtn = document.querySelectorAll('.navSale__tab '); 
     const tabsSaleContent = document.querySelectorAll('.tabSale-pane'); 
     if (tabSaleNavs) { 
          tabSaleNavs.addEventListener('click', (e) => {
               if (e.target.classList.contains('navSale__tab')) {
                    const tabsSalePath = e.target.dataset.tab;
                     tabsSaleHandler(tabsSalePath) 
               }
          });
     };
     const tabsSaleHandler = (press) => {
          tabsSaleBtn.forEach(el => {
               el.classList.remove('active')
          });  
          document.querySelector(`[data-tab="${press}"]`).classList.add('active');
          tabsSaleContent.forEach(el => {
               el.classList.remove('active')
          }); 
          document.querySelector(`[data-tab-content="${press}"]`).classList.add('active'); 
     };
	
	
	const tabNaivs = document.querySelector(".characteristics__tab"); 
     const tabsBttn = document.querySelectorAll('.button__tab '); 
     const tabsConttent = document.querySelectorAll('.content__tab'); 
     if (tabNaivs) { 
          tabNaivs.addEventListener('click', (e) => {
               if (e.target.classList.contains('button__tab')) {
                    const tabsPaths = e.target.dataset.tab;
                    tabsHandlers(tabsPaths);
               }
          });
     };
     const tabsHandlers = (press) => {
          tabsBttn.forEach(el => {
               el.classList.remove('active')
          }); 
          document.querySelector(`[data-tab="${press}"]`).classList.add('active'); 
          tabsConttent.forEach(el => {
               el.classList.remove('active')
          }); 
          document.querySelector(`[data-tab-content="${press}"]`).classList.add('active'); 
     };
	
	
	
});

jQuery(document).ready(function ($) {
          $('.items__container').slick({
               slidesToShow: 4,
		  responsive: [
				{
				  breakpoint: 1148,
				  settings: {
					slidesToShow: 3,
				  }
				},
				{
				  breakpoint: 867,
				  settings: {
					  slidesToShow: 2,
					
				  }
				},
				{
				  breakpoint: 585,
				  settings: {
					 slidesToShow: 1,
				  }
				}
			  ]});
jQuery(document).ready(function ($) {
        $('.single-product .products.oceanwp-row').slick({
           slidesToShow: 4,
			
			responsive: [
				{
				  breakpoint: 1148,
				  settings: {
					slidesToShow: 3,
				  }
				},
				{
				  breakpoint: 867,
				  settings: {
					  slidesToShow: 2,
					
				  }
				},
				{
				  breakpoint: 585,
				  settings: {
					 slidesToShow: 1,
				  }
				}
			  ]
			
          });
		$('.page-id-689 .products.oceanwp-row.clr.grid').slick({
			slidesToShow: 4,
			responsive: [
				{
				  breakpoint: 1148,
				  settings: {
					slidesToShow: 3,
				  }
				},
				{
				  breakpoint: 867,
				  settings: {
					  slidesToShow: 2,
					
				  }
				},
				{
				  breakpoint: 585,
				  settings: {
					 slidesToShow: 1,
				  }
				}
			  ]
				  });
	
		$('.viewed__products .products.oceanwp-row.clr.grid').slick({
			slidesToShow: 4,
			responsive: [
				{
				  breakpoint: 1148,
				  settings: {
					slidesToShow: 3,
				  }
				},
				{
				  breakpoint: 867,
				  settings: {
					  slidesToShow: 2,
					
				  }
				},
				{
				  breakpoint: 585,
				  settings: {
					 slidesToShow: 1,
				  }
				}
			  ]
				  });
	
		$('.elementor-element-2d937fe .br_product_for_day.br_product_day_2').slick({
			slidesToShow: 4,
  			responsive: [
				{
				  breakpoint: 1148,
				  settings: {
					slidesToShow: 3,
				  }
				},
				{
				  breakpoint: 867,
				  settings: {
					  slidesToShow: 2,
					
				  }
				},
				{
				  breakpoint: 585,
				  settings: {
					 slidesToShow: 1,
				  }
				}
			  ]
				  });
	$('.woocommerce-page .br_product_for_day.br_product_day_2').slick({
			slidesToShow: 4,
  			responsive: [
				{
				  breakpoint: 1148,
				  settings: {
					slidesToShow: 3,
				  }
				},
				{
				  breakpoint: 867,
				  settings: {
					  slidesToShow: 2,
					
				  }
				},
				{
				  breakpoint: 585,
				  settings: {
					 slidesToShow: 1,
				  }
				}
			  ]
				  });
	$('.woocommerce-shop .br_product_for_day.br_product_day_3').slick({
			slidesToShow: 4,
  			responsive: [
				{
				  breakpoint: 1148,
				  settings: {
					slidesToShow: 3,
				  }
				},
				{
				  breakpoint: 867,
				  settings: {
					  slidesToShow: 2,
					
				  }
				},
				{
				  breakpoint: 585,
				  settings: {
					 slidesToShow: 1,
				  }
				}
			  ]
				  });
	$('.page-id-719 .br_product_for_day.br_product_day_2').slick({
			slidesToShow: 4,
  			responsive: [
				{
				  breakpoint: 1148,
				  settings: {
					slidesToShow: 3,
				  }
				},
				{
				  breakpoint: 867,
				  settings: {
					  slidesToShow: 2,
					
				  }
				},
				{
				  breakpoint: 585,
				  settings: {
					 slidesToShow: 1,
				  }
				}
			  ]
				  });
	$('.single-product .flex-control-nav.flex-control-thumbs').slick({
			slidesToShow: 3,
			vertical: true,
			 adaptiveHeight: true,
  			responsive: [
				{
				  breakpoint: 1148,
				  settings: {
					slidesToShow: 3,
					vertical: true,
				  }
				},
				{
				  breakpoint: 867,
				  settings: {
					  slidesToShow: 3,
					  vertical: true,
					
				  }
				},
				{
				  breakpoint: 585,
				  settings: {
					 slidesToShow: 3,
					 vertical: true,
				  }
				}
			  ]
				  });
	

function init() {
     let map = new ymaps.Map('map', {
          center: [53.845930732625924,27.412927842763988],
          zoom: 18,
     });
     let placemark = new ymaps.Placemark([53.845930732625924,27.412927842763988], {
		 balloonContentHeader: 'Пункт самовывоза',
		balloonContentBody: '<img src="/wp-content/uploads/2022/07/фото-на-карту-e1658751185601.png">',
		balloonContentFooter: 'Меньковский тракт, 12, 2 этаж, комната 5-6',
	 }, {
		 iconLayout:'default#image',
		 iconImageHref:'/wp-content/uploads/2022/07/Geolocation-map-icon.svg',
		 iconImageSize:[40,40],
		 iconImageOffset:[-25,-30],
		 
		 
		 

     });

     map.controls.remove('geolocationControl'); // удаляем геолокацию
     map.controls.remove('searchControl'); // удаляем поиск
     map.controls.remove('trafficControl'); // удаляем контроль трафика
     map.controls.remove('typeSelector'); // удаляем тип
     map.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим
     map.controls.remove('zoomControl'); // удаляем контрол зуммирования
     map.controls.remove('rulerControl'); // удаляем контрол правил
	map.behaviors.disable(['scrollZoom']); // отключаем скролл карты (опционально)
     map.geoObjects.add(placemark);
}


ymaps.ready(init);
	
     });

jQuery(document).ready(function(){
		jQuery('.categories__perent').click(function(event){
			if(jQuery('.type__one').hasClass('one')){
				jQuery('.categories__perent').not(jQuery(this)).removeClass('active');
				jQuery('.categories__children').not(jQuery(this).next()).slideUp(300);
			}
			jQuery(this).toggleClass('active').next().slideToggle(300);
		});
	});

// jQuery(document).ready(function(){
// 		jQuery('.cwc-block-stock-filter__title').click(function(event){
// 			if(jQuery('.type__one').hasClass('one')){
// 				jQuery('.wc-block-stock-filter__title').not(jQuery(this)).removeClass('active');
// 				jQuery('.wc-block-stock-filter').not(jQuery(this).next()).slideUp(300);
// 			}
// 			jQuery(this).toggleClass('active').next().slideToggle(300);
// 		});
 	});
 
jQuery(document).ready(function($){
	$(".tab-pane.active .tabProduct__btn").on("click", () => {
		$(".products__container .entry.has-product-nav.col.span_1_of_4.owp-content-center.owp-thumbs-layout-horizontal.owp-btn-normal.owp-tabs-layout-horizontal.has-no-thumbnails.product.type-product.sale.featured.shipping-taxable.purchasable.product-type-simple").css("display", "block");
		$(".tabProduct__btn").css("display", "none");
		return false;
	});
});

jQuery(document).ready(function ($) {
     $("#clear_cart").on("click", () => {
          $.ajax({
               url: "/wp-admin/admin-ajax.php",
               data: {
				   action: "clear_all_cart"
			   },
               type: "POST",
               success: (data) => {
				   console.log(data);
				   location.reload(true);
			   }
          });
     });
});

jQuery(document).ready(function ($) {
     $('.btn__sorting').on('click', () => {
         $('.sorting__menu').toggleClass('active');
		 $('#main, .content-area').css({'position' : 'static' });

     });
});

jQuery(document).ready(function ($) {
     $('.btn__remove').on('click', () => {
         $('.sorting__menu').removeClass('active');
		 $('#main, .content-area').css({'position' : 'relative' });
     });
});


