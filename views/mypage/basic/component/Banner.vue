<template>
    <section class="top-banner">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8">
                    <h3 class="font-weight-bold text-center mb-5 title" v-html="$t('togetherWithBeatsomeone')"></h3>
                    <p class="text-center sub-title" v-html="$t('makeRelationshipWithPeopleMsg')"></p>
                    <div class="text-center">
                        <button class="btn btn-yellow font-weight-bold px-5 round">{{$t('startSelling1')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "Banner",
        data: function () {
            return {
                title: '',
                subtitle: '',
            }
        }
    }
</script>

<style lang="scss" scoped>
    .top-banner {
        padding-top: 100px;
        padding-bottom: 200px;
        background: linear-gradient(rgba(0, 0, 0, 0.5) 75%, rgb(0,0,0)), url('https://images.unsplash.com/photo-1513366208864-87536b8bd7b4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2134&q=80') no-repeat;
        background-size: cover;

        .sub-title {
            opacity: 0.3;
        }
    }
</style>