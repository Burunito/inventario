<template>
    <div class="container p-2 tarjeta">
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
        <div class="row">
            <div class="col-3">
                <img :src="'../../img/test.jpg'">
            </div>
            <div class="col-8">
                <div class="row">
                    <div class="col-12">
                        <b>{{ producto.nombre }}</b>
                    </div>
                    <div class="col-12">
                        <div v-if="this.producto.categorias">
                            <div v-for="categoria in this.producto.categorias" :key="categoria.id">
                                {{ categoria.categoria.nombre }}
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-3 blue">${{ this.producto.precio }}</div>
                        <div class="col-3">{{ this.producto.calificacion }}</div>
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-3"><b>Disponible: </b></div>
                        <div class="col-3">
                            <div v-if="this.producto.estado" variant="success">Disponible</div>
                            <div v-else variant="success">No disponible</div> 
                        </div>
                    </div>
                    <div class="col-12">
                        <p>{{ this.producto.descripcion }}</p>
                    </div>
                        
                    <div class="col-12">
                        <o-button class="btn-md" variant="success" @click="showCalificar(this.producto.id)">Calificar</o-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            producto: {},
            calificarProductoId: 0,
            calificacion: 0,
            calificar: false
        };
    },
    async mounted() {
        if (this.$route.params.id) {
            await this.getProduct(this.$route.params.id);
            this.initProduct();
        }
    },
    methods: {
        showCalificar(id) {
            this.calificarProductoId = id;
            this.calificar = true;
        },
        closeCalificar() {
            this.calificarProductoId = 0;
            this.calificacion = 0;
            this.calificar = false;
        },
        saveCalificar() {
             this.$axios.patch('/api/productos/calificar/'+this.calificarProductoId, 
                {calificacion: this.calificacion}
                )
                .then(res => {
                    this.getProduct(this.calificarProductoId);
                    this.calificar = false;
                });
        },
        async getProduct(id) {
            this.producto = await this.$axios.get('/api/productos/'+id);
            this.producto = this.producto.data;
        },
        initProduct() {
                this.form = this.producto;
        },
    
    }
}
</script>