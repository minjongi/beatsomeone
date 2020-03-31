<template>
    <div class="container accounts accounts--start">
        <div class="accounts__title">
            <h1>Do you create beats?<br />Then join us!</h1>
        </div>

        <div class="login accounts__defaultLayout">
            <form action="">
                <div class="accounts__case">
                    <label for="listen " class="case case--listen">
                        <input type="radio" name="case" id="listen " hidden checked @click="currentUserType = 'user'"/>
                        <div>
                            <span class="icon"></span>
                            <p>I want to listen<br />& buy music</p>
                        </div>
                    </label>

                    <label for="monetize" class="case case--monetize">
                        <input type="radio" name="case" id="monetize" hidden @click="currentUserType = 'musician'"/>
                        <div>
                            <span class="icon"></span>
                            <p>I want to monetize<br />my music</p>
                        </div>
                    </label>
                </div>

                <div class="accounts__switch">
                    <span class="accounts__switch-bg"></span>
                    <label for="monthly">
                        <input type="radio" id="monthly" hidden name="bill" checked />
                        <span>Bill monthly</span>
                    </label>
                    <label for="yearly">
                        <input type="radio" id="yearly" hidden name="bill" />
                        <span>
                  Bill yearly
                  <em>Save 20% or more</em>
                </span>
                    </label>
                </div>
            </form>
        </div>

        <div class="tab accounts__tab">
            <button class="active" data-target="plan-free">
                FREE
            </button>
            <button data-target="plan-marketplace">
                MARKETPLACE
            </button>
            <button data-target="plan-pro">
                PRO PAGE
            </button>
        </div>

        <div class="accounts__plan-case" id="plan-free" style="display: ;">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        FREE
                    </p>
                    <h2><span>$</span> 0.00<em>/mo</em></h2>
                </div>
                <div class="right">
                    <a href="#" class="btn btn--start" @click="doNext(1)">Get Started</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>
                <tr>
                    <td>Upload Tracks Limit</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Upload Track Stems</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell Sound Kits</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>

                </tr>
                <tr>
                    <td>Sell Custom Services</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Pro Page Sales Revenue</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Instant Payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept PayPal payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept Stripe payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell On BeatStars Marketplace</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>BeatStars Marketplace Commission</td>
                    <td>
                        30%
                    </td>
                </tr>
                <tr>
                    <td>Embeddable Blaze Player</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Monthly Private Messages</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Number of License Agreements for Sale</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>Premium Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Sales Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Submissions per Opportunity</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Widgets</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>SoundCloud Monetization</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Audiomack Monetization</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
<!--                <tfoot>-->
                <tr>
                    <td colspan="2">
                        <a href="#" class="btn btn--start" @click="doNext(1)">Get Started</a>
                    </td>
                </tr>
<!--                </tfoot>-->
                </tbody>
            </table>
        </div>

        <div class="accounts__plan-case" id="plan-marketplace" style="display: none;">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        MARKETPLACE
                    </p>
                    <h2><span>$</span> 0.00<em>/mo</em></h2>
                </div>
                <div class="right">
                    <a href="#" class="btn btn--start" @click="doNext(2)">Get Started</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>
                <tr>
                    <td>Upload Tracks Limit</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Upload Track Stems</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell Sound Kits</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>

                </tr>
                <tr>
                    <td>Sell Custom Services</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Pro Page Sales Revenue</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Instant Payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept PayPal payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept Stripe payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell On BeatStars Marketplace</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>BeatStars Marketplace Commission</td>
                    <td>
                        30%
                    </td>
                </tr>
                <tr>
                    <td>Embeddable Blaze Player</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Monthly Private Messages</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Number of License Agreements for Sale</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>Premium Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Sales Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Submissions per Opportunity</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Widgets</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>SoundCloud Monetization</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Audiomack Monetization</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
<!--                <tfoot>-->
                <tr>
                    <td colspan="2">
                        <a href="#" class="btn btn--start" @click="doNext(2)">Get Started</a>
                    </td>
                </tr>
<!--                </tfoot>-->
                </tbody>
            </table>
        </div>

        <div class="accounts__plan-case" id="plan-pro" style="display: none;">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        PRO PAGE
                    </p>
                    <h2><span>$</span> 0.00<em>/mo</em></h2>
                </div>
                <div class="right">
                    <a href="#" class="btn btn--start" @click="doNext(3)">Get Started</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>
                <tr>
                    <td>Upload Tracks Limit</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Upload Track Stems</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell Sound Kits</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>

                </tr>
                <tr>
                    <td>Sell Custom Services</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Pro Page Sales Revenue</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Instant Payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept PayPal payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept Stripe payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell On BeatStars Marketplace</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>BeatStars Marketplace Commission</td>
                    <td>
                        30%
                    </td>
                </tr>
                <tr>
                    <td>Embeddable Blaze Player</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Monthly Private Messages</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Number of License Agreements for Sale</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>Premium Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Sales Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Submissions per Opportunity</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Widgets</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>SoundCloud Monetization</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Audiomack Monetization</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
<!--                <tfoot>-->
                <tr>
                    <td colspan="2">
                        <a href="#" class="btn btn--start" @click="doNext(3)">Get Started</a>
                    </td>
                </tr>
<!--                </tfoot>-->
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>

    import { EventBus } from '*/src/eventbus';
    import $ from 'jquery'

    export default {
        data: function() {
            return {
                userType : ['user','musician'],
                currentUserType: null,
            }
        },
        created() {
            this.currentUserType = this.userType[0];
        },
        mounted() {
            var bg = document.querySelector(".accounts__switch-bg");
            // 월간
            document.getElementById("monthly").addEventListener("change", function() {
                if (this.checked === true) {
                    bg.classList.remove("right");
                }
            });
            // 연간
            document.getElementById("yearly").addEventListener("change", function() {
                if (this.checked === true) {
                    bg.classList.add("right");
                }
            });

            $('.accounts__tab button').on('click', function(){
                $('.accounts__tab button').removeClass('active');
                $(this).addClass('active')
                $('.accounts__plan-case').hide();
                var target = $(this).data('target');
                $('#'+target).show();
            })

        },
        watch: {

        },
        methods: {
            doNext(type) {
                EventBus.$emit('submit_join_form',{ userType: this.currentUserType });
                this.$router.push({path: '/2'});
            },
        },

    }




</script>

<style lang="scss">

    .btn--start {
        margin-top: 10px;
        width: 100% !important;
    }

    div.right {
        width: 100px !important;
    }


</style>

<style lang="css">

</style>
