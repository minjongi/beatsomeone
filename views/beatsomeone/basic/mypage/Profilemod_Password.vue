<template>
    <div class="row">
        <div class="type"><span>Password</span></div>
        <div class="data">
            <button class="btn btn--blue" @click="toggleModalOpen">
                Change Password
            </button>
        </div>
        <div></div>

    </div>
</template>


<script>




    export default {

        data: function () {
            return {
                isModalOpen: false,
            }
        },

        created() {

        },
        mounted() {

        },
        methods: {
            toggleModalOpen() {
                this.isModalOpen = !this.isModalOpen;
            },
            doDismissModal() {
                this.isModalOpen = false;
            },
            doSubmitModal() {
                this.isModalOpen = false;
            },
        },

    }

</script>

<style scoped="scoped" lang="scss">

</style>
