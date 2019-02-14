<template>
    <div class="col-md-6 offset-md-3" style="margin-top:2em;">
        <h6 style="margin-bottom:1em;"> Frontend Task <small class="text-muted">for BitDegree Candidates</small> </h6>
        <div class="card paper">
            <details v-if="Number(total)>commentNumberToDisplay">
                <summary style="padding:1em;" v-on:click="fetchMoreComments()">
                    {{Number(total)-commentNumberToDisplay}} earlier comments
                </summary>
            </details>
            <ul id="lastComment" class="list-group" v-for="item in list.slice().reverse()">
                <li class="list-group-item">
                      <span class="circle">
                          <img v-bind:src="image + item.user_id" alt="user">
                      </span>
                    <span class="title">
                          <a href="#">{{item.author}} </a> <time> {{item.created_at}}</time>
                            <p>{{item.text}}</p>
                      </span>

                    <ul class="list-inline actions" href="#">
                        <!--@todo: Add Delete icon on hover-->
                        <!--<li><a class="edit" href="#" title="Edit comment">Editt</a></li>-->

                        <li class="">
                            <a class="" href="#" title="Delete comment">
                                <!--@todo: add icon-->
                            <!--<i class="fas fa-times"></i>-->
                                Delete
                        </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <form action="#" @submit.prevent="createComment()">
                <fieldset class="form-group">
                    <input v-model="comment.text"
                            type="text"
                           class="form-control"
                           placeholder="Add a comment">
                </fieldset>
                <button type="submit" class="btn btn-sm btn-success">Post</button>
                <button type="button" class="btn btn-sm btn-secondary">Cancel</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data: function(){
            return {
                url:'api/comments/',
                image:'http://lorempixel.com/50/50/people/',
                list:[],
                errors: [],
                success: false,
                total:0,
                commentNumberToDisplay:4,
                comment: {
                    id:'',
                    user_id:this.$userId,
                    text:'',
                    author:'',
                    created_at:'',
                    visible:1
                }
            }
        },
        mounted: function(){
            console.log('Comments component loaded');
            // @todo: delete this
            console.log('Curent user ID: '+this.$userId);
            this.fetchCommentsList();
        },
        methods:{
            fetchCommentsList: function(){
                console.log('Fetching Comments');
                let $this = this;
                axios.get(this.url+this.commentNumberToDisplay)
                    .then((response) => {
                        this.list = response.data['data'];
                        this.total = response.data['total_comments'];
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            fetchMoreComments:function(){
                this.commentNumberToDisplay += 20;
                this.fetchCommentsList();
            },
            createComment: function(){
                console.log('Creating Comment');
                this.errors = [];
                let self = this;
                let params = Object.assign({}, self.comment);
                axios.post('api/comment', params)
                    .then(function (response) {
                        if (response.status == 200) {
                            console.log(response.data.success);
                            self.success = response.data.success;
                        }
                    })
                    .then(function(){
                        self.comment.author = '';
                        self.comment.text = '';
                        self.comment.visible = 1;
                        self.fetchCommentsList();
                    })
                    .catch(function(error){
                        if (error.response.status == 422) {
                            self.errors = error.response.data.errors;
                            console.log(error.response.data.errors);
                        } else {
                            console.log(error);
                        }
                    })
            },
        }
    }
</script>