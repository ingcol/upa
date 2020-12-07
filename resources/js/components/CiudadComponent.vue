<template>
  <div class="main-content">
    <div  class="contenedor">
      <div class="container-fluid">
        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8">
              <div class="page-header-title">
               <div class="d-inline">
                <h5>Módulo de ciudades</h5>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <button type="button" class="btn-guardar float-right"  @click="modalNuevo()"><i class="ik ik-check-circle"></i> Registrar</button>
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

       <table class="table  jambo_table bulk_action">
        <thead>
          <tr class=" tabla-fondo">
            <th>Nombre</th>
            <th>Departamento</th>
            <th>Imágen</th>
            <th>Banner</th>
            <th>Editar</th>
          </tr>
        </thead>
        <tbody>

          <tr v-for="item in paginatedCiudades" :key="item.id">
            <td>{{item.nombre}}</td>
            <td>{{item.departamento_nombre}}</td>
            <td><img v-if='item.imagen' :src="urlAmazon+item.imagen" class="img-publicidad"> </td>
            <td><img v-if='item.banner' :src="urlAmazon+item.banner" class="img-publicidad"> </td>
            <td><a @click="modalEditar(item)" class="btn-editar"><i class="ik refresh-ccw ik-refresh-ccw
              "></i> </a></td>

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
            {{pagination.from}} - {{pagination.to}} de un total {{filteredCiudades.length}}
            <span v-if="`filteredCiudades.length < pagination.total`"></span>
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
    <div class="modal fade" id="modalCiudad" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true" data-backdrop="static">
     <div class="modal-dialog modal-lg " role="document">
      <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title" id="demoModalLabel" v-text="tituloModal"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ik x-square
          ik-x-square" style=""></span></button>
        </div>
        <form @submit.prevent="modoEditar ? actualizaCiudad(ciudad) : registrarCiudad()">

          <div class="modal-body">
            <loading :active.sync="isLoading"
            :can-cancel="false"></loading>
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control"   placeholder="" v-model="ciudad.nombre">
            </div>

            <div class="form-group">
              <label>Departamento</label>
              <v-select    placeholder="Buscar" class="style-chooser bg-white rounded mb-2 border "  v-model="ciudad.estado_id" :reduce="departamentos => departamentos.id" label="data"  :options="departamentos"  ></v-select>
            </div>
            <br>
            <div class="form-group text-center">

              <span class="file mt-3">

                <input   type="file"@change="obtenerImagen" accept="image/png, image/jpeg,image/gif,image/jpg"  name="image"  ref="file"/>
                <label for="file "><i class="ik paperclip
                  ik-paperclip"></i> Seleccione una imágen</label>
                </span>
              </div>
              <hr>

              <div class="form-group text-center ">
                <br>

                <span class="file mt-3 ">

                  <input   type="file"@change="obtenerBanner" accept="image/png, image/jpeg,image/gif,image/jpg"  name="image"  ref="banner"/>
                  <label for="file "><i class="ik paperclip
                    ik-paperclip"></i> Seleccione un banner</label>
                  </span>
                </div>

              </div>
              <div class="modal-footer">
               <button  class="btn-cerrar" data-dismiss="modal" ><i class=" ik x-circle
                ik-x-circle"></i> Cerrar</button>


                <button type="submit" v-bind:class="{'btn-guardar':!modoEditar,'btn-editar':modoEditar}" ><i  v-bind:class="{'ik ik-check-circle':!modoEditar,'ik refresh-ccw ik-refresh-ccw':modoEditar}"> {{tituloBoton}} </i>  </button>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div></div>
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
     created() {
      this.getCiudades();
      this.getDepartamentos();

    },
    data() {
      let sortOrders = {};
      let columns = [
      {label: 'Nombre', name: 'nombre' },


      ];
      columns.forEach((column) => {
       sortOrders[column.nombre] = -1;
     });

      return {
        tituloModal:'',
        tituloBoton:'',
        isLoading:false,
        urlAmazon:'https://s3.us-east-2.amazonaws.com/upallanos/ciudades/',

        modoEditar: false,
        btnAccion:true,
        departamentos: [],
        ciudades: [],

        columns: columns,
        //sortKey: 'EstadoPiso',
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
        ciudad: {
         nombre: '',
         estado_id:'',
         imagen:'',
         banner:'',

       },
       
     }
   },

   methods: {
    obtenerImagen(e){

      let file=e.target.files[0];
      this.ciudad.imagen=file;


    },
    obtenerBanner(b){

      let banner=b.target.files[0];
      this.ciudad.banner=banner;
      

    },
    getDepartamentos() {
      axios.get('/api/departamento')
      .then(response => {
        this.departamentos = response.data;
        this.departamentos.map(function (c){

          return c.data = c.nombre;

        });

      })
      .catch(errors => {

      });
    },


    modalNuevo()
    {
     this.tituloModal="Registrar una ciudad"
     
     this.tituloBoton="Guardar";
     
     $("#modalCiudad").modal("show");
     

     this.reset();
     this.modoEditar = false;



   },
   registrarCiudad()
   {
    this.isLoading=true

    let formData = new FormData();
    formData.append('nombre',this.ciudad.nombre);
    formData.append('estado_id',this.ciudad.estado_id);
    formData.append('imagen',this.ciudad.imagen);
    formData.append('banner',this.ciudad.banner);
    axios.post('/ciudad', formData)
    .then(response => {
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

      this.ciudadesd.unshift(response.data);
      /*$("#ModalPrioridad").modal("hide");*/


    })

    .catch(error => {
      this.isLoading=false
      this.errors = [];
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
    this.ciudad.nombre = '';
    this.ciudad.estado_id=''
    this.$refs.file.value=null;
    this.$refs.banner.value=null;

    this.modoEditar = false;
  },modalEditar(item){
    this.modoEditar = true;
    
    this.tituloModal="Editar esta ciudad"

    this.tituloBoton="Editar";
    $("#modalCiudad").modal("show");

    this.ciudad.nombre = item.nombre;
    this.ciudad.estado_id = Number(item.estado_id)
  
    
    this.ciudad.id = item.id;


    
  },actualizaCiudad(ciudad){



    this.isLoading=true
    let formData = new FormData();
    formData.append('nombre',this.ciudad.nombre);
    formData.append('estado_id',this.ciudad.estado_id);
    formData.append('imagen',this.ciudad.imagen);
    formData.append('banner',this.ciudad.banner);
    //const params = {nombre: ciudad.nombre,estado_id:ciudad.estado_id};

    formData.append('_method', 'put');
    axios.post(`ciudad/${ciudad.id}`,formData)
    .then(response=>{
      this.reset();
      this.isLoading=false
      this.ModoEditar = false;
      Vue.$toast.open({
        message:'Registo actualizado exitosamente',
        type: 'success',
        position: 'top-right',
        duration: 5000,
        dismissible: true
    // all of other options may go here
  })
      $("#modalCiudad").modal("hide");
      

      const index = this.ciudades.findIndex(busqueda => busqueda.id === response.data.id)
      this.ciudades[index].nombre=response.data.nombre;
      this.ciudades[index].estado_id=response.data.estado_id;
      this.ciudades[index].departamento_nombre=response.data.departamento_nombre;
      this.ciudades[index].imagen=response.data.imagen;
      this.ciudades[index].banner=response.data.banner;
      
      

    })
    .catch(error => {
      this.modoEditar = true;

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
  getCiudades() {
    axios.get('/api/ciudad', {params: this.tableShow})
    .then(response => {
      this.ciudades = response.data;
      
      this.pagination.total = this.ciudades.length;
    })
    .catch(errors => {

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

  filteredCiudades() {
    let ciudades = this.ciudades;
    if (this.search) {
      ciudades = ciudades.filter((row) => {
        return Object.keys(row).some((key) => {
          return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
        })
      });
    }
    let sortKey = this.sortKey;
    let order = this.sortOrders[sortKey] || 1;
    if (sortKey) {
      ciudades = ciudades.slice().sort((a, b) => {
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
    return ciudades;
  },
  paginatedCiudades() {
    return this.paginate(this.filteredCiudades, this.length, this.pagination.currentPage);
  }
}
};
</script>

