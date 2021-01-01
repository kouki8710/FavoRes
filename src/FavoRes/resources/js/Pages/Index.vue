<template>
<div>
    <Header :user="user" />
    <section v-for="article in articles">
        <p>-------------------</p>
        <p>ID : {{article.id}}</p>
        <a :href="'/articles/'+article.id">{{article.title}}</a>
        <h3>{{article.content}}</h3>
        <p>{{article.address}}</p>
    </section>
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
        "articles" : Array,
        "user" : Object,
    },
    data() {
        return {

        };
    },
    mounted() {
        console.log(this.articles);
        console.log(this.user);
    },

}
</script>

<style>

</style>