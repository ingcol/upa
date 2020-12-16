<template>
	<div class="">


		<div class="mt-4 mb-4 pt-3 text-center" v-if="!galeria.length">
			<div class="job-img align-self-center mb-2">
				<img :src="imgExtension(logo)" alt="job" class="logo-desing ">
			</div>
			<h3  v-text="nombre"></h3>

			<div class="stars-outer ">
				<div  :style="'width:'+calificacionTotal(calificacion)"  class="stars-inner"></div>
			</div>
		</div>

		<div class="row bg-white mt-4" v-else>

			<div class="col-md-6 mt-4">
				<br><br><br><br>

				<div class=" text-center">
					<div class="job-img align-self-center mb-2">
						<img :src="imgExtension(logo)" alt="job" class="logo-desing ">
					</div>
					<h3  v-text="nombre"></h3>

					<div class="stars-outer ">
						<div  :style="'width:'+calificacionTotal(calificacion)"  class="stars-inner"></div>
					</div>
				</div>
				

			</div>

			<div class="col-md-6">
				<div class="container bg-white mt-4 mb-4 pt-2">
					
					<div id="carouselExampleControls"   class="carousel slide mb-4 " data-ride="carousel"  >
						<div class="carousel-inner "  >

							<div class="carousel-item " v-for="(galerias,index) in galeria" :class="{ active: index==0 }">
								<img class="d-block w-100" :src="urlGaleria+galerias.url" alt="First slide">
							</div>

						</div>
					</div>
					<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Anterior</span>
					</a>
					<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Siguiente</span>
					</a>


				</div>
			</div>
			


		</div>





		<section class="mt-4 p-4 bg-fa">
			<div class="row  p-4">
				<div class="col-lg-4 text-center mb-2 ">
					<div class="card pt-2 pb-2 pl-2 pr-2 shadow custom-card" style="">
						<i class="fa fa-pencil-square text-danger icon-desing" ></i>
						<h3 class="mb-1">Descripción</h3>
						<p v-text='descripcion' class="d-block mt-4 "></p>
					</div>
				</div>
				<div class="col-lg-4 text-center mb-2">
					<div class="card  shadow pt-2 pb-2 pl-2 pr-2 custom-card" style="">
						<i class="fa fa-folder-open text-success icon-desing" ></i>
						<h3 class="mb-1">Servicios</h3>
						<p v-text='servicios' class="d-block mt-4 "></p>
					</div>
				</div>
				<div class="col-lg-4 text-center mb-2">
					<div class="card  shadow pt-2 pl-2 pr-2 custom-card" style="">
						<i class="fa fa-envelope text-info icon-desing" ></i>
						<h3 class=" mb-1">Contacto</h3>
						<ul class="mt-4">
							<li v-if="direccion" class="mb-3 d-block"><h5></i>Dirección: {{direccion}}</h5></li>

							<li v-if="celular" class="mb-3 d-block"><h5>Celular: {{celular}}</h5></li>

							<li v-if="email" class="mb-3 d-block "><h5 class="transformar-letra">Email: {{email}}</h5></li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		
		<!---slider MENU/PORTAFOLIO--->




		<div class="text-center mt-4 mb-4 bg-white p-4" v-if="menu.length">
			<h3 v-if="portafolio=='1'">Menú</h3>
			<h3 v-else>Portafolio</h3>
			<hr>

			<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item   mb-3 mt-2" v-for="(data,index) in menu" :class="{ active: index==0 }">

						<img :src="urlMenu+data.file" >
						

							<!--<div class="page-title page-title-blog text-center" :style='startimage+urlMenu+data.file+endimage'

							>

						</div>-->
					
				</div>



			</div>
			<div class="text-center mt-2">
				<a  @click="prev" :class="'prev'" class=" btn-next "  title="Anterior">
					<i class="icon-next  fa  fa-chevron-left"></i>
				</a>
				<a @click="next" :class="'next'"  class=" btn-next"  title="Siguiente">
					<i class="icon-next  fa fa-chevron-right"></i>
				</a>

			</div>
		</div>
	</div>

	<footer-web></footer-web>
</div>
</template>


