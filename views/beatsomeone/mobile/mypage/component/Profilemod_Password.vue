<template>
    <div class="row">
        <div class="type"><span>{{$t('password')}}</span></div>
        <div class="data">
            <button class="btn btn--blue" @click="toggleModalOpen">
                {{$t('changePassword')}}
            </button>
        </div>
        <div></div>
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
        watch: {
            isModalOpen(val) {
                let el = document.body;
                if (val === false) {
                    el.style.overflow = 'auto'
                } else {
                    el.style.overflow = 'hidden'
                }
            }
        }

    }

</script>

<style scoped="scoped" lang="scss">

</style>
