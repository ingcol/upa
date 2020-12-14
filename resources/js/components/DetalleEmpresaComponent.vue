<template>
	<div class="bg-white ">
		<div class="mt-4 mb-4 pt-3 text-center">
			<div class="job-img align-self-center mb-2">
				<img :src="imgExtension(logo)" alt="job" class="logo-desing ">
			</div>
			<h3  v-text="nombre"></h3>

			<div class="stars-outer ">
				<div  :style="'width:'+calificacionTotal(calificacion)"  class="stars-inner"></div>
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
		<div class="container bg-white mt-4 mb-4 pt-2" v-if="galeria.length">
			<div class="row">
				<div class="col-lg-12" >
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
			galeria:[],
			descripcion:'',
			servicios:'',
			calificacion:''
			
			

		}
	},


	methods: {
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

.carousel-item img{
	height: 400px;
	border-radius: 2px;
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
</style>