<script>
	import Vue from 'vue';
	import VueToast from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';
import PulseLoader from 'vue-spinner/src/ClipLoader.vue'
Vue.use(VueToast);
export default {
	props:{
		id:String
		
	},
	mounted() {
		//alert(this.id);
		this.obtenerDatos();
		this.slider();

	},

	data() {


		return {

			nombre:'',
			logo:'',
			celular:'',
			direccion:'',
			email:'',
			urlLogo:'https://upallanos.s3.us-east-2.amazonaws.com/logos/',
			urlGaleria:'https://upallanos.s3.us-east-2.amazonaws.com/empresas/',
			urlMenu:'https://upallanos.s3.us-east-2.amazonaws.com/menu/',
			galeria:[],
			menu:[],
			descripcion:'',
			servicios:'',
			calificacion:'',
			portafolio:'',
			startimage:'background-image:url("',
			endimage:'")',
			
			

		}
	},


	methods: {

		next(){
			$('.next').click(function () {
				$('.carousel').carousel('next');

				return false;
			});

		},
		prev(){
			$('.prev').click(function () {
				$('.carousel').carousel('prev');
				return false;
			});

		},


		slider(){
			(function ($) {
				"use strict";
  // Auto-scroll
  $('#myCarousel').carousel({
  	interval: 3000
  });

  // Control buttons
  


  // On carousel scroll
  $("#myCarousel").on("slide.bs.carousel", function (e) {
  	var $e = $(e.relatedTarget);
  	var idx = $e.index();
  	var itemsPerSlide = 3;
  	var totalItems = $(".carousel-item").length;
  	if (idx >= totalItems - (itemsPerSlide - 1)) {
  		var it = itemsPerSlide -
  		(totalItems - idx);
  		for (var i = 0; i < it; i++) {
        // append slides to end 
        if (e.direction == "left") {
        	$(
        		".carousel-item").eq(i).appendTo(".carousel-inner");
        } else {
        	$(".carousel-item").eq(0).appendTo(".carousel-inner");
        }
    }
}
});
})
			(jQuery);
		},
		obtenerDatos() {

			axios.get('/api/verDetalleempresa/'+this.id)
			.then(response => {

				this.nombre=response.data.nombre
				this.galeria=response.data.galeria
				this.direccion=response.data.direccion
				this.email=response.data.email
				this.celular=response.data.celular
				this.logo=response.data.logo
				this.descripcion=response.data.descripcion
				this.servicios=response.data.servicios
				this.calificacion=response.data.calificacion
				this.menu=response.data.menus
				this.portafolio=response.data.menu
				//console.log('menu:',this.menu);

				

			})
			.catch(errors => {

			});
		},
		calificacionTotal(calificacion){
			const starTotal = 5;
			const starPercentage = (calificacion / starTotal) * 100;
			let starPercentageRounded = `${(Math.round(starPercentage / 3) * 3)}`;


			return starPercentageRounded+'%';

		},
		imgExtension(img){

			if (img) {

				let extension= img.slice((img.lastIndexOf('.') - 1 >>> 0) + 2);

				if (extension=='png' || extension=='jpeg' || extension=='gif' || extension=='jpg' || extension=='svg') {

					return this.urlLogo+img
				}
				else{

					return this.urlLogo+'logodefault.jpg';

				}

			}
			else{
				return this.urlLogo+'logodefault.jpg';

			}


		},
		






	}

};
</script>

<style>
.slider{
	max-height: 300px;
}


.carousel-none{
	height: 300px;
	background: #534e4e
}
.custom-card{
	height: 270px;
	max-height: 500px;
}
.logo-desing{
	border-radius: 50%;border: solid 2px white; box-shadow: 2px 1px 5px #d8d8d8; width: 110px; height: 110px;
}
.bg-fa{
	background: #f7f7f7;
}
.icon-desing{
	font-size: 35px; padding: 6px;
}
.transformar-letra{
	text-transform: none;
}
.img-menu{
	
 		width: 100%;
 		height: 100%;
 		max-height: 500px;
 		max-width: 600px;

 		background-repeat: no-repeat;
 		background-position: center;
 		background-size: cover;
 	
}
</style>