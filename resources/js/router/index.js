import { createRouter, createWebHistory } from "vue-router";

import invoiceIndex from "../components/invoice/index.vue";
import invoiceNew from "../components/invoice/new.vue";
import invoiceShow from "../components/invoice/show.vue";
import notFound from "../components/NotFound.vue";

const routes = [
    {
        path: "/",
        component: invoiceIndex,
    },
    {
        path: "/invoice/new",
        component: invoiceNew,
    },
    {
        path: "/invoice/show/:id",
        component: invoiceShow,
        props:true
    },
    {
        path: "/:pathMatch(.*)*",
        component: notFound,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
