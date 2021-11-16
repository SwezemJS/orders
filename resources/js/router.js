import ListOrders from "./components/orders/ListOrders";
import CreateOrEditOrder from "./components/orders/CreateOrEditOrder";
import VueRouter from "vue-router";
import Vue from "vue";
import Report from "./components/orders/Report";
Vue.use(VueRouter);
// роуты
const routes = [
    {
      path: '/',
      redirect: { name:'orders'}
    },
    {
        path:'/orders',
        component: ListOrders,
        name: 'orders'
    },
    {
        path:'/orders/create',
        component: CreateOrEditOrder,
        name: 'createOrders'
    },
    {
        path:'/orders/edit/:id',
        component: CreateOrEditOrder,
        name: 'editOrders'
    },
    {
        path: '/report',
        component: Report,
        name: 'report'
    }
];

export default new VueRouter({
    mode:"history",
    routes
});
