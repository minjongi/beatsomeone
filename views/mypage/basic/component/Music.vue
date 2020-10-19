<template>
    <div>
        <span>
            <i class="fas fa-2x fa-music"></i>
        </span>
    </div>
</template>

<script>
    export default {
        name: "Music"
    }
</script>

<style lang="scss" scoped>
    div {
        position: fixed;
        background-color: rgba(255, 255, 255, 0.1);
        width: 75px;
        height: 75px;
        bottom: 50px;
        right: 75px;
        text-align: center;

        span {
            color: white;
            opacity: 0.3;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    }
</style>