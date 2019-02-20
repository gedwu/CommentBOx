<template>
    <!--@todo:styles-->
    <div class="col-md-6 offset-md-3" style="margin-top:2em;">
        <!--@todo:styles-->
        <h6 style="margin-bottom:1em;"> Frontend Task
            <small class="text-muted">for BitDegree Candidates</small>
        </h6>
        <div class="card paper">
            <details v-if="Number(total)>commentNumberToDisplay">
                <!--@todo:styles-->
                <summary style="padding:1em;" v-on:click="fetchMoreComments()">
                    {{Number(total)-commentNumberToDisplay}} earlier comments
                </summary>
            </details>

            <!--@todo: change id to class-->
            <ul id="lastComment" class="list-group" v-for="(item, index) in list.slice().reverse()">
                <li class="list-group-item" v-bind:id="'comment-'+item.id">
                      <span class="circle">
                          <img v-bind:src="image + item.user_id" alt="user">
                      </span>
                    <span class="title">
                          <a href="#">{{item.author}} </a> <time> {{item.created_at}}</time>
                        <!--@todo:styles-->
                            <p style="padding-right: 20px;">{{item.text}} </p>
                        <span>
                            <a href="#component-form" @click="prepareReply(item)">Reply</a>
                        </span>
                        <!--@todo:-->
                        <span v-if="item.replies_count" class="float-right" @click="getReplies(item.id, index)">
                            (View {{item.replies_count}} Replies)
                        </span>
                      </span>


                    <ul class="list-inline actions">
                        <li>
                            <a @click="deleteComment(item.id)" href="#" title="Delete comment" >
                                <i class="fa fa-trash-o fa-stack-1x delete-icon-size"></i>
                            </a>
                        </li>
                    </ul>
                    <div v-if="item.replies.length != 0">
                        <ul class="list-group" v-for="reply in item.replies">
                            <li class="list-group-item">
                                <span class="reply-img circle">
                                    <img v-bind:src="image + reply.user_id" alt="user">
                                </span>
                                <span class="title">
                                  <a href="#"> {{reply.author}} </a> <time> {{item.created_at}}</time>
                                    <p>{{reply.text}}</p>
                                </span>
                            </li>
                        </ul>
                    </div>

                </li>
            </ul>
            <form action="#" @submit.prevent="replying ? createReply() : createComment()">
                <fieldset class="form-group">
                    <input v-model="comment.text"
                            type="text"
                           class="form-control"
                           id="component-form"
                           :placeholder="replying ? 'Add a Reply' : 'Add a Comment' ">
                </fieldset>
                <button type="submit" class="btn btn-sm btn-success">{{replying ? 'Reply' : 'Comment'}}</button>
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
                replying:false,
                focusToComment:0,
                reply: {
                    user_id:this.$userId,
                    comment_id:'',
                    text:''
                },
                comment: {
                    id:'',
                    user_id:this.$userId,
                    text:'',
                    author:'',
                    created_at:'',
                    replies:[]
                }
            }
        },
        mounted: function(){
            console.log('Comments component loaded');
            this.fetchCommentsList();
            if (this.focusToComment) {
                document.getElementById('comment-'.this.focusToComment).focus();
            }
        },
        methods:{
            fetchCommentsList: function(){
                console.log('Fetching Comments');
                let $this = this;

                axios.get(this.url+this.commentNumberToDisplay)
                    .then((response) => {
                        this.list = response.data['data'];
                        // console.log(response.data['data']);
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
            deleteComment: function(id){
                let self = this;
                console.log('Deleting comment with id: '+id);
                axios.delete('api/comment/'+id)
                    .then(function (response) {
                        if (response.status == 200) {
                            console.log(response.data.success);
                            self.success = response.data.success;
                            self.fetchCommentsList();
                        }
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            },
            prepareReply: function(comment) {
                document.getElementById('component-form').focus();
                this.replying = true;
                this.reply.comment_id = comment.id;
            },
            createReply: function() {
                console.log('Creating Reply');

                this.reply.text = this.comment.text;
                let self = this;
                let params = Object.assign({}, self.reply);
                axios.post('api/reply', params)
                    .then(function (response) {
                        if (response.status == 200) {
                            console.log(response.data.success);
                            self.success = response.data.success;
                        }
                    })
                    .then(function(){
                        self.focusToComment = self.reply.comment_id;
                        self.reply.user_id = '';
                        self.reply.comment_id = '';
                        self.reply.text = '';
                        self.comment.text = '';
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
            fetchReplies: function(comment_id, index) {
                console.log('Fetching Replies');

                axios.get('api/replies/'+comment_id)
                    .then((response) => {
                        // this.list[index]['replies'] = response.data['data'];
                        this.list[this.commentNumberToDisplay-index-1]['replies'] = response.data['data'];
                        console.log(index);
                        console.log(this.commentNumberToDisplay-index);

                        // console.log(this.list[index]['replies']);
                    })
                    // .then(function() {
                //     document.getElementById('comment-'.comment_id).focus();
                // })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            getReplies: function(comment_id, index) {
                this.fetchReplies(comment_id, index);
                this.focusToComment = comment_id;

                // this.fetchCommentsList();
                // @todo
                // if (this.focusToComment) {
                //     document.getElementById('comment-'.this.focusToComment).focus();
                // }
            }
        }
    }
</script>
