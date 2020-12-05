<template>
	<div class="main-content">
		<div  class="contenedor">
			<div class="container-fluid">
				<div class="page-header">
					<div class="row align-items-end">
						<div class="col-lg-8">
							<div class="page-header-title">
               <div class="d-inline">
                 <h5>Módulo de publicidad</h5>
               </div>
             </div>
           </div>
           <div class="col-lg-4">
            <button type="button"  class="btn-guardar float-right"  @click="ModalNuevo()"><i class="ik ik-check-circle"></i> Registrar</button>
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-3">
          <label>Filtrar</label>

          <select v-model="length" @change="resetPagination()" class="form-control input-custom">
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>

        </div>

        <div class="col-md-3"><div class="form-group">
          <label>Ciudad</label>
          <select class="form-control" @change='getPublicidad()' v-model="filtrarCiudad">
            <option value="">Todos</option>
            <option :value="ciudad.id" v-for="ciudad in ciudades" >{{ciudad.nombre}}</option>

          </select>
        </div> </div>
        <div class="col-md-3"><div class="form-group">
          <label>Categoría</label>
          <select class="form-control"  @change='getPublicidad()' v-model="filtrarCategoria">
           <option value="" selected="">Todos</option>
           <option value="intermedia">Intermedia</option>
           <option value="banner">Banner</option>
           <option value="principal">Principal</option>
           <option value="inicial">Inicial</option>
           <option value="radio">Radio</option>
         </select>
       </div> </div>
       <div class="col-md-3">
        <label>Búsqueda</label>

        <input type="text" v-model="search" placeholder="" @input="resetPagination()" class="form-control input-custom">
      </div>
    </div>

    <br>
    <div class="table-responsive" >

     <table class="table  jambo_table bulk_action  " id="table_grupo" >
      <thead>
        <tr class=" tabla-fondo">
          <th>Ciudad</th>
          <th>Nombre</th>
          <th>Categoría</th>
          <th>Orden</th>
          <th>Estado</th>
          <th>Imagen</th>
          <th>Editar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>

        <tr v-for="item in paginatedPublicidad" :key="item.id">
          <td><span v-if='item.ciudad_id'>{{item.nombreCiudad}}</span> <span v-else>Inicial</span></td>
          <td>{{item.nombre}}</td>
          <td>{{item.categoria}}</td>
          <td>{{item.orden}}</td>
          <td><span v-if="item.estado=='A'">Activo</span> <span v-else>Inactivo</span></td>
          <td><img v-if='item.intermedia' :src="urlImagen+item.intermedia" class="img-publicidad">  </td>
          <td><a @click="ModalEditar(item)" class="btn-editar"><i class="ik refresh-ccw ik-refresh-ccw
            "></i> </a></td>
            <td><a @click="modalEliminar(item.id)" class="btn-eliminar"><i class="ik trash-2 ik-trash "></i> </a></td>


          </tr>
        </tbody>

      </table>
    </div>
    <hr>
    <div  class="paginator">
      <nav class="pagination" v-if="!tableShow.showdata" >
        <span class="page-stats cantidad-registro" >{{pagination.from}} - {{pagination.to}} de {{pagination.total}}</span>
        <a v-if="pagination.prevPageUrl"  class=" margin-button" @click="--pagination.currentPage">
          <i class="fa fa-arrow-circle-left"></i>
        </a>
        <a class="margin-button" v-else disabled >
          <i class="fa fa-arrow-circle-left"></i>
        </a>
        <a v-if="pagination.nextPageUrl" class=" margin-button"  @click="++pagination.currentPage">
          <i class="fa fa-arrow-circle-right"></i>
        </a>
        <a class="margin-button"  v-else disabled>
          <i class="fa fa-arrow-circle-right"></i>
        </a>
      </nav>
      <nav class="pagination" v-else>
        <span class="page-stats cantidad-registro" >Mostrando
          {{pagination.from}} - {{pagination.to}} de un total {{filteredPublicidad.length}}
          <span v-if="`filteredPublicidad.length < pagination.total`"></span>
        </span>
        <a v-if="pagination.prevPage" class=" margin-button" @click="--pagination.currentPage" ><i class="fa fa-arrow-circle-left"></i>

        </a>
        <a class="margin-button" v-else disabled >
          <i class="fa fa-arrow-circle-left"></i>
        </a>
        <a v-if="pagination.nextPage" class="margin-button" @click="++pagination.currentPage" ><i class="fa fa-arrow-circle-right"></i>

        </a>
        <a class="margin-button"  v-else disabled ><i class="fa fa-arrow-circle-right"></i>
        </a>
      </nav>
    </div>
  </div>
  <!--modal-->
  <div class="modal fade" id="ModalPublicidad" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true" data-backdrop="static">
   <div class="modal-dialog modal-lg " role="document" >
    <div class="modal-content">
     <div class="modal-header">
      <h5 class="modal-title" id="demoModalLabel"></h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ik x-square
        ik-x-square" style=""></span></button>
      </div>
      <form @submit.prevent="ModoEditar ? ActualizarPublicidad(publicidad) : CrearPublicidad()">
        <div class="modal-body">
          <loading :active.sync="isLoading"
          :can-cancel="false"></loading>

          <div class="row">
            <div class="col-md-6">
             <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control"   placeholder="" v-model="publicidad.nombre">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Categoría</label>
              <select class="form-control" v-model="publicidad.categoria">
               <option value="" selected="">Seleccione</option>
               <option value="intermedia">Intermedia</option>
               <option value="banner">Banner</option>
               <option value="principal">Principal</option>
               <option value="inicial">Inicial</option>
               <option value="radio">Radio</option>
             </select>
           </div>
         </div>
       </div>

       <div class="row">
        <div class="col-md-6">
         <div class="form-group">
          <label>Ciudad</label>
          <select class="form-control" v-model="publicidad.ciudad_id">
            <option value="">Seleccione</option>
            <option :value="ciudad.id" v-for="ciudad in ciudades" >{{ciudad.nombre}}</option>

          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Orden</label>
          <select class="form-control" v-model="publicidad.orden">
           <option value="" selected="">Seleccione</option>
           <option value="0">0</option>
           <option value="1">1</option>
           <option value="2">2</option>
           <option value="3">3</option>
           <option value="4">4</option>
           <option value="5">5</option>
           <option value="6">6</option>
           <option value="7">7</option>
           <option value="8">8</option>
           <option value="9">9</option>
           <option value="10">10</option>
         </select>
       </div>
     </div>
   </div>

   <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Estado</label>
        <select class="form-control" v-model="publicidad.estado">
          <option value="A">Activo</option>
          <option value="I">Inactivo</option>
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Url</label>

        <input type="url" name=""v-model="publicidad.url"  class="form-control">

      </div>

    </div>
  </div>

  <div class="form-group">
    <label >Descripción</label>
    <textarea class="form-control" row="2" v-model="publicidad.descripcion"></textarea>
  </div>
  <div class="form-group">
   <span class="file d-block">

    <input   type="file" @change="obtenerImagen"  accept="image/png, image/jpeg,image/gif,image/jpg"  name="image"  ref="file"/>
    <label for="file "><i class="ik paperclip
      ik-paperclip"></i> Seleccione una imágen</label>
    </span>

  </div>
