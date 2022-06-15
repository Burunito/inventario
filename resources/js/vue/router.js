import { createRouter, createWebHistory } from 'vue-router';
import List from './components/List';
import Store from './components/Store';
import Producto from './components/Producto';
import Detalle from './components/Detalle';

const routes = [
    {
        name: 'list',
        path: '/productos',
        component: List
    },
    {
        name: 'producto',
        path: '/productos/create',
        component: Producto
    },
    {
        name: 'producto',
        path: '/productos/edit/:id?',
        component: Producto
    },
    {
        name: 'store',
        path: '/productos/store',
        component: Store
    },
    {
        name: 'detalle',
        path: '/productos/detalle/:id?',
        component: Detalle
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});

export default router;