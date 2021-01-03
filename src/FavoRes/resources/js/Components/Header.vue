<template>
<header>
    <h1 class="header-title"><a href="/">FavoRes</a></h1>
    <ul class="nav-list"  v-if="user==null">
        <li class="nav-list-item"><a href="login" class="nav-list-item-login">sign in</a></li>
        <li class="nav-list-item"><a href="register" class="nav-list-item-register">sign up</a></li>
    </ul>
    <ul class="nav-list" v-else>
        <li class="nav-list-item"><a href="/articles/create" class="nav-list-item-login">新規投稿</a></li>
        <li class="nav-list-item">{{user.name}}</li>
    </ul>
</header>
</template>

<script>
import Button from "@/Jetstream/Button"

export default{
    components : {
        Button,
    },
    props : {
        "user" : Object,
    },
    mounted() {

    },

}
</script>

<style lang="scss" scoped>

header{
    height: 5rem;
    background: #3AB7FF;

    .header-title{
        font-size: 3rem;
        float: left;
        margin: 0 0 0 3rem;
        color: white;
        a {
            display: block;
            height: 5rem;
            line-height: 5rem;
            &:hover{
                opacity: 0.6;
            }
        }
    }

    .nav-list{
        float: right;

        .nav-list-item{
            display: inline-block;
            font-size: 1.5rem;

            .nav-list-item-login{
                display: block;
                background: #F2E7CA;
                height: 3rem;
                width: 10rem;
                border-radius: 3rem;
                text-align: center;
                line-height: 3rem;
                margin: 1rem 1rem 1rem 0rem;

                &:hover{
                    opacity: 0.6;
                }
            }

    

            .nav-list-item-register{
                display: block;
                background: #F2E7CA;
                height: 3rem;
                width: 10rem;
                border-radius: 3rem;
                text-align: center;
                line-height: 3rem;
                margin: 1rem 2rem 1rem 1rem;

                &:hover{
                    opacity: 0.6;
                }
            }
        }
    }

}

</style>