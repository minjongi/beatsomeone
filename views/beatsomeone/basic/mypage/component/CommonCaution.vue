<template>
    <div class="caution" :class="css">
        <div>
            <img class="caution" src="/assets/images/icon/caution.png">
            <img class="warning" src="/assets/images/icon/warning.png">
        </div>
        <span>
            <slot></slot>
        </span>
    </div>
</template>


<script>

    export default {

        props: ['css'],

        data: function () {
            return {

            }
        },

        created() {

        },
        mounted() {

        },
        methods: {

        },

    }

</script>

<style scoped="scoped" lang="scss">
    div.red {
        span {
            color: red !important;
        }
    }
</style>
