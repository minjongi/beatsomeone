<template>
    <div class="playList">
        <ul id="playList__list" class="playList__list">
            <li class="playList__itembox">
                <div class="playList__item playList__item--title">
                    match와 location을 알아보도록 하겠습니다.
                    BrowserRouter와 우리의 App을 연결하면 어떻게 된다고 했었나요? 라우터가 history api에 접근할 수 있고, Route에 연결된 컴포넌트에 match와 location, history props를 전달합니다. 이번 포스팅에서는 match와 location에 대해서 알아보고 path와 querystring을 받아오도록 하겠습니다.

                    import React from "react";
                    import { Route } from "react-router-dom";

                    const App = () => {
                    return (
                    <div>
                        <Route path="/" component={Home} />
                    </div>
                    );
                    };

                    const Home = ({ match, location }) => {
                    console.log("Match");
                    console.dir(match);
                    console.log("Location");
                    console.dir(location);
                    return <h1>Home</h1>;
                    };

                    export default App;
                    view rawApp.js hosted with ❤ by GitHub

                    이전 예시에 위의 코드를 복사해서 붙여넣어주세요. 라우트가 하나이고, "/"에 연결되어 있기 때문에 앱을 실행하면 크게 Home이라는 글자가 적힌 것을 볼 수 있습니다. 페이지가 에러없이 작동되면 F12를 눌러 구글 개발자 모드를 실행하고 콘솔 창을 확인해주세요.
                </div>
            </li>
        </ul>
    </div>
</template>


<script>

    export default {
        data: function () {
            return {

            }
        },
        mounted() {

        },
        methods: {},

    }

</script>

<style scoped="scoped">

</style>
