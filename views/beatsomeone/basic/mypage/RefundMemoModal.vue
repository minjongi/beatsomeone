<template>
    <div class="panel active">
        <div class="popup active">
            <div class="box" style="padding-bottom:50px; width: 1000px;">
                <div class="title" style="margin-bottom:30px;">{{ $t('requestRefund') }}</div>
                <div class="row" style="margin-bottom:30px;">
                    <div class="type"></div>
                    <div class="data">
                        <div class="result">
                            <div>
                                <img src="/assets/images/icon/check-circle.png"/>
                            </div>
                            <div>
                                <div class="title">Your refund request has been completed.</div>
                                <div
                                    class="desc"
                                >Please let us know the reason for the refund and we will process it after
                                    confirmation.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="type">
                        <span>Reason *</span>
                    </div>
                    <div class="" style="display: block; width: 250px;">
                        <v-select v-model="reason" :placeholder="$t('select')" :clearable="false" :searchable="false"  :options="listReasons">
                        </v-select>
                    </div>
                </div>

                <div class="row">
                    <div class="type">
                        <span>Description *</span>
                    </div>
                    <div class="data">
                    <textarea class="firstname" type="text" v-model="description"
                              placeholder="Write your description for refund requesting..."></textarea>
                    </div>
                    <div></div>
                </div>

                <div class="btnbox" style="text-align:center;">
                    <button
                        type="submit"
                        class="btn btn--yellow"
                        style="width:208px"
                        @click="doComplete"
                    >Request Complete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "RefundMemoModal",
    props: [
        'cor_id'
    ],
    data: function () {
        return {
            reason: '',
            description: '',
            listReasons: [
                'Selecting the wrong beat',
                'No intention to purchase'
            ]
        }
    },
    methods: {
        dismissModal() {
            this.$emit('dismissModal');
        },
        doComplete() {
            let formData = new FormData()
            formData.append('cor_memo', this.reason);
            formData.append('cor_admin_memo', this.description);
            formData.append('cor_id', this.cor_id);

            axios.post('/cmall/ajax_refund_complete', formData)
                .then(res => res.data)
                .then(data => {
                    this.$emit('submitModal');
                })
                .catch(error => {
                    console.error(error);
                })
        }
    }
}
</script>

<style lang="scss">
$vs-state-active-bg: #45464c;
$vs-controls-color: white;

@import "~vue-select/src/scss/vue-select.scss";

.v-select {
    background: #303136;
    border-radius: 5px;
}

.vs__dropdown-toggle {
    height: 45px;
}

.vs--single.vs--open .vs__selected {
    height: 35px;
}

.vs__selected {
    color: white;
    padding-left: 5px;
}

.vs__dropdown-menu {
    margin-top: 3px;
    background: #303136;
}

.vs__dropdown-option {
    color: white;
    padding: 10px 20px;
}

.vs__search {
    color: white;
}

</style>