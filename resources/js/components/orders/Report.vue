<template>
    <div class="row">
        <div class="col-6">
            <label for="dateReport" class="px-2 ">Дата</label>
            <br>
            <input type="date" id="dateReport" v-model="date" v-on:change="getReport">
            <br>
            <br>
            <h3>Количество заявок: {{ this.report.count }}</h3>
            <br>
            <h3>Сумма заявок: {{ this.report.sum }} руб</h3>
        </div>
    </div>
</template>

<script>
export default {
    name: "Report",
    data () {
        return {
            date:'',
            report:{}
        }
    },
    methods: {
        getReport: function () {
            axios.post('http://127.0.0.1:8000/api/orders/report',{'date': this.date }).then(responce => {
                this.report = responce.data; // получаем отчет
            });
        }
    }
}
</script>

<style scoped>

</style>
