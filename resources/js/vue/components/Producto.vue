<template>
    <div>
        <o-modal v-model:active="confirmUpdate">
            <p>Guardado con éxito.</p>
            <div>
                <o-button variant="primary" @click="closeModal()">Continuar</o-button>
                <o-button variant="danger" @click="closeModal()">Cancelar</o-button>
            </div>
        </o-modal>
        <router-link :to="{ name:'list' }"><div><o-button>Volver</o-button></div></router-link>
        <form @submit.prevent="submit">
            <o-field label="SKU" :variant="errores.sku ? 'danger' : 'primary'" :message="errores.sku">
                <o-input v-model="form.sku" value="" maxlength="20"> </o-input>
            </o-field>

            <o-field label="Nombre" :variant="errores.nombre ? 'danger' : 'primary'" :message="errores.nombre">
                <o-input v-model="form.nombre" value="" maxlength="20"> </o-input>
            </o-field>

            <o-field label="Descripción" :variant="errores.descripcion ? 'danger' : 'primary'" :message="errores.descripcion">
                <o-input v-model="form.descripcion" type="textarea" value="" > </o-input>
            </o-field>

            <o-field label="Precio" :variant="errores.precio ? 'danger' : 'primary'" :message="errores.precio">
                <o-input v-model="form.precio" value=""> </o-input>
            </o-field>

            <o-field label="Cantidad" :variant="errores.cantidad ? 'danger' : 'primary'" :message="errores.cantidad">
                <o-input v-model="form.cantidad" type="number" value=""> </o-input>
            </o-field>

            <o-button variant="primary" native-type="submit">Enviar</o-button>
        </form>
    </div>
</template>

<script>
export default {
    data(){
        return {
            producto: {},
            form: {
                sku: '',
                nombre: '',
                descripcion: '',
                precio: '',
                cantidad: '',
            },
            errores: {
                sku: '',
                nombre: '',
                descripcion: '',
                precio: '',
                cantidad: '',
            },
            confirmUpdate: false
        };
    },
    async mounted() {
        if (this.$route.params.id) {
            await this.getProduct(this.$route.params.id);
            this.initProduct();
        }
    },
    methods: {
        closeModal() {
            this.confirmUpdate = false;
        },
        async getProduct(id) {
            this.producto = await this.$axios.get('/api/productos/'+id);
            this.producto = this.producto.data;
        },
        initProduct() {
                this.form = this.producto;
        },
        cleanErrors(){
            for (const field in this.errores) {
                this.errores[field] = '';
            }
        },
        submit(){
            this.cleanErrors();
            
            if (this.$route.params.id) {
                this.$axios.put('/api/productos/'+this.producto.id, 
                this.form
                )
                .then(res => {
                    this.confirmUpdate = true;
                })
                .catch(error => {
                    if( Object.keys(error.response.data.errors)){
                        for (const field in error.response.data.errors) {
                            this.errores[field] = error.response.data.errors[field];
                        }
                    }
                });
            } else {
                this.$axios.post('/api/productos', 
                this.form
                )
                .then(res => {
                    this.confirmUpdate = true;
                })
                .catch(error => {
                    if( Object.keys(error.response.data.errors)){
                        for (const field in error.response.data.errors) {
                            this.errores[field] = error.response.data.errors[field];
                        }
                    }
                });
            }
        }
    }
}
</script>