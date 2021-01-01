<template>
<header>
    <h1>FavoRes</h1>
    <div v-if="user==null">
        <a href="login">sign in</a>
        <a href="register">sign up</a>
    </div>
    <div v-else>
        <p>ログインユーザー情報</p>
        <p>{{user}}</p>
    </div>
    
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

<style>

</style>