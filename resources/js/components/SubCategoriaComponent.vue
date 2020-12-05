<template>
  <div class="main-content">
    <div  class="contenedor">
      <div class="container-fluid">
        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8">
              <div class="page-header-title">
               <div class="d-inline">
                <h5>Módulo de subcategorías</h5>
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
            <th>Categoría</th>
            <th>Editar</th>
          </tr>
        </thead>
        <tbody>

          <tr v-for="item in paginatedSubCategorias" :key="item.id">
            <td>{{item.nombre}}</td>
            <td>{{item.categoria_nombre}}</td>
            
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
            {{pagination.from}} - {{pagination.to}} de un total {{filteredSubCategorias.length}}
            <span v-if="`filteredSubCategorias.length < pagination.total`"></span>
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
    <div class="modal fade" id="modalSubCategoria" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true" data-backdrop="static">
     <div class="modal-dialog " role="document">
      <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title" id="demoModalLabel" v-text="tituloModal"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ik x-square
          ik-x-square" style=""></span></button>
        </div>
        <form @submit.prevent="modoEditar ? actualizaSubCategoria(subcategoria) : registrarSubCategoria()">
          <div class="modal-body">
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control"   placeholder="" v-model="subcategoria.nombre">
            </div>

            <div class="form-group">
                  <label>Categorías</label>
                  <v-select    placeholder="Buscar" class="style-chooser bg-white rounded mb-2 border "  v-model="subcategoria.categoria_id" :reduce="categorias => categorias.id" label="data"  :options="categorias"  ></v-select>
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
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';
export default {
  created() {
    this.getSubCategorias();
    this.getCategorias();

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

      modoEditar: false,
      btnAccion:true,
      subcategorias: [],
      categorias: [],

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
        subcategoria: {
         nombre: '',
         categoria_id:'',

       },
       
     }
   },

   methods: {

    getCategorias() {
    axios.get('/api/categoria')
    .then(response => {
      this.categorias = response.data;
      this.categorias.map(function (c){

      return c.data = c.nombre;

    });
      
    })
    .catch(errors => {

    });
  },


    modalNuevo()
    {
     this.tituloModal="Registrar una subcategoría"
     
     this.tituloBoton="Guardar";
     
     $("#modalSubCategoria").modal("show");
     

     this.reset();
     this.modoEditar = false;



   },
   registrarSubCategoria()
   {
    axios.post('/subcategoria', {
     nombre:this.subcategoria.nombre,categoria_id:this.subcategoria.categoria_id
   })
    .then(response => {

     this.reset();
     Vue.$toast.open({
      message:'Registro exitoso',
      type: 'success',
      position: 'top-right',
      duration: 5000,
      dismissible: true
    // all of other options may go here
  })

     this.subcategorias.unshift(response.data);
     /*$("#ModalPrioridad").modal("hide");*/


   })

    .catch(error => {
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
    this.subcategoria.nombre = '';
    this.subcategoria.categoria_id=''

    this.modoEditar = false;
  },modalEditar(item){
    this.modoEditar = true;
    
    this.tituloModal="Editar esta subcategoría"

    this.tituloBoton="Editar";
    $("#modalSubCategoria").modal("show");

    this.subcategoria.nombre = item.nombre;
     this.subcategoria.categoria_id = item.categoria_id;
    
    this.subcategoria.id = item.id;
    
  },actualizaSubCategoria(subcategoria){


    const params = {nombre: subcategoria.nombre,categoria_id:subcategoria.categoria_id};


    axios.put(`/subcategoria/${subcategoria.id}`, params)
    .then(response=>{
      this.ModoEditar = false;
      Vue.$toast.open({
        message:'Registo actualizado exitosamente',
        type: 'success',
        position: 'top-right',
        duration: 5000,
        dismissible: true
    // all of other options may go here
  })
      $("#modalSubCategoria").modal("hide");
      

      const index = this.subcategorias.findIndex(busqueda => busqueda.id === response.data.id)
      this.subcategorias[index].nombre=response.data.nombre;
      this.subcategorias[index].categoria_id=response.data.categoria_id;
      this.subcategorias[index].categoria_nombre=response.data.categoria_nombre;
      
      

    })
    .catch(error => {
      this.modoEditar = true;


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
  getSubCategorias() {
    axios.get('/api/subcategoria', {params: this.tableShow})
    .then(response => {
      this.subcategorias = response.data;
      
      this.pagination.total = this.subcategorias.length;
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

  filteredSubCategorias() {
    let subcategorias = this.subcategorias;
    if (this.search) {
      subcategorias = subcategorias.filter((row) => {
        return Object.keys(row).some((key) => {
          return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
        })
      });
    }
    let sortKey = this.sortKey;
    let order = this.sortOrders[sortKey] || 1;
    if (sortKey) {
      subcategorias = subcategorias.slice().sort((a, b) => {
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
    return subcategorias;
  },
  paginatedSubCategorias() {
    return this.paginate(this.filteredSubCategorias, this.length, this.pagination.currentPage);
  }
}
};
</script>

