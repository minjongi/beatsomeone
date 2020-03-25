<template>
    <div>
        <app :cit_id="cit_id" @update="doUpdate"></app>
    </div>

</template>


<script>

    import app from './Regist_item_addRelation';

    export default {
        data: function() {
          return {
              cit_id: null,
          };
        },
        components: {
            app
        },
        methods: {
            doUpdate() {
              log.debug({
                  update: '!!!',
              });
              window.location.reload();


            },
        }

    }

</script>

<style scoped="scoped">

</style>
