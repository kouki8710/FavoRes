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
        <p>Image</p>
        <input type="file" name="image" @change="onFileChange">
        <input type="button" value="send" @click="postArticleInfo">
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
            image_path : "",
        };
    },
    methods : {
        postArticleInfo(){
            const formData = new FormData()
            formData.append("title",this.title);
            formData.append("content",this.content);
            formData.append("address",this.address);
            formData.append("image",this.image);
            axios.post("/articles",formData).then(response =>{
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
    },
    mounted() {
        console.log(this.article);
        console.log(this.user);
    },

}
</script>

<style>

</style>