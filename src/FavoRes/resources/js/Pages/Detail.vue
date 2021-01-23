<template>
<div class="wrap">
    <Header :user="user" />

    <div class="content">
        <div class="img-wrap">
            <img :src="FixURL(article.image_path)">
        </div>
        <div class="text-wrap">
            <h1>{{article.title}}</h1>
            <p>{{article.content}}</p>
            <div class="user-wrap">
                <span>{{user.name}}</span>
                <img :src="user.profile_photo_url">
            </div>
        </div>
    </div>
    
    

    <h1>コメント</h1>
    <div v-for="comment in comments">
        <h2>{{comment}}</h2>
        <Button @my-click="deleteComment(comment.id)">delete</Button>
        <input type="text" name="content" :value="comment.content" @input="comment.inputValue = $event.target.value">
        <Button @my-click="updateComment(comment)">update</Button>
    </div>

    <h1>コメント書き込み</h1>
    <div>
        <input type="text" name="content" v-model="content">
        <Button @my-click="sendCommentInfo">send</Button>
    </div>

    <h1>5段階評価</h1>
    <div>
        <Button @my-click="sendNumStar(1)">1</Button>
        <Button @my-click="sendNumStar(2)">2</Button>
        <Button @my-click="sendNumStar(3)">3</Button>
        <Button @my-click="sendNumStar(4)">4</Button>
        <Button @my-click="sendNumStar(5)">5</Button>
        <h1 v-if="selectedStar">選択した星 : {{selectedStar.num_star}}</h1>
        
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
        "article" : Object,
        "user" : Object,
        "parent_comments" : Array,
        "parent_stars" : Array,
        "parent_selectedStar" : Object,
    },
    data() {
        return {
            comments : this.parent_comments,
            content : "",
            stars : this.parent_stars,
            selectedStar : this.parent_selectedStar,
        };
    },
    methods : {
        FixURL(url){
            return url[0]!='/' ? "/" + url : url;
        },
        sendCommentInfo(){
            const success = 200;
            const formData = new FormData();
            formData.append("content",this.content);
            formData.append("article_id",this.article.id);
            axios.post("/comments",formData).then(response => {
                if (response.status==success){
                    this.comments.push(response.data.comment);
                    console.log(response);
                }
            }).catch(response => {
                alert("failed");
                console.log(response);
            });
        },

        updateComment(comment){
            const success = 200;
            let formData = new FormData()
            formData.append("content",comment.inputValue);
            let config = { headers: {
                'X-HTTP-Method-Override': 'PUT'
                }
            };
            axios.post("/comments/"+comment.id, formData, config).then(response => {
                if (response.status==success){
                    comment.content = comment.inputValue;
                }
            }).catch(response => {
                console.log(response);
            })
        },

        deleteComment(comment_id){
            const success = 200;
            axios.delete("/comments/"+comment_id).then(response => {
                if (response.status==success){
                    console.log(response);
                    this.comments = this.comments.filter(el => el.id!=comment_id);
                }
            }).catch(response => {
                console.log(response);
            });
        },

        sendNumStar(starNum){
            const success = 200;
            let formData = new FormData()
            formData.append("num_star",starNum);
            let config = { headers: {
                'X-HTTP-Method-Override': 'PUT'
                }
            };
            axios.post("/stars/"+this.article.id, formData, config).then(response => {
                if (response.status==success){
                    console.log(response);
                    this.selectedStar = response.data.star;
                }
            }).catch(response => {
                console.log(response);
            })
        }
    },
    mounted() {
        console.log(this.article);
        console.log(this.user);
        console.log(this.comments);
        console.log(this.selectedStar);
        console.log(this.stars);
    },

    computed : {
        
    },

}
</script>

<style lang="scss" scoped>
.wrap{
    background: #F0F0F0;
}


.content{
    display: flex;
    background: white;
    margin: 3rem;

    .img-wrap{
        width: 50%;
        img{
            padding: 3rem 0;
            margin: 0 auto;
            width: 80%;
            height: 40rem;
        }
    }

    .text-wrap{
        width: 50%;
        padding: 3rem;

        h1{
            font-size: 3rem;
        }

        p{
            margin-top: 3rem;
            font-size: 1.5rem;
        }

        .user-wrap{
    
            text-align: right;
            margin-top: 5rem;

            span{
                display: inline;
                font-size: 1.5rem;
            }

            img{
                display: inline;
                width: 4rem;
                border-radius: 10rem;
                margin-left: 3rem;
            }
        }
    }
    
}

@media screen and (max-width:480px){
    .content{
        display: block;
        .img-wrap{
            width: 100%;
        }
        .text-wrap{
            width: 100%;
        }
    }
}
</style>