<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"
            integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>

    </style>
</head>
<body>
<div class="container-fluid h-100 mp-0" id="app">
    <div class="row justify-content-center h-100 m-0">
        <div class="col-2 h-100 sidebar">
            <div class="text-center mt-2 p-2 sidebar-item" v-on:click="route = 'orders'">Заказы</div>
            <div class="text-center my-3 p-2 sidebar-item">Логистика</div>
            <div class="text-center my-3 p-2 sidebar-item">Отчет</div>
        </div>
        <div class="col-10">
            <div class="row justify-content-center my-5" id="createOrder" v-if="route == 'createOrder'">
                <div class="col-6">
                    <div class="text-center">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-danger" v-on:click="route = 'orders'">X</button>
                        </div>
                        <h2>Создание заказа</h2>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="nameClient" class="px-2 ">Имя клиента</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="nameClient" aria-describedby="basic-addon3" v-model="createNewOrder.customer">
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="nomberClient" class="px-2">Номер клиента</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control w-10" id="nomberClient" aria-describedby="basic-addon3" v-model="createNewOrder.phone">
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="nomberClient" class="px-2">Менеджер заказа</label>
                            <div class="input-group mb-3">
                                <select class="form-control" id="typeOrder" v-model="createNewOrder.user_id">
                                    <option  v-for="user in users" v-bind:value="user.id">{( user.name )}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="typeOrder" class="px-2">Тип заказа:</label>
                            <select class="form-control" id="typeOrder" v-model="createNewOrder.type">
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="statusOrder" class="mr-1">Статус заказа:</label>
                            <select class="form-control" id="statusOrder" v-model="createNewOrder.status">
                                <option value="active">Active</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>
                        <div class="col-4 p-2">
                            <button type="button" class="btn btn-success w-100 mt-4" v-on:click="createOrder">Создать</button>
                        </div>

                        <div class="col-12 mb-2">
                            <h3 class="text-center">Продукты</h3>
                            <hr>
                            <div class="row order-item-head">
                                <div class="col-1 text-center order-item">№</div>
                                <div class="col-3 text-center order-item">Продукт</div>
                                <div class="col-2 text-center order-item">Цена</div>
                                <div class="col-2 text-center order-item">Склад</div>
                                <div class="col-2 text-center order-item">Количество</div>
                                <div class="col-2 text-center order-item">Скидка</div>
                            </div>
                            <div class="row my-1" v-for="(orderProduct,indexOrderProduct) in createNewOrder.products">
                                <div class="col-1 text-center">
                                    1
                                </div>
                                <div class="col-3 text-center">
                                    <select class="form-control" v-model="orderProduct.product_id">
                                        <option v-for="(product,index) in products" v-bind:value="product.id" >{( product.name )}</option>
                                    </select>
                                </div>
                                <div class="col-2 text-center">

                                </div>
                                <div class="col-2 text-center">4</div>
                                <div class="col-2 text-center">5</div>
                                <div class="col-2 text-center">6</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="route == 'orders'">
                <div class="row">
                    <div class="d-flex justify-content-start m-3">
                        <button type="button" class="btn btn-dark" v-on:click="route = 'createOrder'">Создать заказ</button>
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
                        {( order.customer )}
                    </div>
                    <div class="col-2 text-center">
                        {( order.phone )}
                    </div>
                    <div class="col-2 text-center">
                        {( order.user.name)}
                    </div>
                    <div class="col-2 text-center">
                        {( order.type )}
                    </div>
                    <div class="col-2 text-center">
                        {( order.status )}
                    </div>
                    <div class="col-2 text-center">
                        <button type="button" class="btn btn-primary">Редактировать</button>
                        <button type="button" class="btn btn-danger" v-on:click="deleteOrder(index)">Удалить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let vue = new Vue({
        el: '#app',
        delimiters: ['{(', ')}'],
        data: {
            route: 'createOrder',
            createNewOrder:{
                products: [
                    {},
                ]
            },
            orders: [],
            users:[],
            products:[]
        },
        methods: {
            getOrders: function () {
                axios
                    .get('http://127.0.0.1:8000/api/orders/list')
                    .then(response => {
                        this.orders = response.data
                    });
            },
            getUsers: function () {
                axios
                    .get('http://127.0.0.1:8000/api/users/list')
                    .then(response => {
                        this.users = response.data
                    });
            },
            getProducts: function () {
                axios
                    .get('http://127.0.0.1:8000/api/products/list')
                    .then(response => {
                        this.products = response.data
                    });
            },
            createOrder: function () {
                if(Object.keys(this.createNewOrder).length < 5) {
                    alert('Пожалуйста, заполните все поля');
                } else {
                    axios.post('http://127.0.0.1:8000/api/orders/create',this.createNewOrder);
                    this.route = 'orders';
                    this.getOrders();
                }
            },
            deleteOrder: function (index) {
                axios.get('http://127.0.0.1:8000/api/orders/delete/'+ this.orders[index].id);
                this.orders.splice(index,1);
            }
        },
        beforeMount() {
            this.getOrders();
            this.getUsers();
            this.getProducts();
        }
    });
</script>
</body>
</html>
