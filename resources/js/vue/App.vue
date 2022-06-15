<template>
    <div class="container">
        <h1>Listado de productos</h1>
        
        <router-link :to="{ name:'list' }">
            <o-button class="btn-md m-2" variant="success">
                <o-icon pack="fas" icon="fa-solid fa-cart-shopping"></o-icon>
                <font-awesome-icon icon="fa-solid fa-cart-shopping" />
                &nbsp;
                <span>Inventario</span>
            </o-button>
        </router-link>
        <router-link :to="{ name:'store' }">
            <o-button class="btn-md m-2" variant="success">
                <o-icon pack="fas" icon="fa-solid fa-store"></o-icon>
                <font-awesome-icon icon="fa-solid fa-store" />
                &nbsp;
                <span>Tienda</span>
            </o-button>
        </router-link>
        <router-view></router-view>
    </div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faCartShopping } from '@fortawesome/free-solid-svg-icons'
import { faStore} from '@fortawesome/free-solid-svg-icons'
library.add(faCartShopping)
library.add(faStore)
export default {}
</script>