<template>
    <div>

        <footer class="footer-area section-padding">

            <div class="container">
                <div class="row">
                    <div class="col-lg-4">

                        <h4 class="mb-2 text-left text-white">{{nombre}}</h4>
                        <span class="d-block text-left"> <i class="fa fa-phone"></i> {{celular}}</span>
                        <span class="d-block text-left"> <i class="fa fa-map-marker"></i>   Tame-Arauca</span>
                        <span class="d-block text-left"> <i class="fa  fa-envelope"></i> {{correo}}</span>


                    </div>
                    <div class=" col-lg-4">

                        <h4 class="text-white">Descarga nuestra app</h4>
                        <a href="https://play.google.com/store/apps/details?id=com.upallanos&fbclid=IwAR3zbS5xdbP3j4P1bxWm-vFww2pYROFy8_Hvf4YTLP6katBoYxqH3SS9gA0" target="_blank"><i class="fa fa-hand-o-right"></i> Aquí</a>




                    </div>
                    <div class="  col-lg-4">
                       <h4 class="mb-4 text-white">Síguenos en redes sociales</h4>

                       <ul>
                        <li><a :href="facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        
                        
                    </ul>


                </div>
            </div>
        </div>



    </footer>
</div>
</template>
<script>
    export default {
        mounted(){
            this.obtenerDatos()
        },
        data() {


            return {

                nombre:'',
                celular:'',
                correo:'',
                facebook:'',


            }
        },

        methods:{
            obtenerDatos() {
                axios.get('/api/footer')
                .then(response => {
                    this.nombre=response.data.nombre
                    this.celular=response.data.celular
                    this.correo=response.data.correo
                    this.facebook=response.data.facebook


                })
                .catch(errors => {

                });
            },

        }

    }

</script>