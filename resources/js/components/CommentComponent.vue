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
            <ul id="lastComment" class="list-group" v-for="comment in list">
                <li class="list-group-item">
                      <span class="circle">
                          <img v-bind:src="image + comment.user_id" alt="user">
                      </span>
                    <span class="title">
                          <a href="#">{{comment.author}} </a> <time> 6:00 PM</time>
                            <p>{{comment.text}}</p>
                      </span>

                    <ul class="list-inline actions" href="#">
                        <!--@todo: Add Delete icon on hover-->
                        <li><a class="edit" href="#" title="Edit comment">EditX</a></li>
                        <li class="roff"><a class="delete" href="#" title="DeleteQ"></a></li>
                    </ul>
                </li>
            </ul>
            <form>
                <fieldset class="form-group">
                    <input type="text"
                           class="form-control"
                           id="exampleInputEmail1"
                           placeholder="Add a comment">
                </fieldset>
                <button type="button" class="btn btn-sm btn-success">Post</button>
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
                total:0,
                comment: {
                    id:'',
                    user_id:'',
                    text:'',
                    author:'',
                    created_at:'',
                    visible:1
                }
            }
        },
        mounted: function(){
            console.log('Comments component loaded');
            this.fetchCommentsList();
        },
        methods:{
            fetchCommentsList: function(){
                console.log('Fetching Comments');
                let $this = this;
                axios.get(this.url)
                    .then((response) => {
                        this.list = response.data['data'];
                        this.total = response.data['meta'].total;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>