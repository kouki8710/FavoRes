<template>
<div>
    <Header :user="user" />
    <p>{{article}}</p>
    <Footer />
</div>
</template>

<script>
import Button from "@/Jetstream/Button"
import Header from "@/Components/Header"
import Footer from "@/Components/Footer"

export default{
    components : {
        Button,
        Header,
        Footer,
    },
    props : {
        "article" : Object,
        "user" : Object,
    },
    data() {
        return {

        };
    },
    mounted() {
        console.log(this.article);
        console.log(this.user);
    },

}
</script>

<style>

</style>