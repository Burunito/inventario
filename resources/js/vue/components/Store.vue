<template>
    <div>
        <o-modal v-model:active="confirmDelete">
            <p>¿Estás seguro de eliminar el registro? Se eliminarán todas las relaciones que tiene.</p>
            <div>
                <o-button variant="primary" @click="deleteProducto()">Continuar</o-button>
                <o-button variant="danger" @click="closeModal()">Cancelar</o-button>
            </div>
        </o-modal>
        <o-modal v-model:active="calificar">
            <div class="p-4">
                <p>Califique el producto.</p>
                <div class="row">
                    <div class="block">
                        <o-radio v-model="calificacion" name="calificacion" native-value="1">1</o-radio>
                        <o-radio v-model="calificacion" name="calificacion" native-value="2">2</o-radio>
                        <o-radio v-model="calificacion" name="calificacion" native-value="3">3</o-radio>
                        <o-radio v-model="calificacion" name="calificacion" native-value="4">4</o-radio>
                        <o-radio v-model="calificacion" name="calificacion" native-value="5">5</o-radio>
                    </div>
                </div>
                <div class="row justify-content-around">
                    <o-button class="btn-small col-5" variant="primary" @click="saveCalificar()">Continuar</o-button>
                    <o-button class="btn-small col-5" variant="danger" @click="closeCalificar()">Cancelar</o-button>
                </div>
            </div>
        </o-modal>
        <div v-if="respuesta.current_page && respuesta.data.length">
            <div v-for="producto in respuesta.data" :key="producto.id">
                <div class="container m-2 p-2 tarjeta">
                    <div class="row">
                        <div class="col-3">
                            <img :src="'../../img/test.jpg'">
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    <b>{{ producto.nombre }}</b>
                                </div>
                                <div class="col-12">
                                    <div v-if="producto.categorias">
                                        <div v-for="categoria in producto.categorias" :key="categoria.id">
                                            {{ categoria.categoria.nombre }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-start">
                                    <div class="col-3">{{ producto.calificacion }}</div>
                                </div>
                                <div class="row justify-content-start">
                                    <div class="col-3">
                                        <div v-if="producto.estado" variant="success">Disponible</div>
                                        <div v-else variant="success">No disponible</div> 
                                    </div>
                                </div>
                                <div class="row justify-content-start">
                                    <div>
                                        {{ producto.cantidad }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="row justify-content-start m-2">
                                <div class="col-12">${{ producto.precio }}</div>
                            </div>
                            <div class="row justify-content-start m-2">
                                <div class="col-12">
                                    <div v-if="producto.estado" variant="success">Disponible</div>
                                    <div v-else variant="success">No disponible</div> 
                                </div>
                            </div>
                            <div class="col-12 m-2">
                                <o-button class="btn-md" variant="danger" @click="showModal(producto.id)">Eliminar</o-button>
                            </div>
                            <div class="col-12 m-2">
                                <o-button class="btn-md" variant="success" @click="showCalificar(producto.id)">Calificar</o-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p v-else>No Hay datos para mostrar!</p>
        <o-pagination
        @change="listPage"
            :total="respuesta.total"
            v-model:current="currentPage"
            :range-before="rangeBefore"
            :range-after="rangeAfter"
            :order="order"
            :size="size"
            :simple="isSimple"
            :rounded="isRounded"
            :per-page="respuesta.per_page"
            :icon-prev="prevIcon"
            :icon-next="nextIcon"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page"
        >
        </o-pagination>
    </div>
</template>


<script>
export default {

    data() {
        return {
            respuesta: [],
            rangeBefore: 2,
            rangeAfter: 2,
            currentPage: 1,
            order: '',
            size: '',
            isSimple: false,
            isRounded: false,
            prevIcon: 'chevron-left',
            nextIcon: 'chevron-right',
            calificar: false,
            confirmDelete: false,
            deleteProductoId: 0,
            calificarProductoId: 0,
            calificacion: 0
        }
    },
    methods: {
        showModal(id) {
            this.deleteProductoId = id;
            this.confirmDelete = true;
        },
        closeModal() {
            this.deleteProductoId = 0;
            this.confirmDelete = false;
        },
        showCalificar(id) {
            this.calificarProductoId = id;
            this.calificar = true;
        },
        closeCalificar() {
            this.calificarProductoId = 0;
            this.calificacion = 0;
            this.calificar = false;
        },
        deleteProducto() {
            this.$axios.delete('/api/productos/'+this.deleteProductoId).then((res) => {
                this.confirmDelete = false;
                this.deleteProductoId = 0;
                this.listPage(this.page);
            })
        },
        saveCalificar() {
             this.$axios.patch('/api/productos/calificar/'+this.calificarProductoId, 
                {calificacion: this.calificacion}
                )
                .then(res => {
                    this.listPage(this.page);
                    this.calificar = false;
                });
        },
        listPage(page) {
            this.currentPage = page;
            this.$axios.get('/api/productos?page='+this.currentPage).then((res) => {
                this.respuesta = res.data;
                this.loading = false;      
            })
        }
    },
    async mounted() {
        this.listPage();
    }
}
</script>