<template>
<div class="wrap">
    <Header :user="user" />
    <div class="Intro">
        <h1>FavoRes</h1>
        <p>お気に入りの外食を共有しよう！思いがけないグルメとの出会いがあるかも！</p>
        <Button>Twitter</Button>
        <Button>Google</Button>
    </div>
    <div class="main">
        <h2 class="content-title">--新規記事--</h2>
        <section class="item" v-for="article in articles">
            <div class="img-wrap">
                <img :src="FixURL(article.image_path)">
            </div>
            <div class="text-wrap">
                <h1><a :href="'/articles/'+article.id">{{article.title}}</a></h1>
                <p>{{article.content}}</p>
                <p>{{article.address}}</p>

                <div class="user-wrap">
                    <span>{{article.user.name}}</span>
                    <img :src="article.user.profile_photo_url">
                </div>
            </div>
            
        </section>
    </div>
    
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
    methods : {
        FixURL(url){
            if (typeof(url) === "string" && url){
                return url[0]!='/' ? "/" + url : url;
            }else{
                return "";
            }
            
        },
    },
    mounted() {
        console.log(this.articles);
        console.log(this.user);
    },

}
</script>

<style lang="scss" scoped>

.wrap{
    background: #F0F0F0;
}

.main{

    margin: 5rem;
    

    .content-title{
        font-size: 3rem;
        margin-left: 5rem;
    }

    .item{
        background: white;
        margin: 5rem 0;
        display: flex;
        width: 50%;

        .img-wrap{
            width: 50%;
            img{
                padding: 3rem 0;
                margin: 0 auto;
                width: 80%;
                height: 20rem;
            }
        }

        .text-wrap{
            width: 50%;
            padding: 2rem;

            h1{
                font-size: 2rem;
                border-bottom: 2px solid black;

                &:hover{
                    opacity: 0.5;
                }
            }


            p{
                margin-top: 1rem;
                font-size: 1.2rem;
            }

            .user-wrap{
            
                text-align: right;
                margin-top: 2rem;

                span{
                    display: inline;
                    font-size: 1.2rem;
                }

                img{
                    display: inline;
                    width: 3rem;
                    border-radius: 10rem;
                    margin-left: 3rem;
                }
            }
        }
    }

    
}

@media screen and (max-width:480px){
    .main{
        .item{
            display: block;
            width: 100%;
            .img-wrap{
                width: 100%;
            }
            .text-wrap{
                width: 100%;
            }
        }
    }
    
}

</style>