<template>
    <div class="col-md-6 offset-md-3" style="margin-top:2em;">
        <h6 style="margin-bottom:1em;"> Frontend Task <small class="text-muted">for BitDegree Candidates</small> </h6>
        <div class="card paper">
            <details v-if="Number(total)>4">
                <summary style="padding:1em;">{{Number(total)-4}} earlier comments</summary>
                <ul class="list-group">
                    <li class="list-group-item ">
                              <span class="circle">
                                  <img src="http://lorempixel.com/50/50/people/6" alt="user">
                              </span>
                        <span class="title">
                                  <a href="#">Abbey Christensen</a> <time> 5:09 PM</time>
                                    <p>Can’t wait to see this movie.</p>
                              </span>
                        <ul class="actions" href="#">
                            <li><a class="reply" href="#">Reply</a></li>
                        </ul>
                    </li>
                    <li class="list-group-item">
                          <span class="circle">
                              <img src="http://lorempixel.com/50/50/people/7" alt="user">
                          </span>
                        <span class="title">
                              <a href="#">Ali Connors</a> <time> 5:15 PM</time>
                                <p>Mee too.</p>
                          </span>
                        <ul class="actions" href="#">
                            <li><a class="reply" href="#">Reply</a></li>
                        </ul>
                    </li>
                    <li class="list-group-item">
                          <span class="circle">
                              <img src="http://lorempixel.com/50/50/people/8" alt="user">
                          </span>
                        <span class="title">
                              <a href="#">Peter Carlsson</a> <time> 5:30 PM</time>
                                <p> I thought it was a good movie. The slow motion was a tad excessive at times, but overall it was good! I'm love it ;) </p>
                          </span>
                        <ul class="actions" href="#">
                            <li><a class="reply" href="#">Reply</a></li>
                        </ul>
                    </li>
                </ul>
            </details>
            <ul id="lastComment" class="list-group" v-for="item in list.slice().reverse()">
                <li class="list-group-item">
                      <span class="circle">
                          <img v-bind:src="image + item.user_id" alt="user">
                      </span>
                    <span class="title">
                          <a href="#">{{item.author}} </a> <time> 6:00 PM</time>
                            <p>{{item.text}}</p>
                      </span>

                    <ul class="list-inline actions" href="#">
                        <!--@todo: Add Delete icon on hover-->
                        <li><a class="edit" href="#" title="Edit comment">EditX</a></li>
                        <li class="roff"><a class="delete" href="#" title="DeleteQ"></a></li>
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
                url:'api/comments',
                image:'http://lorempixel.com/50/50/people/',
                list:[],
                errors: [],
                success: false,
                total:0,
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
                axios.get(this.url)
                    .then((response) => {
                        this.list = response.data['data'];
                        this.total = response.data['total_comments'];
                    })
                    .catch((error) => {
                        console.log(error);
                    });
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