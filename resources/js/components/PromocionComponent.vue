<template>
	<div class="main-content">
		<div class="contenedor">
			<div class="container-fluid">
				<div class="page-header">
					<div class="row align-items-end">
						<div class="col-lg-8">
							<div class="page-header-title">

								<div class="d-inline">
									<h5> Módulo de promociones</h5>

								</div>
							</div>
						</div>
						<div class="col-lg-4">


							<button type="button" class="btn-guardar float-right" @click="ModalNuevo()"><i class="ik ik-check-circle"></i> Registrar</button>
						</div>
					</div>
				</div>
				<hr>
        <div class="row">
          <div class="col-md-4">
            <label>Filtrar</label>

            <select v-model="length" @change="resetPagination()" class="form-control input-custom">
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="30">30</option>
            </select>

          </div>

          <div class="col-md-4"> </div>
          <div class="col-md-4">
            <label>Búsqueda</label>

            <input type="text" v-model="search" placeholder="" @input="resetPagination()" class="form-control input-custom">
          </div>
        </div>

        <br>
        <div class="table-responsive" >
         <table class="table  jambo_table bulk_action  " id="table_grupo" >
          <thead>
            <tr class=" tabla-fondo">
              <th v-if="rolUsuario=='is_admin_rol'">Empresa</th>
              <th>Titulo</th>
              <th>Descripción</th>
              <th>Estado</th>
              <th>Fecha inicial</th>
              <th>Fecha finalización</th>
              <th>Tipo</th>
              <th>Visualización</th>
              <th>Editar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in paginatedPromociones" :key="item.id">
              <td v-if="rolUsuario=='is_admin_rol'">{{item.empresa_nombre}}</td>
              <td>{{item.titulo}}</td>
              <td>{{item.descripcion}}</td>
              <td><span v-if='item.estado=="1"'>Activo</span> <span v-else>Inactivo</span></td>
              <td>{{item.fechainicio}}</td>
              <td>{{item.fechafin}}</td>
              <td>{{item.tipo}}</td>
              <td><span class="badge badge-primary mb-2 " v-if="item.domingo==0">Domingo</span>
                <span class="badge badge-secondary mb-2 " v-if="item.lunes">Lunes</span>
                <span class="badge badge-success mb-2  mb-2 "  v-if="item.martes">Martes</span>
                <span class="badge badge-danger"  v-if="item.miercoles">Miércoles</span>
                <span class="badge badge-warning mb-2 "  v-if="item.jueves">Jueves</span>
                <span class="badge badge-info mb-2 "  v-if="item.viernes">Viernes</span>
                <span class="badge badge-light mb-2 "  v-if="item.sabado">Sábado</span>
              </td>
              <td>
                <a  v-if="rolUsuario=='is_admin_rol'" @click="ModalEditar(item)" class="btn-editar"><i class="ik refresh-ccw ik-refresh-ccw
                  "></i> </a>
                  <span v-else> <a v-if="item.fechafin>=fechActual"   @click="ModalEditar(item)" class="btn-editar"><i class="ik refresh-ccw ik-refresh-ccw
                    "></i> </a>
                  </span>
                </td>

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
              {{pagination.from}} - {{pagination.to}} de un total {{filteredPromociones.length}}
              <span v-if="`filteredPromociones.length < pagination.total`"></span>
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
      <div class="modal fade" id="ModalPromocion" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true" data-backdrop="static">

       <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
         <div class="modal-header">
          <h5 class="modal-title" id="demoModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ik x-square
            ik-x-square" style=""></span></button>
          </div>
          <form @submit.prevent="ModoEditar ? ActualizarPromocion(promocion) : CrearPromocion()">
            <div class="modal-body">
             <loading :active.sync="isLoading"
             :can-cancel="false"></loading>

             <div class="row">
              <div :class="{'col-md-4':rolUsuario=='is_admin_rol','col-md-6':rolUsuario!='is_admin_rol'}">
                <div class="form-group">
                  <label>Tipo</label>
                  <select class="form-control" v-model="promocion.tipo" >
                    <option value="">Seleccione</option>
                    <option value="Evento">Evento</option>
                    <option value="Promocion">Promoción</option>
                  </select>
                </div>
              </div>

              <div :class="{'col-md-4':rolUsuario=='is_admin_rol','col-md-6':rolUsuario!='is_admin_rol'}">
                <div class="form-group">
                  <label>Título</label>
                  <input type="text" class="form-control"    placeholder="" v-model="promocion.titulo">
                </div>

              </div>
              <div v-if="rolUsuario=='is_admin_rol'" class="col-md-4">
                <div class="form-group">
                  <label>Empresa</label>
                  <v-select    placeholder="Buscar" class="style-chooser bg-white rounded mb-2 border "  v-model="promocion.empresa_id" :reduce="empresas => empresas.id" label="data"  :options="empresas"  ></v-select>
                </div>
              </div>
            </div>


            <div class="form-group">
              <label >Descripción</label>
              <textarea class="form-control" row="2" v-model="promocion.descripcion"></textarea>

            </div>
            <div  v-if='validarFecha'>
              <div class="row">

                <div  v-bind:class="{'col-md-4':rolUsuario=='is_admin_rol','col-md-6':rolUsuario!='is_admin_rol',}">
                  <div class="form-group">
                    <label >Fecha de inicio</label>
                    <date-pick 
                    v-model="promocion.fechainicio"  :displayFormat="'YYYY-MM-DD'"
                    :nextMonthCaption="nextMonthCaption" :weekdays="weekdays" :months="months":prevMonthCaption="prevMonthCaption" :inputAttributes="{readonly: true}"  class="calendar-desing"
                    ></date-pick>
                  </div>
                </div>

                <div v-bind:class="{'col-md-4':rolUsuario=='is_admin_rol','col-md-6':rolUsuario!='is_admin_rol',}">
                  <div class="form-group">
                    <label >Fecha de finalización</label>
                    <date-pick v-model="promocion.fechafin":displayFormat="'YYYY-MM-DD'"
                    :nextMonthCaption="nextMonthCaption" :weekdays="weekdays" :months="months":prevMonthCaption="prevMonthCaption" :inputAttributes="{readonly: true}"  class="calendar-desing"
                    ></date-pick>
                  </div>
                </div>

                <div class="col-md-4" v-if="rolUsuario=='is_admin_rol'">
                  <div class="form-group">
                    <label >Estado</label>
                    <select class="form-control" v-model='promocion.estado'>
                      <option value="1">Activo</option>
                      <option value="0">Inactivo</option>
                    </select>
                  </div>
                </div>

              </div>
              
              
              <div class="form-group">
                <label>Mostrar publicidad</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" v-model='checkAll' @change="todosDias()" type="checkbox" id="inlineCheckbox1" >
                <label class="form-check-label" for="inlineCheckbox1">Todos</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input"  @change='opcionTodo' v-model='promocion.domingo' type="checkbox" id="inlineCheckbox1" >
                <label class="form-check-label" for="inlineCheckbox1">Domingo</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" @change='opcionTodo' v-model='promocion.lunes' type="checkbox" id="inlineCheckbox2">
                <label class="form-check-label" for="inlineCheckbox2">Lunes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" @change='opcionTodo' v-model='promocion.martes' type="checkbox" id="inlineCheckbox3">
                <label class="form-check-label" for="inlineCheckbox3">Martes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" @change='opcionTodo' v-model='promocion.miercoles'>
                <label class="form-check-label" for="inlineCheckbox3">Miércoles</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input"  @change='opcionTodo'v-model='promocion.jueves'  type="checkbox" id="inlineCheckbox3" >
                <label class="form-check-label" for="inlineCheckbox3">Jueves</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input"  @change='opcionTodo'v-model='promocion.viernes' type="checkbox" id="inlineCheckbox3" >
                <label class="form-check-label" for="inlineCheckbox3">Viernes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" @change='opcionTodo' v-model='promocion.sabado' type="checkbox">
                <label class="form-check-label" for="inlineCheckbox3">Sábado</label>
              </div>
            </div>


            <div class="text-center mb-3 mt-3 form-control">

              <img v-if="imagenGuardada && imagenActiva"  :src="imagenGuardada" class="img-promocion">
              <img v-else :src="imagen"  class="img-promocion" alt="Perfil">
            </div>
            <div class="text-center">

              <span class="file mt-3">

                <input   type="file"@change="obtenerImagen" accept="image/png, image/jpeg,image/gif,image/jpg"  name="image"  ref="file"/>
                <label for="file "><i class="ik paperclip
                  ik-paperclip"></i> Seleccione</label>
                </span>
              </div>

            </div>
            <div class="modal-footer">
              <button  class="btn-cerrar" data-dismiss="modal"><i class=" ik x-circle
                ik-x-circle"></i> Cerrar</button>
                <button type="submit" class=""  id="BtnAccion":disabled="disabled"><i class="" id="icon-save"> </i></button>

              </div>
            </form>
          </div>
        </div>


      </div>

    </div>

  </div>
