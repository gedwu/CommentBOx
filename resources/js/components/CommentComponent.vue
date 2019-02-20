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

            <div ref="component-up">Virsus</div>

            <!--@todo: change id to class-->
            <ul id="lastComment" class="list-group" v-for="(item, index) in list.slice().reverse()">
                <li class="list-group-item" :ref="'comment-'+item.id">
                      <span class="circle">
                          <img v-bind:src="image + item.user_id" alt="user">
                      </span>
                    <span class="title">
                          <a href="#">{{item.author}} </a> <time> {{item.created_at}}</time>
                        <!--@todo:styles-->
                            <p style="padding-right: 20px;">{{item.text}} </p>
                        <span>
                            <a @click="prepareReply(item, index)">Reply</a>
                        </span>
                        <!--@todo:-->
                        <span v-if="item.replies_count" class="float-right" @click="fetchReplies(item.id, index)">
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
                            <li class="list-group-item" :ref="'reply-'+reply.id">
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
            <div id="apacia" ref="apacia">Apacia</div>
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
                <button @click="setFocus()" type="button" class="btn btn-sm btn-danger">Focus</button>
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
                selectedIndex: null,
                // @todo: change to 4 after testing
                commentNumberToDisplay:10,
                replying:false,
                focusToComment:0,
                focusToReply:0,
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
            this.fetchCommentsList();
        },

        methods:{
            fetchCommentsList: function(){
                console.log('Fetching Comments');
                // @todo
                // let $this = this;

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
            prepareReply: function(comment, index) {
                document.getElementById('component-form').focus();
                this.replying = true;
                this.selectedIndex = index;
                this.reply.comment_id = comment.id;
            },
            createReply: function() {
                console.log('Creating Reply');
                this.reply.text = this.comment.text;
                let self = this;
                let params = Object.assign({}, self.reply);
                let commentId = self.reply.comment_id;
                // @todo
                // let index = self.commentNumberToDisplay-self.selectedIndex+1;
                axios.post('api/reply', params)
                    .then(function (response) {
                        if (response.status == 200) {
                            console.log(response.data.success);
                            self.focusToReply = response.data.reply_id;
                            console.log('Focus to Reply with ID: '+self.focusToReply);
                            self.success = response.data.success;
                        }
                    })
                    .then(function(){
                        self.focusToComment = self.reply.comment_id;
                        self.reply.user_id = '';
                        self.reply.comment_id = '';
                        self.reply.text = '';
                        self.comment.text = '';
                        self.fetchReplies(commentId, self.selectedIndex);
                        // self.scrollMeTo('reply-'+self.focusToReply);
                        self.scrollMeTo('comment-'+self.focusToComment);
                    })
                    .catch(function(error){
                        console.log('pagavom error createReply()');
                        console.log(error);
                        // @todo
                        // if (error.response.status == 422) {
                        //     self.errors = error.response.data.errors;
                        //     console.log(error.response.data.errors);
                        // } else {
                        //     console.log(error);
                        // }
                    })
            },
            fetchReplies: function(comment_id, index) {
                this.list[this.commentNumberToDisplay-index-1]['replies_count'] = 0;
                console.log('Fetching Replies');

                axios.get('api/replies/'+comment_id)
                    .then((response) => {
                        this.list[this.commentNumberToDisplay-index-1]['replies'] = response.data['data'];
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            setFocus: function() {
                console.log('Focusing');
                this.scrollMeTo('component-up');
            },
            scrollMeTo: function(refName) {
                var element = this.$refs[refName];
                var top = element.offsetTop;
                window.scrollTo(0, top);
            }
        }
    }
</script>
