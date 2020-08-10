<template>
    <li class="playList__itembox">
        <div class="playList__item">
            <label class="checkbox">
                <input type="checkbox" hidden="hidden"/>
                <span></span>
            </label>
        </div>
    </li>
</template>

<script>
    export default {
        name: "WishlistItem",
        props: [
            "item"
        ]
    }
</script>

<style scoped>
    .playList__item {
        padding: 0 20px;
    }
</style>