</template>

<script>
  import PulseLoader from 'vue-spinner/src/ClipLoader.vue'
  import DatePick from 'vue-date-pick';
  import 'vue-date-pick/dist/vueDatePick.css';
  import Vue from 'vue';
  import VueToast from 'vue-toast-notification';
  import 'vue-toast-notification/dist/theme-sugar.css';
  import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default {
      mounted() {
        this.getPromociones();
        this.obtenerEmpresas();

      },
      components: {DatePick,'PulseLoader': PulseLoader,Loading},
      data() {
        let sortOrders = {};
        let columns = [
        {label: 'Titulo', name: 'titulo' },
        {label: 'Descripcion', name: 'descripcion'},


        ];
        columns.forEach((column) => {
         sortOrders[column.titulo] = -1;
       });

        return {
          rolUsuario:'',
          checkAll:false,
          isLoading:false,
          disabled:false,
          color:'orange',
          imagenGuardada:'',
          fechActual:'',
          validarEditar:true,

          ModoEditar: false,
          validarFecha:true,
          promociones: [],
          columns: columns,
          empresas:[],
          

          sortOrders: sortOrders,
          length: 10,
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
          promocion: {
           titulo: '',
           descripcion: '',
           fechainicio:'',
           fechafin:'',
           file: '',
           tipo:'',
           estado:'',
           domingo:'',
           lunes:'',
           martes:'',
           miercoles:'',
           jueves:'',
           viernes:'',
           sabado:'',
           empresa_id:'',
         },
         imagenActiva:true,
         imagenMiniatura:'img/fondo.png',

//date
nextMonthCaption:  'Sig mes',
prevMonthCaption:'Ant mes',
weekdays: [
'lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sab', 'Dom'
],
months: [
'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
],


}
},

methods: {
  obtenerEmpresas() {
    axios.get('/api/listadoEmpresas')
    .then(response => {
     this.empresas=response.data;




     this.empresas.map(function (c){

      return c.data = c.nombre;

    });

   })
    .catch(errors => {

    });
  },
  todosDias(){


    if (this.checkAll) {
      this.promocion.domingo=true
      this.promocion.lunes=true
      this.promocion.martes=true
      this.promocion.miercoles=true
      this.promocion.jueves=true
      this.promocion.viernes=true
      this.promocion.sabado=true
      

    }else{

      this.promocion.domingo=false
      this.promocion.lunes=false
      this.promocion.martes=false
      this.promocion.miercoles=false
      this.promocion.jueves=false
      this.promocion.viernes=false
      this.promocion.sabado=false


    }

  },

  opcionTodo(){

    if (this.promocion.domingo && 
      this.promocion.lunes &&
      this.promocion.martes &&
      this.promocion.miercoles &&
      this.promocion.jueves &&
      this.promocion.viernes &&
      this.promocion.sabado) {

      this.checkAll=true
  }

  else{

    this.checkAll=false
  }

},

obtenerImagen(e){

  let file=e.target.files[0];
  this.promocion.file=file;
  this.cargarImagen(file);
  this.imagenActiva=false;

},

cargarImagen(file){

  let reader=new FileReader();

  reader.onload=(e)=>{
    this.imagenMiniatura=e.target.result;
  };
  reader.readAsDataURL(file);


},

ModalNuevo()
{
  this.reset();


  $('.modal-title').text('Registrar una promoción');
  $('#icon-save').removeClass('ik refresh-ccw ik-refresh-ccw');
  $('#icon-save').addClass('ik ik-check-circle');
  $('#BtnAccion').removeClass('btn-editar');
  $('#BtnAccion').addClass('btn-guardar');
  $("#ModalPromocion").modal("show");
  $('#icon-save').text(' Guardar');

  this.reset();
  this.ModoEditar = false;

  this.imagenGuardada=''
  this.validarFecha=true

},
CrearPromocion()
{
  this.disabled=true
  this.isLoading=true
      //data inputs
      let formData = new FormData();

      formData.append('titulo', this.promocion.titulo);
      formData.append('descripcion', this.promocion.descripcion);
      formData.append('fechainicio', this.promocion.fechainicio);
      formData.append('fechafin', this.promocion.fechafin);
      formData.append('file', this.promocion.file);
      formData.append('tipo', this.promocion.tipo);
      formData.append('estado', this.promocion.estado);
      formData.append('domingo', this.promocion.domingo);
      formData.append('lunes', this.promocion.lunes);
      formData.append('martes', this.promocion.martes);
      formData.append('miercoles', this.promocion.miercoles);
      formData.append('jueves', this.promocion.jueves);
      formData.append('viernes', this.promocion.viernes);
      formData.append('sabado', this.promocion.sabado);
      formData.append('empresa_id', this.promocion.empresa_id);

      axios.post('api/guardarPromocion', formData)
      .then(response => {
        this.disabled=false
        this.isLoading=false
        Vue.$toast.open({
          message:'Registro creado con éxito',
          type: 'success',
          position: 'top-right',
          duration: 5000,
          dismissible: true
    // all of other options may go here
  })
        this.reset();
        this.promociones.unshift(response.data);
        /*$("#ModalPrioridad").modal("hide");*/


      })

      .catch(error => {
       this.disabled=false
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
      this.promocion.titulo = ''
      this.promocion.descripcion = ''
      this.promocion.file=''
      this.promocion.fechainicio=''
      this.promocion.fechafin=''
      this.imagenMiniatura='img/fondo.png',
      this.promocion.tipo=''
      this.$refs.file.value=null;
      this.promocion.domingo=''
      this.promocion.lunes=''
      this.promocion.martes=''
      this.promocion.miercoles=''
      this.promocion.jueves=''
      this.promocion.viernes=''
      this.promocion.sabado=''
      this.checkAll=''
      this.promocion.estado='1'
      this.promocion.empresa_id=''


    },ModalEditar(item){

     this.validarFecha=true

     if (item.estado!=0 && this.rolUsuario!='is_admin_rol') {

      this.validarFecha=false
    }



    this.imagenActiva=true;
    $('.modal-title').text('Editar promoción');
    $("#icon-save").removeClass( "ik-check-circle" );
    $('#icon-save').addClass('ik refresh-ccw ik-refresh-ccw');
    $('#BtnAccion').removeClass('btn-guardar ');
    $('#BtnAccion').addClass('btn-editar');
    $("#ModalPromocion").modal("show");
    $('#icon-save').text(' Editar')
    this.promocion.titulo = item.titulo;
    this.promocion.descripcion = item.descripcion;
    this.promocion.file = item.file;

    this.promocion.fechainicio= item.fechainicio;
    this.promocion.fechafin= item.fechafin;
    this.promocion.tipo=item.tipo
    this.imagenGuardada=item.file_url
    if(this.rolUsuario=='is_admin_rol'){

      this.promocion.estado=item.estado
     
      this.promocion.empresa_id=Number(item.empresa_id)



      
    }


    if (item.domingo==0) {
     this.promocion.domingo=true

   }

   if (item.lunes) {
    this.promocion.lunes=true
  }
  if (item.martes) {
    this.promocion.martes=true
  }
  if (item.miercoles) {
    this.promocion.miercoles=true
  }
  if (item.jueves) {
    this.promocion.jueves=true
  }
  if (item.viernes) {
    this.promocion.viernes=true
  }
  
  if (item.sabado) {
    this.promocion.sabado=true
  }

  
  
  this.promocion.id = item.id;
  this.ModoEditar = true;
  this.opcionTodo();
},ActualizarPromocion(promocion){



  this.isLoading=true
      //data inputs
      let formData = new FormData();

      formData.append('titulo', this.promocion.titulo);
      formData.append('descripcion', this.promocion.descripcion);
      formData.append('fechainicio', this.promocion.fechainicio);
      formData.append('fechafin', this.promocion.fechafin);
      formData.append('file', this.promocion.file);
      formData.append('tipo', this.promocion.tipo);
      formData.append('estado', this.promocion.estado);
      formData.append('domingo', this.promocion.domingo);
      formData.append('lunes', this.promocion.lunes);
      formData.append('martes', this.promocion.martes);
      formData.append('miercoles', this.promocion.miercoles);
      formData.append('jueves', this.promocion.jueves);
      formData.append('viernes', this.promocion.viernes);
      if (this.rolUsuario=='is_admin_rol') {
        formData.append('empresa_id', this.promocion.empresa_id);
      }
      formData.append('sabado', this.promocion.sabado);

      formData.append('_method', 'put');

      axios.post(`/api/actualizarPromocion/${promocion.id}`, formData)
      .then(response=>{
        this.isLoading=false
        this.ModoEditar = false;
        Vue.$toast.open({
          message:'Registro actualizado con éxito',
          type: 'success',
          position: 'top-right',
          duration: 5000,
          dismissible: true
    // all of other options may go here
  })
        $("#ModalPromocion").modal("hide");

        const index = this.promociones.findIndex(busqueda => busqueda.id === response.data.id)
        this.promociones[index].titulo=response.data.titulo;
        this.promociones[index].descripcion=response.data.descripcion;
        this.promociones[index].fechainicio=response.data.fechainicio;

        this.promociones[index].fechafin=response.data.fechafin;
        this.promociones[index].tipo=response.data.tipo;
        this.promociones[index].file_url=response.data.file_url;
        this.promociones[index].domingo=response.data.domingo;
        this.promociones[index].lunes=response.data.lunes;
        this.promociones[index].martes=response.data.martes;
        this.promociones[index].miercoles=response.data.miercoles;
        this.promociones[index].jueves=response.data.jueves;
        this.promociones[index].viernes=response.data.viernes;
        this.promociones[index].sabado=response.data.sabado;
        this.promociones[index].empresa_id=response.data.empresa_id;

        this.promociones[index].empresa_nombre=response.data.empresa_nombre;


        



              //this.getPrioridades();



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
    getPromociones() {
      axios.get('/api/promocion', {params: this.tableShow})
      .then(response => {
        this.promociones = response.data.promocion;
        this.rolUsuario=response.data.rolUsuario
        this.fechActual=response.data.FechaActual




        this.pagination.total = this.promociones.length;
      })
      .catch(errors => {
        //console.log(errors);
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

    imagen(){
      return this.imagenMiniatura;

    },

    filteredPromociones() {
      let promociones = this.promociones;
      if (this.search) {
        promociones = promociones.filter((row) => {
          return Object.keys(row).some((key) => {
            return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
          })
        });
      }
      let sortKey = this.sortKey;
      let order = this.sortOrders[sortKey] || 1;
      if (sortKey) {
        promociones = promociones.slice().sort((a, b) => {
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
      return promociones;
    },
    paginatedPromociones() {
      return this.paginate(this.filteredPromociones, this.length, this.pagination.currentPage);
    }
  }
};
</script>

<style>

.img-promocion{
  max-width: 400px;
  max-height: 150px;
  width: 100%;
  height: 100%;
  padding: 6px;
}

.vdpArrowPrev:after {
  border-right-color: #cc99cd;
  font-size: 16px;
}

.vdpArrowNext:after {
  border-left-color: #cc99cd;font-size: 16px;

}


.vdpCell.selectable:hover .vdpCellContent,
.vdpCell.selected .vdpCellContent {
  background: #cc99cd;
}

.vdpCell.today {
  color: white;
  border-radius: 5px;
  background: orange;
}

.vdpTimeUnit > input:hover,
.vdpTimeUnit > input:focus {
  border-bottom-color: #cc99cd;

}
.vdpComponent{
  /* position: relative; */
  display: block;
  font-size: 10px;
  color: #303030;
}
.vdpWithInput>input{

  position: none;
  width: 100% !important;
  height: 35px;
  padding: .375rem .75rem;
  font-size: 13px;

  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #eaeaea;
  border-radius: .25rem;
}
.calendar-desing > input{

  transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;

}

.file {
  position: relative;
  cursor: pointer;
}
.file label {
  padding: 4px 18px !important;
  background:orange;
  cursor: pointer;
  border: 0;
  border-radius: 5px;
  color: white
}
.file input {
  position: absolute;
  width: 100%;
  left: 0;
  top: 0;
  opacity: 0.01;
  cursor: pointer;
}
.file input:hover + label,
.file input:focus + label {
  background: #34495E;
  color: #39D2B4;
}

</style>

