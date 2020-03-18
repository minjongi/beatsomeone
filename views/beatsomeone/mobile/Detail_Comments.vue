<template>
    <div class="playList">
        <ul id="playList__list" class="playList__list">
            <li class="playList__itembox" v-for="(c,index) in listComments" :key="index">
                <div class="playList__item playList__item--title">
                    <div class="col name">
                        <figure>
              <span class="playList__cover">
                <img
                        :src="c.userImg"
                        alt=""
                />
              </span>
                            <figcaption>
                                <h3 class="playList__title">
                                    {{ c.userId }}
                                </h3>
                                <span class="playList__by">{{ c.comment }}</span>
                            </figcaption>
                        </figure>

                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>


<script>

    export default {
        data: function () {
            return {
                listComments: [
                    {userId: 'User1',userImg: 'https://via.placeholder.com/190x190', comment: '테스트1'},
                    {userId: 'User2',userImg: 'https://via.placeholder.com/190x190', comment: '테스트2'},
                    {userId: 'User3',userImg: 'https://via.placeholder.com/190x190', comment: '테스트3'},
                    {userId: 'User4',userImg: 'https://via.placeholder.com/190x190', comment: '테스트4'},
                    {userId: 'User5',userImg: 'https://via.placeholder.com/190x190', comment: '테스트5'},
                    {userId: 'User6',userImg: 'https://via.placeholder.com/190x190', comment: '테스트6'},

                ],
            }
        },
        mounted() {

        },
        methods: {},

    }

</script>

<style scoped="scoped">

</style>