</div>
<div class="modal-footer">
 <button  class="btn-cerrar" data-dismiss="modal" ><i class=" ik x-circle
  ik-x-circle"></i> Cerrar</button>


  <button type="submit" class=""  id="BtnAccion"><i class="" id="icon-save"> </i></button>

</div>
</form>
</div>
</div>
</div>

<div class="modal fade pr-0" id="ModalEliminar"  role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true" data-backdrop="static"  >
 <div class="modal-dialog " role="document">
  <div class="modal-content">
   <div class="modal-header text-center">

    <h5  class="w-100 pt-4 text-center" v-text="'¿Desea eliminar este registro '"></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ik x-square
      ik-x-square" style=""></span></button>
    </div>
    <div>

    </div>

    <div class="modal-body text-center p-4">
      <button  class="btn-editar text-white border-0 mb-2" data-dismiss="modal" >
      Cancelar</button>
      <button type="submit"   class="btn-cerrar text-white border-0" @click="eliminar"><loading :active.sync="isLoading"
        :can-cancel="false"></loading> Eliminar </button>

      </div>


    </div>
  </div>
</div>


</div>

</div>
</template>

<script>
  import Vue from 'vue';
  import VueToast from 'vue-toast-notification';
  import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    import 'vue-toast-notification/dist/theme-sugar.css';
    export default {
     components: {Loading},
     mounted() {
      this.getPublicidad();
      this.getCiudad();

    },
    data() {
      let sortOrders = {};
      let columns = [
      {label: 'Nombre', name: 'nombre' },
      {label: 'Descripcion', name: 'descripcion'},
      {label: 'Estado', name: 'estado'},

      ];
      columns.forEach((column) => {
       sortOrders[column.nombre] = -1;
     });

      return {
        urlImagen:'https://s3.us-east-2.amazonaws.com/upallanos/publicidad/',
        ModoEditar: false,
        publicidades: [],
        ciudades:[],
        idEliminar:'',
        isLoading:false,
        filtrarCategoria:'',
        filtrarCiudad:'',

        columns: columns,
        //sortKey: 'EstadoPiso',
        sortOrders: sortOrders,
        length: 20,
        search: '',
        tableShow: {
          showdata: true,
        },

        pagination: {
          currentPage: 1,
          total: '',
          nextPage: '',
          prevPage: '',
          from: '',
          to: ''
        },
        publicidad: {
         nombre: '',
         ciudad_id: '',
         descripcion: '',
         estado:'',
         url:'',
         intermedia:'',
         categoria:'',
         orden:''
       },
       
     }
   },

   methods: {
    getCiudad: function(){
      axios.get('/api/ciudadPublicidad').then(response=>{
        this.ciudades = response.data;})
    },
    obtenerImagen(e){

      let file=e.target.files[0];
      this.publicidad.intermedia=file;

    },

    ModalNuevo()
    {


      $('.modal-title').text('Registrar publicidad');
      $('#icon-save').removeClass('ik refresh-ccw ik-refresh-ccw');
      $('#icon-save').addClass('ik ik-check-circle');
      $('#BtnAccion').removeClass('btn-editar');
      $('#BtnAccion').addClass('btn-guardar');
      $("#ModalPublicidad").modal("show");
      $('#icon-save').text(' Guardar');

      this.reset();
      this.ModoEditar = false;



    },
    CrearPublicidad()
    {
      this.isLoading=true
      let formData = new FormData();
      formData.append('nombre',this.publicidad.nombre);
      formData.append('descripcion',this.publicidad.descripcion);
      formData.append('estado',this.publicidad.estado);
      formData.append('url',this.publicidad.url);
      formData.append('ciudad_id',this.publicidad.ciudad_id);
      formData.append('intermedia',this.publicidad.intermedia);
      formData.append('categoria',this.publicidad.categoria);
      formData.append('orden',this.publicidad.orden);

      axios.post('api/guardarPublicidad', formData).then(response => {
        this.isLoading=false

        this.reset();
        Vue.$toast.open({
          message:'Registro exitoso',
          type: 'success',
          position: 'top-right',
          duration: 5000,
          dismissible: true
    // all of other options may go here
  })


        this.publicidades.unshift(response.data);
        /*$("#ModalPrioridad").modal("hide");*/


      })

      .catch(error => {
        this.isLoading=false
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
    },
    reset()
    {
     this.publicidad.nombre=''
     this.publicidad.descripcion=''
     this.publicidad.url=''
     this.publicidad.ciudad_id=''
     this.publicidad.intermedia=''
     this.publicidad.categoria=''
     this.publicidad.orden=''
     this.publicidad.estado= 'A';
     this.$refs.file.value=null;
   },ModalEditar(item){

    $('.modal-title').text('Editar publicidad');
    $("#icon-save").removeClass( "ik-check-circle" );
    $('#icon-save').addClass('ik refresh-ccw ik-refresh-ccw');
    $('#BtnAccion').removeClass('btn-guardar ');
    $('#BtnAccion').addClass('btn-editar');
    $("#ModalPublicidad").modal("show");
    $('#icon-save').text(' Editar')

    if (item.descripcion) {
     this.publicidad.descripcion=item.descripcion
   }
   else{
    this.publicidad.descripcion=''
  }

  this.publicidad.nombre=item.nombre

  if (item.url) {
    this.publicidad.url=item.url
  }
  else{
    this.publicidad.url=''
  }
  if (item.ciudad_id) {
    this.publicidad.ciudad_id=item.ciudad_id
  }
  else{
    this.publicidad.ciudad_id=''
  }
  
  this.publicidad.intermedia=item.intermedia 


  this.publicidad.categoria=item.categoria


  this.publicidad.orden=item.orden


  this.publicidad.estado=item.estado






  this.publicidad.id = item.id;
  this.ModoEditar = true;
},ActualizarPublicidad(publicidad){
  this.isLoading=true
  let formData = new FormData();
  formData.append('nombre',this.publicidad.nombre);
  formData.append('descripcion',this.publicidad.descripcion);
  formData.append('estado',this.publicidad.estado);
  formData.append('url',this.publicidad.url);
  formData.append('ciudad_id',this.publicidad.ciudad_id);
  formData.append('intermedia',this.publicidad.intermedia);
  formData.append('categoria',this.publicidad.categoria);
  formData.append('orden',this.publicidad.orden);
  formData.append('_method', 'put');



  axios.post(`api/actualizarPublicidad/${publicidad.id}`,formData).then(response=>{
    this.ModoEditar = false;
    this.isLoading=false
    Vue.$toast.open({
      message:'Registro actualizado con éxito',
      type: 'success',
      position: 'top-right',
      duration: 5000,
      dismissible: true
    // all of other options may go here
  })

    $("#ModalPublicidad").modal("hide");

    const index = this.publicidades.findIndex(busqueda => busqueda.id === response.data.id)
    this.publicidades[index].nombre=response.data.nombre;
    this.publicidades[index].descripcion=response.data.descripcion;
    this.publicidades[index].estado=response.data.estado;

    this.publicidades[index].url=response.data.url;
    this.publicidades[index].intermedia=response.data.intermedia;
    this.publicidades[index].categoria=response.data.categoria;

    this.publicidades[index].ciudad_nombre=response.data.ciudad_nombre;
    this.publicidades[index].categoria=response.data.categoria;
    this.publicidades[index].orden=response.data.orden;



              //this.getPisos();



            })
  .catch(error => {
    this.ModoEditar = true;

    this.isLoading=false
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




},
getPublicidad() {

   axios.get('/api/publicidad',{
     params: {
       filtrarCategoria: this.filtrarCategoria,filtrarCiudad: this.filtrarCiudad, showdata:true
     }
   }).then(response => {
    this.publicidades = response.data;
    this.pagination.total = this.publicidades.length;

  })
  .catch(errors => {

  });
},

modalEliminar(idEliminar){
  this.idEliminar=''
  
  this.idEliminar=idEliminar

  $("#ModalEliminar").modal("show");

},
eliminar(){
  this.isLoading=true
  axios.delete('/api/eliminarPublicidad/'+this.idEliminar).then(response=>{
   this.isLoading=false
   $("#ModalEliminar").modal("hide");

   Vue.$toast.open({
    message:'Registro eliminado' ,
    type: 'info',
    position: 'top-right',
    duration: 5000,
    dismissible: true
    // all of other options may go here
  })
   this.getPublicidad();
 }).catch(error => {
  this.isLoading=false


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

},

paginate(array, length, pageNumber) {
  this.pagination.from = array.length ? ((pageNumber - 1) * length) + 1 : ' ';
  this.pagination.to = pageNumber * length > array.length ? array.length : pageNumber * length;
  this.pagination.prevPage = pageNumber > 1 ? pageNumber : '';
  this.pagination.nextPage = array.length > this.pagination.to ? pageNumber + 1 : '';
  return array.slice((pageNumber - 1) * length, pageNumber * length);
},
resetPagination() {
  this.pagination.currentPage = 1;
  this.pagination.prevPage = '';
  this.pagination.nextPage = '';
},
sortBy(key) {
  this.resetPagination();
  this.sortKey = key;
  this.sortOrders[key] = this.sortOrders[key] * -1;
},
getIndex(array, key, value) {
  return array.findIndex(i => i[key] == value)
},
},
computed: {

  filteredPublicidad() {
    let publicidades = this.publicidades;
    if (this.search) {
      publicidades = publicidades.filter((row) => {
        return Object.keys(row).some((key) => {
          return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
        })
      });
    }
    let sortKey = this.sortKey;
    let order = this.sortOrders[sortKey] || 1;
    if (sortKey) {
      publicidades = publicidades.slice().sort((a, b) => {
        let index = this.getIndex(this.columns, 'name', sortKey);
        a = String(a[sortKey]).toLowerCase();
        b = String(b[sortKey]).toLowerCase();
        if (this.columns[index].type && this.columns[index].type === 'date') {
          return (a === b ? 0 : new Date(a).getTime() > new Date(b).getTime() ? 1 : -1) * order;
        } else if (this.columns[index].type && this.columns[index].type === 'number') {
          return (+a === +b ? 0 : +a > +b ? 1 : -1) * order;
        } else {
          return (a === b ? 0 : a > b ? 1 : -1) * order;
        }
      });
    }
    return publicidades;
  },
  paginatedPublicidad() {
    return this.paginate(this.filteredPublicidad, this.length, this.pagination.currentPage);
  }
}
};
</script>
<style>
.img-publicidad{
  height: 100px; width: 100px; border: solid 1px #ddd; border-radius: 10px;
}
</style>

