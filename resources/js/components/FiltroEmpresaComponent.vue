<template>
	<div>
   <div class="page-title page-title-blog text-center" style="background-image:url('img/tame.jpg'">
      <div class="container">
        <div class="row">
          <div class="col-md-6 offset-md-3">
            <h2>Bienvenidos a Upa Llanos</h2>
            <p>Líderes en algo</p>
            <!--<a href="#" class="template-btn">view post details</a>-->
          </div>
        </div>
      </div>
    </div>
    <div class="search-area mb-4">
      <div class="search-bg">
        <div class="container">
          <div class="row p-4 filter" >
            <div class="col-lg-3">

              <v-select  @input='obtenerSubCategorias'  placeholder="Ciudades" class="style-chooser bg-white rounded mb-2 "  v-model="ciudad_id" :reduce="ciudades => ciudades.id" label="data"  :options="ciudades"  ></v-select>
            </div>
            <div class="col-lg-3">

              <v-select   placeholder="Categorías" class="style-chooser bg-white rounded mb-2 "  v-model="subcategoria_id" :reduce="subcategorias => subcategorias.id" label="nombre"  :options="subcategorias"  ></v-select>
            </div>
            <div class="col-lg-3">

              <input type="text" v-model="busqueda" class="form-control rounded mb-2 " name="" placeholder="Búsqueda">


            </div>
            <div class="col-lg-3">
             <button type="submit" @click="obtenerDatos" class="btn btn-dark float-right mb-2 form-control "><i class="fa fa-filter"></i> Filtrar</button>
           </div>
         </div>
       </div>
     </div>
   </div>
   
   <pulse-loader :loading="loading" :color="color"></pulse-loader>

   <section class="job-single-content">
    <div class="container">

      <div class="row">
        <div class="col-lg-12">
          <div class="main-content">
            <div class="single-content1">

              <paginate name="empresas" :list="empresas" class="paginar" :per="20" v-if="paginador">


                <div  class="bg-white item-detail single-job mb-4 d-lg-flex justify-content-between" v-for="item in paginated('empresas')"  @click="detalleEmpresa(item.id,item.plan)" >

                  <div class="job-text">
                    <h4>{{item.nombre}}</h4>


                    <ul class="mt-4">
                      <li v-if="item.direccion " class="mb-3 d-block"><h5><i class="fa fa-map-marker"></i>{{item.direccion}}</h5></li>

                      <li v-if="item.celular && item.plan !='gratis'" class="mb-3 d-block"><h5><i class="fa fa-phone"></i>{{item.celular}}</h5></li>

                      <li v-if="item.email && item.plan !='gratis'" class="mb-3 d-block"><h5 class="transformar-letra"><i class="fa fa-envelope"></i>{{item.email}}</h5></li>

                      <li class="mb-3 d-block">
                        
                        <div class="stars-outer">
                          <div  :style="'width:'+calificacion(item.calificacion)"  class="stars-inner"></div>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="job-img align-self-center">
                    <img :src="imgExtension(item.logo)" alt="job" class="logo-desing">

                  </div>


                </div>
              </paginate>

              <div class="text-center">
                <!--
              <paginate-links for="empresas" :limit="10" :show-step-links="true" ></paginate-links>
            -->
            <paginate-links v-if="paginador" for="empresas" class="paginador" :simple="{
              next: 'Siguiente »',
              prev: '« Anterior'
            }"></paginate-links>
            <h4 v-else style="text-transform: none;">No se encontraron resultados</h4>

          </div>




        </div>
      </div>

    </div>

  </div>

</div>
</section>
<footer-web></footer-web>
</div>
</template>

