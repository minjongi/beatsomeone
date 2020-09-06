<template>
    <div class="row">
        <div class="col-4 type"><span>{{$t('password')}}</span></div>
        <div class="col-6 data">
            <button class="btn btn--blue" @click="toggleModalOpen">
                {{$t('changePassword')}}
            </button>
        </div>
        <div class="col-2"></div>
        <Profilemod_modal_password v-if="isModalOpen" @dismissModal="doDismissModal" @submitModal="doSubmitModal"></Profilemod_modal_password>
    </div>
</template>


<script>


    import Profilemod_modal_password from "./Profilemod_modal_password";

    export default {
        components: {Profilemod_modal_password},
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
