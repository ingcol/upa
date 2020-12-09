 <template>
 	<div>

 		<section class="banner-area mb-4">
 			<div class="container-fluid pb-4">
 				<div class="text-left mt-4 mb-4 p-3">
 					<h3>Eventos y promociones</h3>
 					<hr>
 				</div>
 				<div class="container-fluid">
 					<div class="card col-md-12 mb-3 p-3" v-for="empresa in empresas">
 						

 						<div id="myCarousel" :class="'carousel'+empresa.id" class=" slide" data-ride="carousel">

 							<div class="row">

 								<div class=" col-md-3 text-center">

 									<img :src="imgExtension(empresa.logo)" alt="job" class="logo-desing mb-2 mt-4">

 									<h4 class="">{{empresa.nombre}}</h4>
 									<h5 class="">{{empresa.celular}}</h5>
 								</div>


 								<div class="carousel-inner col-md-9  w-100 mx-auto">



 									<div class="carousel-item  mb-3 mt-2" v-for="(promocion,index) in empresa.promociones" :class="{ active: index==0 }">
 										<div class="card border-0">
 											<div class="card-body text-center">
 												<img :src="promocion.file_url" alt="job" class="desing-event mb-2 ">
 												<h4 class="card-title">{{promocion.titulo}}</h4>
 												<p class="card-text"></p>
 												<p class="card-text">
 													<a  @click="modalPromocion(promocion.titulo,promocion.descripcion,promocion.file_url,promocion.fechafin)"class="btn-event btn-xs  btn-success text-white"><i class="fa fa-eye"></i> Ver más</a>
 												</p>
 											</div>
 										</div>
 									</div>
 									<center>
 										<div class="text-center">
 											<a  @click="prev(empresa.id)" :class="'prev'+empresa.id" class=" btn-next "  title="Anterior">
 												<i class="icon-next  fa  fa-chevron-left"></i>
 											</a>
 											<a @click="next(empresa.id)" :class="'next'+empresa.id"  class=" btn-next"  title="Siguiente">
 												<i class="icon-next  fa fa-chevron-right"></i>
 											</a>

 										</div>
 									</center>
 								</div></div>


 							</div>
 						</div>

 					</div>









 				</div>
 			</section>
 			<div class="modal fade" id="ModalPromocion" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true" data-backdrop="static">
 				<div class="modal-dialog modal-lg " role="document" >
 					<div class="modal-content">
 						<div class="modal-header ">
 							<h4 class="modal-title w-100 text-center" id="demoModalLabel" v-text="titulo"></h4>
 							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ik x-square
 								ik-x-square" style=""></span></button>
 							</div>

 							<div class="modal-body">

 								<div class="text-center">
 									<img :src="imagen" class="img-detail" style="">
 									<p class="mt-2" v-if="descripcion" v-text="descripcion"></p>
 									<p>Finaliza: el <span v-text="fechafin"></span> </p>

 								</div>












 							</div>
 							<div class="modal-footer">
 								<button  class="btn-event btn-xs btn-warning text-white" data-dismiss="modal" ><i class=" ik x-circle
 									ik-x-circle"></i> Cerrar</button>




 								</div>

 							</div>
 						</div>
 					</div>


 					<div >
 						<footer-web></footer-web>
 					</div>
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
	mounted() {
		this.obtenerDatos();
		this.slider();

	},

	data() {


		return {

			nombre:'',
			mision:'',
			vision:'',
			valores:'',
			descripcion:'',
			url:'',
			empresas:[],
			titulo:'',
			descripcion:'',
			imagen:'',
			fechafin:'',
			urlLogo:'https://upallanos.s3.us-east-2.amazonaws.com/logos/',

		}
	},


	methods: {
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
		modalPromocion(titulo,descripcion,imagen,fechafin){
			this.titulo=titulo;
			this.descripcion=descripcion;
			this.imagen=imagen;
			this.fechafin=fechafin

			$("#ModalPromocion").modal("show");

		},

		next(netxId){
			$('.next'+netxId).click(function (e) {
				$('.carousel'+netxId).carousel('next');
				return false;
			});

		},
		prev(prevId){
			$('.prev'+prevId).click(function (e) {
				$('.carousel'+prevId).carousel('prev');
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
			axios.get('api/promociones')
			.then(response => {

				
				console.log('empresas:',response.data);
				this.empresas=response.data


			})
			.catch(errors => {

			});
		},
		






	}

};
</script>
<style >
.img-nosotros{
	width: 100%;
	height: 640px;
	background-color: #b0b0b0;

	background-repeat: no-repeat;
	background-position: center;
	background-size: cover;
}
.text-n{
	color:#333;
	font-size: 15px;
}
.desing-event{
	width: 100%;
	max-width: 400px;
	height: 100%;
	max-height: 120px;
	border-radius: 5px;
	
}
.btn-event{
	padding: 4px 20px;
	border-radius: 20px;
	font-size: 15px;
	cursor: pointer;

}
.btn-next{
	background: #837e76;
	color: white !important;
	padding: 4px;
	cursor: pointer;
}
.icon-next{
	padding: 4px;
}
.btn-next:hover{
	color:#f8f8f8;
}
.img-detail{
	width: 100%;
	height: 100%;
    max-height: 500px;
    max-width: 500px;
    
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
}
</style>