<script>
  import PulseLoader from 'vue-spinner/src/ClipLoader.vue'
  export default {
    mounted() {
      this.obtenerCiudades();
      this.obtenerDatos();


    },

    data() {
      return {


        busqueda:'',
        ciudadFiltro:'',
        categoriaFiltro:'',
        ciudades:[],
        categorias:[],
        ciudad_id:'',
        empresas:[],
        paginate: ['empresas'],
        subcategoria_id:'',
        subcategorias:[],
        urlLogo:'https://upallanos.s3.us-east-2.amazonaws.com/logos/',
        paginador:true,
        loading:false,
        color:'orange'

      }
    },
    components: {
      'PulseLoader': PulseLoader
    },

    methods: {
      calificacion(calificacion){
        const starTotal = 5;
        const starPercentage = (calificacion / starTotal) * 100;
        let starPercentageRounded = `${(Math.round(starPercentage / 3) * 3)}`;


        return starPercentageRounded+'%';

      },
      obtenerDatos(){
        this.loading=true
        axios.get('/api/filtroEmpresa',{
         params: {
           subcategoria_id: this.subcategoria_id,ciudad_id:this.ciudad_id,busqueda:this.busqueda
         }
       }).then(response=>{
         this.loading=false
         

         if (response.data.empresa.length) {
          this.empresas=response.data.empresa;
          this.paginador=true

        }
        else{
          this.paginador=false

        }

        

        

      }) .catch(errors => {
        this.loading=false

                        //errors data

                      });
    },
    obtenerCiudades() {
      axios.get('/api/ciudades')
      .then(response => {
       this.ciudades=response.data;

       const todoCiudad={
        id:-1,
        nombre:'Todos'
      }

      this.ciudades.unshift(todoCiudad);


      this.ciudades.map(function (c){

        return c.data = c.nombre;

      });

    })
      .catch(errors => {

      });
    },

    obtenerSubCategorias(){

     this.subcategoria_id=''
     this.subcategorias=[]

     if(this.ciudad_id!="" && this.ciudad_id!="-1"){


       axios.get('/api/subCategoriaFiltro',{
         params: {
          ciudad_id: this.ciudad_id
        }
      }).then(function(response){


       var sub=[]


//Ordenar el array para cargar solo las subcategorías que tiene empresas
response.data.map(function (s){

  for(var dato in s.subcategorias){


   if (s.subcategorias[dato].empresas.length) {

    sub.push(s.subcategorias[dato]);

  }


}
});
if (sub.length) {

 const todoCategoria={
  id:-1,
  nombre:'Todos'
}
sub.unshift(todoCategoria);
}
else{
  const noExisteCategoria={
    id:'',
    nombre:'No existen categorías'
  }
  sub.unshift(noExisteCategoria);

}



this.subcategorias=sub
                     /*

                     this.subcategorias.map(function (b){
                      return b.item_data = b.nombre;

                    });

                    */


                  }.bind(this));

    }
    else{
      const todoCategoria={
        id:-1,
        nombre:'Todos'
      }
      this.subcategorias.unshift(todoCategoria);
    }


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

detalleEmpresa(id,plan){
  if (plan!='gratis') {
    window.open('/empresa/'+id, '_blank');
  }
}


}

};
</script>



<style>
.paginador{
  cursor: pointer;
  color:#fff;
  margin-bottom: 30px;

}
.paginador a{
  border-radius: 0px;
  background: #42b983;
  padding: 4px 12px;
}
.style-chooser .vs__search::placeholder,
.style-chooser .vs__dropdown-toggle,
.style-chooser .vs__dropdown-menu {



  border:0;

  height: auto;
  min-height: 38px;
  font-size: 15px;
  border-radius: 5px !important;
}

.chooser .vs__clear,
.chooser .vs__open-indicator {
  fill: #ccc;
  border: solid 1px green;
  border-radius: 5px !important;

}
.chooser .vs__search::placeholder,
.chooser .vs__dropdown-toggle,
.chooser .vs__dropdown-menu {



  border-radius: 5px !important;
  height: auto;
  min-height: 35px;
  font-size: 15px;
}

.chooser .vs__clear,
.chooser .vs__open-indicator {
  fill: #ccc;

  border-radius: 5px !important;


}
ul {
  list-style-type: none;
  padding: 0;
}
/* inabilitado por el select 2 de ciudades en empresas y profesionales
li {
  display: inline-block;
  margin: 0 10px;
}
*/

.paginate-list {
  width: 159px;
  margin: 0 auto;
  text-align: left;
  li {
    display: block;
    &:before {
      content: '⚬ ';
      font-weight: bold;
      color: slategray;
    }
  }
}

.paginate-links.items {
  user-select: none;
  a {
    cursor: pointer;
  }
  li.active a {
    font-weight: bold;
  }
  li.next:before {
    content: ' | ';
    margin-right: 13px;
    color: red;
    background: red;
  }
  li.disabled a {
    color: red;
    cursor: no-drop;
  }
}

a {
  color: red;
}
.paginar{
  width: 100%;
}
.filter{
  background: #ff9902; padding: 30px;
}
.item-detail{
  cursor: pointer; border-left: 2px solid orange; box-shadow: 0 0 5px #d8d8d8
}

.stars-outer {
  display: inline-block;
  position: relative;
  font-family: FontAwesome;
  font-size: 26px;
}

.stars-outer::before {
  content: "\f006 \f006 \f006 \f006 \f006";
}

.stars-inner {
  position: absolute;
  top: 0;
  left: 0;
  white-space: nowrap;
  overflow: hidden;
  width: 0;
}

.stars-inner::before {
  content: "\f005 \f005 \f005 \f005 \f005";
  color: #f8ce0b;
}


</style>

