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
        <input type="file" name="image" @change="onFileChange">
        <input type="button" value="update" @click="postArticleInfo()">
        <input type="button" value="delete" @click="deleteArticle()">
    </form>
    <img :src="image_path" v-if="image_path">
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
            image : null,
            image_path : null,
        };
    },
    methods : {
        postArticleInfo() {
            let formData = new FormData()
            formData.append("title",this.title);
            formData.append("content",this.content);
            formData.append("address",this.address);
            formData.append("image",this.image);
            let config = { headers: {
                'X-HTTP-Method-Override': 'PUT'
                }
            };
            axios.post("/articles/"+this.article.id,formData, config
            ).then(response =>{
                console.log(response);
                if (response.status=="200" && response.data.status=="success"){
                    // location.href = response.data.redirect;
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
        onFileChange(e){
            let file = e.target.files[0];
            let blobURL = URL.createObjectURL(file);
            this.image_path = blobURL;
            this.image = file;
        },
        FixURL(url){
            if (url[0]!="/"){
                return "/" + url;
            }
        }
    },
    mounted() {
        console.log(this.article);
        console.log(this.user);
        this.title = this.article.title  || "";
        this.content = this.article.content || "";
        this.address = this.article.address || "";
        this.image_path = this.article.image_path ? this.FixURL(this.article.image_path) : "";
    },

}
</script>

<style>

</style>