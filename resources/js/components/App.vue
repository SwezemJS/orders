<template>
        <div class="row justify-content-center h-100 m-0">
            <div class="col-2 h-100 sidebar">
                <router-link :to="{ name: 'orders'}">
                    <div class="text-center mt-2 p-2 sidebar-item">Заказы</div>
                </router-link>
                <router-link :to="{ name: 'report'}">
                    <div class="text-center my-3 p-2 sidebar-item">Отчет</div>
                </router-link>
            </div>
            <div class="col-10">
                <router-view/>
            </div>
            <notifications/>
        </div>
</template>

<script>

export default {
    name: "App",
}
</script>

<style scoped>

</style>
