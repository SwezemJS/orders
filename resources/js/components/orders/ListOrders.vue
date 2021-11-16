<template>
    <div>
        <div class="row">
            <div class="d-flex justify-content-start m-3">
                <router-link :to="{name: 'createOrders'}">
                    <button type="button" class="btn btn-dark">Создать заказ</button>
                </router-link>
            </div>
        </div>
        <div class="row order-item-head">
            <div class="col-2 text-center order-item">
                Имя клиента
            </div>
            <div class="col-2 text-center order-item">
                Мобильный телефон клиента
            </div>
            <div class="col-2 text-center order-item">
                Менеджер
            </div>
            <div class="col-2 text-center order-item">
                Тип заказа
            </div>
            <div class="col-2 text-center order-item">
                Статус заказа
            </div>
            <div class="col-2 text-center">
                Действия
            </div>
        </div>
        <div class="row" v-for="(order,index) in orders" id="order-item-list" :key="order.id">
            <div class="col-2 text-center">
                {{ order.customer }}
            </div>
            <div class="col-2 text-center">
                {{ order.phone }}
            </div>
            <div class="col-2 text-center">
                {{ order.user.name }}
            </div>
            <div class="col-2 text-center">
                {{ order.type }}
            </div>
            <div class="col-2 text-center">
                {{ order.status }}
            </div>
            <div class="col-2 text-center">
                <button type="button" class="btn btn-primary" v-on:click="$router.push({name: 'editOrders',params:{id:order.id}, })">
                    <i class="fa fa-pencil"></i>
                </button>
                <button type="button" class="btn btn-danger" v-on:click="deleteOrder(index)">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ListOrders",
    data() {
        return {
            orders: [],

        }
    },
    methods: {
        getOrders: function () {
            axios
                .get(this.$hostname + '/api/orders/list')
                .then(response => {
                    this.orders = response.data
                });
        },
        deleteOrder: function (index) {
            axios.get(this.$hostname + '/api/orders/delete/' + this.orders[index].id);
            this.orders.splice(index, 1);
        },
    },
    beforeMount() {
        this.getOrders();
    }
}
</script>

<style scoped>

</style>
