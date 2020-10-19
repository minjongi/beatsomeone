<template>
    <div></div>
</template>

<script>
    import WaveSurfer from "wavesurfer.js";
    export default {
        props: ['detail', 'options'],
        data() {
            return {
                waveSurfer: {},
                src: '',
                isPlaying: false,
            };
        },
        mounted() {
            let options = this.options;
            let wsOptions = Object.assign({ container: this.$el }, options);
            this.waveSurfer = new WaveSurfer.create(wsOptions);
            this.src=`/uploads/cmallitemdetail/${this.detail.cde_filename}`;
            this.waveSurfer.load(this.src);
        },
        methods: {
            playPause: function () {
                this.waveSurfer.playPause();
            }
        },
        beforeDestroy() {
            this.waveSurfer.destroy();
        }
    };
</script>

<style lang="css" scoped>
    div {
        position: relative;
    }
</style>