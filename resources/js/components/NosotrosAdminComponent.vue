 <template>
 	<div class="main-content">
 		<div class="contenedor">
 			<div class="container-fluid">
 				<div class="page-header">
 					<div class="row align-items-end">
 						<div class="col-lg-8">
 							<div class="page-header-title">

 								<div class="d-inline">
 									<h5>Nosotros</h5>

 								</div>
 							</div>
 						</div>
 						<div class="col-lg-4">



 						</div>
 					</div>
 				</div>
 				<hr>





 				<div class="row mt-3">
 					<div class="col-lg-4">
 						<label>Nombre</label>
 						<input type="text"class="form-control" v-model='nombre'>
 					</div>
 					<div class="col-lg-4">
 						<label>Celular</label>
 						<input type="number"class="form-control" v-model='celular'>
 					</div>
 					<div class="col-lg-4">
 						<label>Whatsapp</label>
 						<input type="number" class="form-control"v-model='whatsapp'>
 					</div>
 					
 				</div>

 				<hr>
 				<div class="row mt-3">
 					<div class="col-lg-4">
 						<label>Correo</label>
 						<input type="email" class="form-control"v-model='correo'>
 					</div>
 					
 					<div class="col-lg-4">
 						<label>Facebook</label>
 						<input type="text" class="form-control"v-model='facebook'>
 					</div>

 					<div class="col-lg-4">
 						<label class="mb-4"></label>
 						<span class="file d-block">

 							<input   type="file" @change="obtenerImagen"  accept="image/png, image/jpeg,image/gif,image/jpg"  name="image"  ref="file"/>
 							<label for="file "><i class="ik paperclip
 								ik-paperclip"></i> Seleccione una imágen</label>
 							</span>
 						</div>

 					</div>

 					<hr>
 					<div class="row">
 						<div class="col-lg-12">
 							<label>Descripción</label>
 							<ckeditor v-model='descripcion' class="mb-1" :config="editorConfig"></ckeditor>
 						</div>
 					</div>
 					<hr>
 					<div class="row">
 						<div class="col-lg-12">
 							<label>Misión</label>
 							<ckeditor v-model='mision' class="mb-1" :config="editorConfig"></ckeditor>
 						</div>
 					</div>
 					<hr>
 					<div class="row">
 						<div class="col-lg-12">
 							<label>Visión</label>
 							<ckeditor v-model='vision' class="mb-1" :config="editorConfig"></ckeditor>
 						</div>
 					</div>
 					<hr>
 					<div class="row">
 						<div class="col-lg-12">
 							<label>Valores</label>
 							<ckeditor v-model='valores' class="mb-1" :config="editorConfig"></ckeditor>
 						</div>
 					</div>
 					<hr>
 					<div>
 						<button @click='actualizarDatos()' class="btn btn-success float-right"><i class="ik refresh-ccw ik-refresh-ccw"></i> Actualizar</button>
 					</div>
 				</div>

 			</div>
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

	},

	data() {


		return {
			editorConfig:{
				removePlugins: 'elementspath',
				extraPlugins : "justify",
				removeButtons: 'justify',
				toolbar:[
				{ name: 'document', items: [ '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
				{ name: 'clipboard', items: [ 'Cut', '-', 'Undo', 'Redo' ] },



				{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
				{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-',  '-',  '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },


				{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
				{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
				{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },

				]


			},
			descripcion:'',
			mision:'',
			vision:'',
			valores:'',
			nombre:'',
			correo:'',
			whatsapp:'',
			celular:'',
			facebook:'',
			imagen:''
			

		}
	},


	methods: {

		obtenerImagen(e){

			let file=e.target.files[0];
			this.imagen=file;
		},


		obtenerDatos() {
			axios.get('/api/nosotrosAdmin')
			.then(response => {
				this.nombre=response.data.nombre
				this.descripcion=response.data.descripcion
				this.mision=response.data.mision
				this.vision=response.data.vision
				this.valores=response.data.valores
				this.whatsapp=response.data.whatsapp
				this.celular=response.data.celular
				this.correo=response.data.correo
				this.facebook=response.data.facebook


			})
			.catch(errors => {

			});
		},
		

		actualizarDatos(){
			let formData = new FormData();
			formData.append('nombre', this.nombre);
			formData.append('descripcion', this.descripcion);
			formData.append('mision', this.mision);
			formData.append('vision', this.vision);
			formData.append('valores', this.valores);
			formData.append('whatsapp', this.whatsapp);
			formData.append('celular', this.celular);
			formData.append('correo', this.correo);
			formData.append('facebook', this.facebook);
			formData.append('url', this.imagen);
			formData.append('_method', 'put');
			axios.post('api/nosotrosAdmin', formData)
			.then(response => {
				
				Vue.$toast.open({
					message:'Registro actualizado con éxito',
					type: 'success',
					position: 'top-right',
					duration: 5000,
					dismissible: true
    // all of other options may go here
})
				


			})

			.catch(error => {

				_.forEach(error.response.data.errors, function(value, key) {


					Vue.$toast.open({
						message: value[0],
						type: 'error',
						position: 'top-right',
						duration: 5000,
						dismissible: true
    // all of other options may go here
})

				});
			});
			

		}




	}
	,computed:{


	}

};
</script>

<style>
textarea{
	display: none;
}
</style>