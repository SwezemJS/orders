<template>
    <div class="row justify-content-center my-5" id="createOrder">
        <div class="col-6">
            <div class="text-center">
                    <div class="d-flex justify-content-end">
                        <router-link :to="{name:'orders'}">
                            <button type="button" class="btn btn-danger">X</button>
                        </router-link>
                    </div>
                <h2>{{ ($route.params.id) ? 'Редактирование' : 'Создание' }} заказа</h2>
            </div>
            <hr>
            <div class="row">
                <div class="col-4">
                    <label for="nameClient" class="px-2 ">Имя клиента</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="nameClient" aria-describedby="basic-addon3"
                               v-model="newOrder.customer">
                    </div>
                </div>
                <div class="col-4">
                    <label for="nomberClient" class="px-2">Номер клиента</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control w-10" id="nomberClient" aria-describedby="basic-addon3"
                               v-model.number="newOrder.phone">
                    </div>
                </div>
                <div class="col-4">
                    <label for="nomberClient" class="px-2">Менеджер заказа</label>
                    <div class="input-group mb-3">
                        <select class="form-control" id="typeOrder" v-model="newOrder.user_id">
                            <option v-for="user in users" v-bind:value="user.id">{{ user.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <label for="typeOrder" class="px-2">Тип заказа:</label>
                    <select class="form-control" id="typeOrder" v-model="newOrder.type">
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>
                <div class="col-4">
                    <label for="statusOrder" class="mr-1">Статус заказа:</label>
                    <select class="form-control" id="statusOrder" v-model="newOrder.status">
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>
                <div class="col-4 p-2">
                    <button type="button" class="btn btn-success w-100 mt-4" v-on:click="createOrder">
                        {{ ($route.params.id) ? 'Обновить' : 'Создать' }}
                    </button>
                </div>

                <div class="col-12 mb-2">
                    <h3 class="text-center">Продукты</h3>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <label for="typeProduct" class="px-2">Название</label>
                            <select class="form-control" id="typeProduct" v-model="indexProduct" @change="cloneProduct">
                                <option v-for="(product,index) in products" v-bind:value="index">
                                    {{ product.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="countProduct" class="px-2">Количество</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control w-10" id="countProduct"
                                       aria-describedby="basic-addon3" v-model.number="newProduct.count"
                                       :placeholder="newProduct.stock" :max="newProduct.stock" min="0"
                                       @change="changeCountProduct($event)" :disabled="!newProduct.id"
                                >
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="discountProduct" class="px-2">Скидка (%)</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control w-10" id="discountProduct"
                                       aria-describedby="basic-addon3" v-model.number="newProduct.discount"
                                       @input="changeDiscountProduct($event)" :disabled="!newProduct.id"
                                       placeholder="0%"
                                >
                            </div>
                        </div>
                        <div class="col-4" v-if="newProduct.id">
                            Остаток на складе: {{ surplusCostProduct }}
                        </div>
                        <div class="col-4" v-if="newProduct.count !== undefined">
                            Цена: {{ newProduct.price }} руб
                            <br>
                            Стоймость без скидки: {{ newProduct.price * newProduct.count }} руб
                        </div>
                        <div class="col-4">
                            <div v-if="newProduct.discount !== undefined">
                                Цена со скидкой: <b class="text-success"> {{ discountPriceProduct }} </b> руб
                            </div>

                            <div v-if="newProduct.discount !== undefined">
                                Стоймость со скидкой: <b class="text-success">{{
                                    discountPriceProduct * newProduct.count
                                }}</b> руб
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="button" class="btn btn-info w-100 mt-4" v-on:click="addProduct"
                            :disabled="(newProduct.count == undefined && newProduct.count == undefined)">Добавить
                        продукт
                    </button>
                    <hr>
                    <div class="row order-item-head">
                        <div class="col-1 text-center order-item">№</div>
                        <div class="col-3 text-center order-item">Название</div>
                        <div class="col-2 text-center order-item">Количество</div>
                        <div class="col-2 text-center order-item">Стоймость</div>
                        <div class="col-2 text-center order-item">Скидка</div>
                        <div class="col-2 text-center order-item"></div>
                    </div>
                    <div class="row my-1" v-for="(orderProduct,indexOrderProduct) in newOrder.products">
                        <div class="col-1 text-center">
                            {{ indexOrderProduct + 1 }}
                        </div>
                        <div class="col-3 text-center">
                            {{ orderProduct.name }}
                        </div>
                        <div class="col-2 text-center">
                            {{ orderProduct.count }}
                        </div>
                        <div class="col-2 text-center">
                            {{ orderProduct.cost }} руб
                        </div>
                        <div class="col-2 text-center">
                            {{ orderProduct.discount }} %
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-primary" v-on:click="editProduct(indexOrderProduct)">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-danger" v-on:click="deleteProduct(indexOrderProduct)">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "createOrEditOrder",
    data() {
        return {
            indexProduct: '',
            newOrder: {
                products: []
            },
            users: [],
            products: [],
            newProduct: {
                stock: 0,
            }
        }
    },
    methods: {
        getUsers: function () { // получаем пользователя
            axios
                .get('http://127.0.0.1:8000/api/users/list')
                .then(response => {
                    this.users = response.data
                });
        },
        getProducts: function () {  // получаем список продуктов
            axios
                .get('http://127.0.0.1:8000/api/products/list')
                .then(response => {
                    this.products = response.data
                });
        },
        createOrder: function () { // создание заказа
            if (this.newOrder.products.length > 0 && Object.keys(this.newOrder).length >= 6) {
                let type = 'create';
                if (this.$route.params.id) type = 'update'
                axios.post('http://127.0.0.1:8000/api/orders/'+type, this.newOrder)
                    .then(response => {
                        if (response.data.type == 'error') {
                            this.$notify({
                                type: 'error',
                                title: 'Ошибка',
                                text: response.data.message,
                                speed: 3000,
                            })
                        } else {
                            this.$notify({
                                type: 'success',
                                title: 'Успешно',
                                text: response.data.message,
                                speed: 3000,
                            })
                            this.$router.push({name: 'orders'});
                        }
                    }).catch(function (error) {
                    this.$notify({
                        type: 'error',
                        title: 'Ошибка',
                        text: 'Произошла ошибка, попробуйте повторить действие позже',
                        speed: 3000,
                    })
                });
            } else {
                this.$notify({
                    type: 'warn',
                    title: 'Предупреждение',
                    text: 'Пожалуйста, заполните все поля и добавьте хотя бы 1 товар',
                    speed: 3000,
                })
            }
        },
        addProduct: function () { // добавляем продукт
            if (this.newProduct.discount == 0 || this.newProduct.discount == undefined) {
                this.newProduct.cost = this.newProduct.count * this.newProduct.price;
                this.newProduct.discount = 0;
            } else {
                this.newProduct.cost = this.newProduct.count * this.discountPriceProduct;
            }
            this.newOrder.products.push(this.newProduct);
            this.products[this.indexProduct].stock -= this.newProduct.count;
            this.indexProduct = '';
            this.newProduct = { // обновляем объект
                stock: 0,
            };
        },
        editProduct : function (index) { // редактирование продукта
            this.newProduct = {} // обновляем объект
            for (let i = 0; i< this.products.length; i++) {
                if (this.newOrder.products[index].id == this.products[i].id) {
                    this.indexProduct = i; // находим нужный продукт из списка продуктов
                }
            }
            this.newProduct = this.newOrder.products[index]; // заполняем данными взятого продукта
            this.deleteProduct(index); //  удаляем
        },
        deleteProduct: function (index) { // удаляем продукт из спи
            this.newOrder.products.splice(index, 1);
        },
        cloneProduct: function () {
            Object.assign(this.newProduct, this.products[this.indexProduct]); // клонируем, что бы не было привязки по ссылке
        },
        changeCountProduct: function (event) { // не даем установить значение больше чем на складе
            if (event.target.value > this.newProduct.stock) this.newProduct.count = this.newProduct.stock;
            if (event.target.value < 1) this.newProduct.count = 1;
        },
        changeDiscountProduct: function (event) { // не даем установить значение больше 100 (скидка)
            if (event.target.value > 100) this.newProduct.discount = 100;
            if (event.target.value < 0) this.newProduct.discount = 0;
        },
        // edit
        getOrder: function (id) { // получаем заказ для редактирования
            axios
                .get('http://127.0.0.1:8000/api/orders/get/' + id)
                .then(response => {

                    if (response.data.type !== 'error') {
                        this.newOrder = response.data;

                        for (let i = 0; i < this.newOrder.products.length; i++) {
                            let product = this.newOrder.products[i];
                            // меняем свойства на нужные нам в обьекте продукт
                            product.count = product.pivot.count;
                            product.discount = product.pivot.discount;
                            product.cost = product.pivot.cost;

                            delete product.pivot;
                        }
                    } else {
                        this.$notify({
                            type: 'error',
                            title: 'Ошибка',
                            text: response.data.message,
                            speed: 3000,
                        })
                        this.$router.push({name:'orders'})
                    }
                });
        }
    },
    computed: {
        surplusCostProduct: { // высчитываем остаток на складе
            cache: false,
            get() {
                if (this.newProduct.count == undefined) return this.newProduct.stock;
                return this.newProduct.stock - this.newProduct.count;
            }
        },
        discountPriceProduct: { // высчитываем цену со скидкой
            cache: false,
            get() {
                if (this.newProduct.discount == 0 || this.newProduct.discount == undefined) return this.newProduct.price;
                return parseFloat(this.newProduct.price - (this.newProduct.price * this.newProduct.discount / 100)).toFixed(2);
            }
        }
    },
    beforeMount() {
        this.getUsers();
        this.getProducts();
        if (this.$route.params.id) this.getOrder(this.$route.params.id); // в случае если есть id
    }
}
</script>

<style scoped>

</style>
