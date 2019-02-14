<!--<template>-->

<!--</template>-->

<!--<script>-->
    <!--import {settings} from "../const";-->
    <!--export default {-->
        <!--data: function(){-->
            <!--return {-->
                <!--url:'api/comments',-->
                <!--list:[],-->
                <!--errors: [],-->
                <!--user: {-->
                    <!--id:'',-->
                    <!--text:'',-->
                    <!--author:'',-->
                    <!--created_at:''-->
                <!--}-->
            <!--}-->
        <!--},-->
        <!--mounted: function(){-->
            <!--console.log('Users component loaded');-->
            <!--this.settings = settings;-->
            <!--this.fetchCommentsList();-->
        <!--},-->
        <!--methods:{-->
            <!--fetchCommentsList: function(){-->
                <!--console.log('Fetching Comments');-->
                <!--let $this = this;-->
                <!--axios.get(this.url)-->
                    <!--.then((response) => {-->
                        <!--this.list = response.data['data'];-->
                        <!--$this.makePagination(response.data['meta'], response.data['links']);-->
                    <!--})-->
                    <!--.catch((error) => {-->
                        <!--console.log(error);-->
                    <!--});-->
            <!--}-->
        <!--}-->
    <!--}-->
<!--</script>-->