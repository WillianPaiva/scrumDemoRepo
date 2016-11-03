<template>
    <div>
        <div class="row search">
            <div class="col-sm-4 col-sm-offset-4">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-search"></i>
                </span>
                <input type="text"  v-model="message"
                       class="form-control"
                       placeholder="Search project"
                       @input="update"
                />
                <a class="input-group-addon btn btn-success" href="/project/add">
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            </br>
            </br>
            </br>
        </div><!-- /input-group -->
        </div>


        <div class="row">
            <div class="col-sm-6 col-md-4" v-for="item in owns">
                <div class="thumbnail">
                    <div class="caption">
                        <h3>{{ item.name }}   <span class="badge">Owner</span></h3>
                        <p class="desc">
                            {{ item.description }}
                        </p>
                        <p>
                            <a :href="getLink(item)" class="btn btn-primary" role="button">
                                <i class="fa fa-external-link"></i>
                            </a>
                            <a :href="getEdit(item)" class="btn btn-info" role="button">
                                <i class="fa fa-pencil-square-o"></i>
                            </a>
                            <button class="btn btn-danger" role="button" v-on:click="deleteProject(item)">
                                <i class="fa fa-trash"></i>
                            </button></p>

                    </div>


                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4" v-for="item in member">
                <div class="thumbnail" >
                    <div class="caption">
                        <h3>{{ item.name }}   <span class="badge">Member</span></h3>
                        <p class="desc">
                            {{ item.description }}
                        </p>
                        <p>
                            <a :href="getLink(item)" class="btn btn-primary" role="button">
                                <i class="fa fa-external-link"></i>
                            </a>
                            </p>

                    </div>


                </div>
            </div>
        </div>
    </div>

</template>
<script>
 export default{
     data: function(){
         return {
             owns:[],
             member:[],
             message: ""
         }
     },
     props:['user'],

     mounted(){
         this.populate();
     },

     methods:{
         hasOwns: function(){
             return (this.owns.length > 0);
         },
         hasMember: function() {
             return (this.member.length > 0);
         },
         populate: function(){
             this.$http.get('/api/getownproject/'+this.user).then(function(response){
                 this.owns = response.data;
             });
             this.$http.get('/api/getmemberproject/'+this.user).then(function(response){
                 this.member = response.data;
             });
         },
         deleteProject: function(item){
             var r = confirm("do you really want to delete "+item.name);
             if (r == true) {
                 this.$http.post('/api/project/delete/'+item.id);
                 this.update();
             } else {
             }
         },
         update: function(){
             this.$http.get('/api/getownproject/'+this.user+'/'+this.message).then(function(response){
                 this.owns = response.data;
             });
             this.$http.get('/api/getmemberproject/'+this.user+'/'+this.message).then(function(response){
                 this.member = response.data;
             });
         },
         getLink: function(item){
             return "/project/"+item.id;
             },
        getEdit: function(item){
             return "/project/showModifyProject/"+item.id;
             },

     }
 }
</script>
<style scoped>
 .thumbnail{        
    width: 100%; // or you could use percentage value for responsive layout
    height: 100px;
    overflow: auto;
}

.desc {
   overflow: hidden;
   text-overflow: ellipsis;
   display: -webkit-box;
   -webkit-box-orient: vertical;
    height: 3em; /* 2.5ex for each visible line */
   -webkit-line-clamp: 2; /* number of lines to show */
   line-height: 16px;        /* fallback */
   max-height: 32px;       /* fallback */
}

</style>
