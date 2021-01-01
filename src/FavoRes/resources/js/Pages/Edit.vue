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
        <input type="button" value="update" @click="postArticleInfo()">
        <input type="button" value="delete" @click="deleteArticle()">
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
        postArticleInfo() {
            let data = {
                title : this.title,
                content : this.content,
                address : this.address,
            }
            axios.put("/articles/"+this.article.id,data).then(response =>{
                console.log(response);
                if (response.status=="200" && response.data.status=="success"){
                    location.href = response.data.redirect;
                }
            }).catch(response => {
                alert("保存に失敗しました");
            });
        },
        deleteArticle() {
            axios.delete("/articles/"+this.article.id).then(response =>{
                console.log(response);
                if (response.status=="200" && response.data.status=="success"){
                    location.href = response.data.redirect;
                }
            }).catch(response => {
                alert("保存に失敗しました");
            });
        },
    },
    mounted() {
        console.log(this.article);
        console.log(this.user);
        this.title = this.article.title  || "";
        this.content = this.article.content || "";
        this.address = this.article.address || "";
    },

}
</script>

<style>

</style>