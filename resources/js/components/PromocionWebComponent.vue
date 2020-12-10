 <template>
 	<div>

 		<section class="banner-area mb-4">
 			<div class="container-fluid pb-4">
 				<div class="text-center mt-4 mb-4 p-3">
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
 									<div class="stars-outer ">
 										<div  :style="'width:'+calificacionTotal(empresa.calificacion)"  class="stars-inner"></div>
 									</div>

 									
 									<h5 class="">{{empresa.celular}}</h5>
 									<h5 class="">{{empresa.direccion}}</h5>
 								</div>

 								


 								<div class="carousel-inner col-md-9">



 									<div class="carousel-item   mb-3 mt-2" v-for="(promocion,index) in empresa.promociones" :class="{ active: index==0 }">
 										<div class="card border-0">
 											<div class="text-center ">

 												<div class="item-img" style="  ">
 													<span class="notify-badge"v-if="promocion.tipo=='Promocion'">Promoción</span>
 													<span class="notify-badge" v-else>{{promocion.tipo}}</span>
 													<img :src="promocion.file_url" alt="job" class="desing-event">
 												</div>
 												<center>
 													<div class="bg-white pb-4 border-bottom border-left border-right " style="width: 100%;max-width: 320px; box-shadow: 0px 0px 2px #ddd; border-bottom-left-radius: 4px;border-bottom-right-radius: 4px;
 													">

 													<p class="p-3">{{promocion.titulo}}</p>
 													<hr>
 													<p class="card-text"></p>
 													<p class="card-text">

 														<a  @click="modalPromocion(promocion.titulo,promocion.descripcion,promocion.file_url,promocion.fechafin,promocion.tipo)"class="btn-event btn-xs  btn-success text-white"><i class="fa fa-eye"></i> Ver más</a>
 													</p>

 												</div></center>
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
 							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times" style=""></span></button>
 						</div>

 						<div class="modal-body">

 							<div class="text-center" style="height: 100%;
 							background-size:     cover;                      /* <------ */
 							background-repeat:   no-repeat;
 							background-position: center center;">
 							<div class="item-img" style="  ">
 								<span class="notify-badge"v-if="tipo=='Promocion'">Promoción</span>
 								<span class="notify-badge" v-else>{{tipo}}</span>
 								<img :src="imagen" class="img-detail" style="">
 								<hr>
 								<span class="mt-2 badge badge-success mb-2">Finaliza: {{fechaFormateada(fechafin)}} </span class="mt-2">
 									<p class="mt-2" v-if="descripcion" v-text="descripcion"></p>
 								</div>
 							</div>

 						</div>
 						<div class="modal-footer">
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

 		import 'vue-toast-notification/dist/theme-sugar.css';
 		import PulseLoader from 'vue-spinner/src/ClipLoader.vue'
 		import moment from 'moment';
 		moment.lang('es');
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
 					tipo:''

 				}
 			},


 			methods: {
 				calificacionTotal(calificacion){
 					const starTotal = 5;
 					const starPercentage = (calificacion / starTotal) * 100;
 					let starPercentageRounded = `${(Math.round(starPercentage / 3) * 3)}`;


 					return starPercentageRounded+'%';

 				},
 				fechaFormateada(fecha){
 					return moment(fecha).format("D, MMMM YYYY");
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
 				modalPromocion(titulo,descripcion,imagen,fechafin,tipo){
 					this.titulo=titulo;
 					this.descripcion=descripcion;
 					this.imagen=imagen;
 					this.fechafin=fechafin
 					this.tipo=tipo

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
 		max-width: 320px;
 		height: 100%;
 		max-height: 150px;
 		border-radius: 1px;

 	}
 	.btn-event{
 		padding: 3px 20px;
 		border-radius: 20px;
 		font-size: 14px;
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
 	.item-img {
 		position:relative;
 		padding-top:20px;
 		display:inline-block;
 	}
 	.notify-badge{
 		position: absolute;
 		right: -20px;
 		top: 5px;
 		background: #d9534f;
 		text-align: center;
 		border-radius: 2px;
 		border:dashed 1px #ddd;
 		color: white;
 		padding: 3px 10px;
 		font-size: 14px;
 	}
 </style>