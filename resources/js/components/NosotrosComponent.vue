 <template>
 	<div>

 		<section class="banner-area ">
 			<div class="container-fluid">
 				<div class="row">
 					<div class="col-lg-6 px-0">


 				
 						<img v-if='url' :src="url" class="img-nosotros">
 						<img v-else src="img/upa.jpg" class="img-nosotros">
 						
 					</div>
 					<div class="col-lg-6" style="margin-top:  2em">
 						<div class="pl-2 pr-2">
 							<h2 class="text-center" v-html='nombre'></h2>

 						</div>
 						<div class="pl-2 pr-2">
 							<h4 class="text-left">Misión  </h4>

 							
 							<p class="py-3 text-justify text-n"  v-html="mision"></p>
 							
 						</div>
 						<div class="pl-2 pr-2">
 							<h4 class="text-left">Visión</h4>

 							
 							<p class="py-3 text-justify text-n" v-html="vision"></p>
 							
 						</div>
 						<div class="pl-2 pr-2">
 							<h4 class="text-left">Valores</h4>

 							
 							<p class="py-3 text-justify text-n" v-html="valores"></p>
 							
 						</div>
 					</div>
 				</div>
 			</div>
 		</section>
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
	mounted() {
		this.obtenerDatos();

	},

	data() {


		return {

			nombre:'',
			mision:'',
			vision:'',
			valores:'',
			descripcion:'',
			url:'',
			

		}
	},


	methods: {
		obtenerDatos() {
			axios.get('/api/nosotros')
			.then(response => {

				this.nombre=response.data.nombre
				this.mision=response.data.mision
				this.vision=response.data.vision
				this.valores=response.data.valores
				this.url=response.data.url

				this.descripcion=response.data.descripcion


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
</style>