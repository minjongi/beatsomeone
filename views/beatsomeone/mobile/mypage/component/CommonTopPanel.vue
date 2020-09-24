<template>
    <div>
        <CommonProfile />
        <CommonMenu />
    </div>
</template>


<script>

    import { EventBus } from '*/src/eventbus';
    import CommonProfile from "./CommonProfile";
    import CommonMenu from "./CommonMenu";

    export default {
        components: {
          CommonMenu,
          CommonProfile
        },
    }

</script>

<style scoped="scoped" lang="sass">

</style>
