<template>
    <input :disabled="disabled" type="text" v-model="displayValue">
</template>

<script>
export default {
    name: "NumberInput",
    props: ["value", "disabled"],
    data: function () {
        return {
            isInputActive: false
        }
    },
    computed: {
        displayValue: {
            get: function () {
                // if (this.isInputActive) {
                //     return this.value.toString();
                // } else {
                return this.value.toString().replace(/\B(?=(?!\d))/g, "");
                // }
            },
            set: function(modifiedValue) {
                let newValue = parseFloat(modifiedValue.replace(/[^\d.]/g, ""));
                if (isNaN(newValue)) {
                    newValue = 0;
                }
                this.$emit('input', newValue);
            }
        }
    }
}
</script>