<template>
    <div class="container-fluid">
        <o-modal v-model:active="confirmDelete">
            <p>¿Estás seguro de eliminar el registro? Se eliminarán todas las relaciones que tiene.</p>
            <div>
                <o-button variant="primary" @click="deleteProducto()">Continuar</o-button>
                <o-button variant="danger" @click="closeModal()">Cancelar</o-button>
            </div>
        </o-modal>
        <router-link :to="{ name:'producto' }"><div class="pull-right"><o-button>Agregar</o-button></div></router-link>
        <div v-if="respuesta.current_page && respuesta.data.length">
           <o-table
            :data="respuesta.data.length ? respuesta.data : []"
            :bordered="isBordered"
            :striped="isStriped"
            :narrowed="isNarrowed"
            :hoverable="isHoverable"
            :loading="isLoading"
            :focusable="isFocusable"
            :mobile-cards="hasMobileCards"
            >
                <o-table-column field="id" label="ID" width="40" numeric v-slot="props">
                    {{ props.row.id }}
                </o-table-column>

                 <o-table-column field="sku" label="SKU" v-slot="props">
                    {{ props.row.sku }}
                </o-table-column>

                <o-table-column field="nombre" label="Producto" v-slot="props">
                    {{ props.row.nombre }}
                </o-table-column>

                <o-table-column field="categorias" label="Categorías" position="centered" v-slot="props">
                    <div v-if="props.row.categorias.length">
                        <div v-for="categoria in props.row.categorias" :key="categoria.id">
                            {{ categoria.categoria.nombre }}
                        </div>
                    </div>
                </o-table-column>

                <o-table-column field="calificación" label="Calificación" position="centered" v-slot="props">
                    {{ props.row.calificacion }}
                </o-table-column>
                <o-table-column field="slug" label="Acciones" position="centered" v-slot="props">
                    <div>
                        <router-link :to="{ name:'detalle', params: { 'id': props.row.id } }"><o-button>Detalle</o-button></router-link>
                        <router-link :to="{ name:'producto', params: { 'id': props.row.id } }"><o-button>Editar</o-button></router-link>
                        <o-button v-if="props.row.estado" variant="success" @click="switchStock(props.row.id)">Con stock</o-button>
                        <o-button v-else variant="success" @click="switchStock(props.row.id)">Sin stock</o-button>
                        <o-button variant="danger" @click="showModal(props.row.id)">Eliminar</o-button>
                    </div>
                </o-table-column>
                
            </o-table>
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
            order: 'centered',
            size: 'medium',
            isSimple: false,
            isRounded: true,
            prevIcon: 'arrow-left',
            nextIcon: 'arrow-right',
            isBordered: true,
            isStriped: true,
            isNarrowed: true,
            isHoverable: true,
            isFocusable: false,
            isLoading: true,
            hasMobileCards: true,
            confirmDelete: false,
            deleteProductoId: 0
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
        deleteProducto() {
            this.$axios.delete('/api/productos/'+this.deleteProductoId).then((res) => {
                this.confirmDelete = false;
                this.deleteProductoId = 0;
                this.listPage(this.page);
            })
        },
        switchStock(id) {
            this.$axios.patch('/api/productos/stock/'+id).then((res) => {
                this.listPage(this.page);    
            })
        },
        listPage(page) {
            this.currentPage = page;
            this.$axios.get('/api/productos?page='+this.currentPage).then((res) => {
                this.respuesta = res.data;
                this.isLoading = false;      
            })
        }
    },
    async mounted() {
        this.listPage();
    }
}
</script>