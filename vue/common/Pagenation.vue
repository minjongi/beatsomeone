<template>
    <nav id="pagenation">

        <ul class="pagination">
            <li v-if="isPrev" class="mblock">
                <a @click="doClick( start - 1)">&lt;</a>
            </li>
            <li class="mblock" v-for="i in display" :key="i" :class="{'active': current === start + i + addon }" v-if="start + i <= max">
                <a @click="doClick(start + i + addon )">{{ start + i + addon  }}</a>
            </li>
            <li class="mblock" v-if="isNext">
                <a @click="doClick(start + display)">&gt;</a>
            </li>
        </ul>
    </nav>

</template>


<script>


    export default {
        props: {
            'total': {
              type : Number,
              required: true,
            },
            'current':{
                type : Number,
                required: true,
            },
            'perPage':{
                type : Number,
                default: 10,
            },
            'display': {
                type : Number,
                default: 10,
            },
        },
        data: function() {
            return {

            };
        },
        computed: {
            start: function () {
                if(this.current <= this.display) return 1;
                return (Math.floor((this.current + (this.current % this.display != 0 ? 0 : -1 )) / this.display) * this.display) + 1;
            },
            max: function() {
                return Math.ceil(this.total / this.perPage) + 1;
            },
            isNext: function () {
                return this.start + this.display <= this.max;
            },
            isPrev: function () {
                return !(this.current <= this.display);
            },
            addon: function () {
                return (this.current <= this.display ? -1 : -1);
            }
        },
        mounted() {
            // log.debug({
            //     props: this.$props
            // });
        },
        methods: {
            doClick(i) {
                if(this.current === i) return;
                // log.debug({
                //    doClick: i,
                // });
                this.$emit('move',i);
            },

        }
    }

</script>

<style scoped="scoped" lang="scss">
    nav > ul.pagination > li.mblock {
        display: inline-block !important;
        margin-right: 5px !important;

        a {
            cursor: pointer !important;
        }
    }
</style>
