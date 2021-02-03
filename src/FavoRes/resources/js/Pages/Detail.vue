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
                <span>{{article.user.name}}</span>
                <img :src="article.user.profile_photo_url">
            </div>
        </div>
    </div>
    
    <div class="star-wrap">
        <h1>5段階評価</h1>
        <div>
            <Button @my-click="sendNumStar(1)">1</Button>
            <Button @my-click="sendNumStar(2)">2</Button>
            <Button @my-click="sendNumStar(3)">3</Button>
            <Button @my-click="sendNumStar(4)">4</Button>
            <Button @my-click="sendNumStar(5)">5</Button>
           
        </div>
        <h1 v-if="selectedStar">選択した評定 : {{selectedStar.num_star}}</h1>
        <h2>平均評定 : {{star_ave}}</h2>
        <p></p>
    </div>
    

    
    <div class="comment-wrap">
        <h2 class="comment-h1">--コメント--</h2>
        <div class="comment-item" v-for="comment in comments">
            <h2>{{comment.content}}</h2>
            <div class="user-wrap">
                <span>{{comment.user.name}}</span>
                <img :src="comment.user.profile_photo_url">
            </div>
            <div class="comment-edit" v-if="user && user.id == comment.user.id">
            <p>編集</p>
                <input type="text" name="content" :value="comment.content" @input="comment.inputValue = $event.target.value">
                <Button @my-click="updateComment(comment)">update</Button>
                <Button @my-click="deleteComment(comment.id)">delete</Button>
            </div>
        </div>

        <div class="comment-create">
            <h2>コメント書き込み</h2>
            <input type="text" name="content" v-model="content">
            <Button @my-click="sendCommentInfo">send</Button>
        </div>
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
        "parent_selectedStar" : Object,
        "parent_star_ave": Number,
    },
    data() {
        return {
            comments : this.parent_comments,
            content : "",
            selectedStar : this.parent_selectedStar,
            star_ave : this.parent_star_ave,
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
                if (response.status==success && response.data.status=="success"){
                    this.comments.push(response.data.comment);
                }else if(response.status==success && response.data.status=="error"){
                    alert(response.data.msg);
                }
                console.log(response);
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
                if (response.status==success && response.data.status=="success"){
                    comment.content = comment.inputValue;
                }
            }).catch(response => {
                console.log(response);
            })
        },

        deleteComment(comment_id){
            const success = 200;
            axios.delete("/comments/"+comment_id).then(response => {
                if (response.status==success && response.data.status=="success"){
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
                if (response.status==success && response.data.status=="success"){
                    console.log(response);
                    this.selectedStar = response.data.star;
                    this.star_ave = response.data.star_ave;
                }else if(response.status==success && response.data.status=="error"){
                    alert(response.data.msg);
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
        console.log(this.star_ave);
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

.star-wrap{
    margin: 5rem;
    width: 50%;
}

.comment-wrap{
    margin: 5rem;
    width: 50%;

    .comment-h1{
        font-size: 3rem;
    }

    .comment-item{
        background: white;
        margin: 3rem 0;
        padding: 2rem;

        .user-wrap{
    
            text-align: right;
            margin-top: 2rem;

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

        .comment-edit{
            margin-top: 2rem;

            input{
                width: 100%;
                padding: 1rem;
                border: 1px solid black;
                border-radius: 3px;
                box-sizing: border-box;
            }

            Button{
                display: block;
                margin: 1rem 0 1rem auto ;
            }
        }

        
    }



    .comment-create{

        h2{
            font-size: 2rem;
            margin: 1rem 0;
        }
            
        input{
            width: 100%;
            padding: 1rem;
            border: 1px solid black;
            border-radius: 3px;
            box-sizing: border-box;
        }

        Button{
            display: block;
            margin: 1rem 0 1rem auto ;
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