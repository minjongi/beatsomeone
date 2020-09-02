<template>
    <div>
        <h5>{{$t('orderDetail')}}</h5>
        {{ $route.params.cor_id }}

    </div>
</template>

<script>
    export default {
        name: "OrderView"
    }
</script>

<style scoped>

</style>