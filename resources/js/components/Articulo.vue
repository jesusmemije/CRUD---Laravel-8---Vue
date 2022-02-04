<template>
  <div>
    <h1 class="text-center">Gestionar Artículos</h1>
    <hr />

    <!-- Button trigger modal -->
    <button @click="modificar=false; abrirModal()" type="button" class="btn btn-primary my-3">
        Nuevo
    </button>

    <!-- Modal -->
    <div v-bind:class="{ mostrar: modal }" class="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ tituloModal }}</h5>
                    <button @click="cerrarModal()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre">Nombre</label>
                        <input v-model="articulo.nombre" type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Artículo">
                        <span class="text-danger" v-if="errores.nombre">{{ errores.nombre[0] }}</span>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion">Descripción</label>
                        <input v-model="articulo.descripcion" type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del Artículo">
                        <span class="text-danger" v-if="errores.descripcion">{{ errores.descripcion[0] }}</span>
                    </div>
                    <div class="mb-3">
                        <label for="stock">Stock</label>
                        <input v-model="articulo.stock" type="number" class="form-control" id="stock" name="stock" placeholder="Stock del Artículo">
                        <span class="text-danger" v-if="errores.stock">{{ errores.stock[0] }}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button @click="cerrarModal()" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button @click="guardar()" type="button" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Descripcion</th>
          <th scope="col">Stock</th>
          <th scope="col" colspan="2" class="text-center">Acción</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="articulo in articulos" :key="articulo.id">
          <th scope="row">{{ articulo.id }}</th>
          <td>{{ articulo.nombre }}</td>
          <td>{{ articulo.descripcion }}</td>
          <td>{{ articulo.stock }}</td>
          <td><button @click="modificar=true; abrirModal(articulo)" class="btn btn-warning">Editar</button></td>
          <td><button @click="eliminar(articulo.id)" class="btn btn-danger">Eliminar</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
    data() {
        return {
            articulo : {
                nombre : 'Jesús',
                descripcion : 'Nothing for the moment',
                stock : 1,
            },
            id : 0,
            modificar : true,
            modal : 0,
            tituloModal : '',
            articulos : [],
            errores : {},
        }
    },
    methods: {
        async listar () {
            const res = await axios.get('/articulos');
            this.articulos = res.data;
        },
        async eliminar (id) {
            const res = await axios.delete('/articulos/' + id);
            this.listar();
        },
        async guardar () {
            try {
                if (this.modificar) {
                    const res = await axios.put('/articulos/' + this.id, this.articulo);
                } else {
                    const res = await axios.post('/articulos', this.articulo);
                }
                this.cerrarModal();
                this.listar();
            } catch (error) {
                if (error.response.data) {
                    this.errores = error.response.data.errors;
                }
            }
        },
        abrirModal (data = {}){
            this.modal = 1;
            if (this.modificar) {
                this.id = data.id;
                this.tituloModal = "Modificar Artículo";
                this.articulo.nombre = data.nombre;
                this.articulo.descripcion = data.descripcion;
                this.articulo.stock = data.stock;
            } else {
                this.id = 0;
                this.tituloModal = "Crear Artículo";
                this.articulo.nombre = '';
                this.articulo.descripcion = '';
                this.articulo.stock = 1;
            }
        },
        cerrarModal (){
            this.modal = 0;
        },
    },
    created() {
        this.listar();
    }
};
</script>
<style>
    .mostrar {
        display: list-item;
        opacity: 1;
        background: rgba(44, 38, 75, 0.849);
    }
</style>
