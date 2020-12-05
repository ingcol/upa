<template>
	<div>
		<header class="header-area single-page mb-4">

			<div class="page-title text-center">
				<div class="container">
					<div class="row">
						<div class="col-md-6 offset-md-3">
							<h2>Contáctenos</h2>
							<p>Si tiene alguna duda o requiere  de nuestros servicios, puede contactarnos a través de los siguientes datos</p>
						</div>
					</div>
				</div>
			</div>
		</header>
		
		<section class="contact-form section-padding3 mt-4 p-4 mb-4 ">
			
			<div class="container-fluid p-4 bg-white shadow-sm">
				
				<div class="row mt-4 pb-4">
					<div class="col-lg-4 mb-5 mb-lg-0">
						<div class="d-flex mb-3">
							<div class="into-icon">
								<i class="fa fa-map-marker"></i>
							</div>
							<div class="info-text">
								<h5 class="font-weight-bold">Tame-Arauca</h5>
								
							</div>
						</div>
						<div class="d-flex mb-3">
							<div class="into-icon">
								<i class="fa fa-phone"></i>
							</div>
							<div class="info-text">
								<h5 class="font-weight-bold">311-4443006</h5>
								
							</div>
						</div>
						<div class="d-flex mb-3">
							<div class="into-icon">
								<i class="fa fa-envelope-o"></i>
							</div>
							<div class="info-text">
								<h5 class="font-weight-bold text-lowercase">upallanosorientales@gmail.com</h5>
								
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<form action="#"  @submit.prevent="enviarCorreo()">
							<div class="left">
								<input type="text" required="" v-model="nombre" placeholder="Nombre" class="form-control" >
								<input type="email" v-model="email" class="form-control" placeholder="Correo"  >
								<input type="number" v-model="telefono" class="form-control" placeholder="Teléfono"  >
							</div>
							<div class="right">
								<textarea name="message" v-model="mensaje" cols="20" rows="5"  placeholder="Mensaje"  class="form-control"></textarea>
							</div>
							<button type="submit" class="template-btn":disabled="disabled">Enviar</button>
						</form>
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


	data() {
		return {

			nombre:'',
			email:'',
			telefono:'',
			mensaje:'',
			disabled:false

		}
	},


	methods: {
		limpiarCampos(){

			this.nombre=''
			this.email=''
			this.telefono=''
			this.mensaje=''

		},
		enviarCorreo(){
			this.disabled=true

			axios.post('/api/contacto', {
				nombre:this.nombre,email:this.email,telefono:this.telefono,mensaje:this.mensaje
			})
			.then(response => {
				this.disabled=false
				this.limpiarCampos();
				Vue.$toast.open({
					message:'Mensaje enviado',
					type: 'success',
					position: 'top-right',
					duration: 5000,
					dismissible: true
    // all of other options may go here
})


			})

			.catch(error => {

				this.disabled=true
				_.forEach(error.response.data.errors, function(value, key) {
					//console.log(value)
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

};
</script>