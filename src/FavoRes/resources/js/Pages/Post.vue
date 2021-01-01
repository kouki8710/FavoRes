<template>
<div>
    <Header :user="user" />
    <form method="POST" action="/articles">
        <p>title</p>
        <input type="text" name="title" v-model="title">
        <p>content</p>
        <input type="text" name="content" v-model="content">
        <p>address</p>
        <input type="text" name="address" v-model="address">
        <input type="button" value="send" @click="postArticleInfo()">
    </form>
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
            title : "",
            content : "",
            address : "",
        };
    },
    methods : {
        postArticleInfo(){
            let data = {
                title : this.title,
                content : this.content,
                address : this.address,
            }
            axios.post("/articles",data).then(response =>{
                console.log(response);
                if (response.status=="200" && response.data.status=="success"){
                    location.href = response.data.redirect;
                }
            }).catch(response => {
                alert("保存に失敗しました");
            });
        }
    },
    mounted() {
        console.log(this.article);
        console.log(this.user);
    },

}
</script>

<style>

</style>