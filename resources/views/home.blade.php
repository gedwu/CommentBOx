@extends('layouts.app')

@section('content')
    <div class="col-md-6 offset-md-3" style="margin-top:2em;">
        <h6 style="margin-bottom:1em;"> Frontend Task <small class="text-muted">for BitDegree Candidates</small> </h6>
        <div class="card paper">
            <details>
                {{--@todo: fix comment number--}}
                <summary style="padding:1em;">3 earlier comments</summary>
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
            <ul id="lastComment" class="list-group">
                <li class="list-group-item">
                      <span class="circle">
                          <img src="http://lorempixel.com/50/50/people/9" alt="user">
                      </span>
                    <span class="title">
                          <a href="#">Sandra Adams </a> <time> 6:00 PM</time>
                            <p>This is without doubt the greatest flim i’ve ever seen.</p>
                      </span>
                    <ul class="list-inline actions" href="#">
                        <li><a class="edit" href="#" title="Edit comment">Edit</a></li>
                        <li class="roff"><a class="delete" href="#" title="Delete comment"></a></li>
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
@endsection

