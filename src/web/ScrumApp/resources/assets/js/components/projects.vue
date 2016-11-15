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
                    <a class="input-group-addon btn btn-success" v-on:click="modalShow=true">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>

            </br>
            </br>
            </br>
            </div><!-- /input-group -->
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4 pad" v-for="(item, index) in owns">
                <div class="thumbnail">
                    <a :href="getBacklogLink(item)" class="caption nounderline">
                        <h3>{{ item.name }}   <span class="badge">Owner</span></h3>
                        <p class="desc">
                            {{ item.description }}
                        </p>
                        <div class="pull-right"><i class="fa fa-list fa-4x"></i></div>
                    </a>
                    <button class="btn btn-primary" role="button" v-on:click="getLinkOwns(index)">
                        <i class="fa fa-gear"></i>
                    </button>
                    <button  class="btn btn-info" role="button" v-on:click="getEdit(index)">
                        <i class="fa fa-pencil-square-o"></i>
                    </button>
                    <button class="btn btn-danger" role="button" v-on:click="deleteProject(item)">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4 pad" v-for="(item, index) in member">
                <div class="thumbnail">
                    <a :href="getBacklogLink(item)" class="caption nounderline">
                        <h3>{{ item.name }}   <span class="badge">Member</span></h3>
                        <p class="desc">
                            {{ item.description }}
                        </p>
                        <div class="pull-right"><i class="fa fa-list fa-4x"></i></div>
                    </a>

                    <button class="btn btn-primary" role="button" v-on:click="getLinkMember(index)" >
                        <i class="fa fa-gear"></i>
                    </button>

                </div>


            </div>
        </div>

        <div class="container">
            <modal title="Create New Project"
                   :show.sync="modalShow"
                   :okText="'Create'"
                   :okClass="'btn btn-success'"
                   :cancelClass="'btn btn-danger'"
                   @ok="addproj"
                   @cancel="cancel">
                <form class="form-horizontal" >
                    <div class="form-group">
                        <label for="name"  class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input id="name" v-model="addNewRequest.name" type="text" class="form-control" name="name" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description"  class="col-md-4 control-label">Description</label>
                        <div class="col-md-6">
                            <textarea id="description" v-model="addNewRequest.description" class="form-control" name="description" value="" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="language" j class="col-md-4 control-label">Language</label>
                        <div class="col-md-6">
                            <input id="language" v-model="addNewRequest.language" type="text" class="form-control" name="language" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="version" class="col-md-4 control-label">Version</label>
                        <div class="col-md-6">
                            <input id="version" v-model="addNewRequest.version" type="text" class="form-control" name="version" required>
                        </div>
                    </div>
                </form>
            </modal>
        </div>

        <div class="container">
            <modal title="Project Details"
                   :show.sync="modalShowProject"
                   :okText="'Close'"
                   :okClass="'btn btn-success'"
                   @ok="closeDetails"
                   :cancelClass="'hidden'"
                   @cancel="closeDetails">

                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="panel panel-default">
                            <div class="panel-heading">{{proj.name}}</div>
                            <div class="panel-body">
                                <label for="language" class="col-md-4 control-label">Desciption</label>
            </br>
            <div class="well">{{ proj.description }}</div>
            <label for="language" class="col-md-4 control-label">Language</label>
            </br>
            <div class="well">{{ proj.language }}</div>
            <label for="language" class="col-md-4 control-label">Version</label>
            </br>
            <div class="well">{{ proj.version }}</div>
            <label for="language" class="col-md-4 control-label">Owner</label>
            </br>
            <div class="well">{{ proj.username }}</div>
            <label for="language" class="col-md-4 control-label">Members</label>
            </br>
            <div id="memb" >
                <adduser  v-bind:membs="members" v-bind:pid="proj.id"></adduser>
            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </modal>
        </div>

        <div class="container">
            <modal title="Edit Details"
                   :show.sync="modalShowEdit"
                   :okText="'Edit'"
                   :okClass="'btn btn-success'"
                   @ok="editDetails"
                   :cancelClass="'btn btn-danger'"
                   @cancel="cancel">

                <form class="form-horizontal" >
                    <div class="form-group">
                        <label for="name"  class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input id="name" v-model="edit.name" type="text" class="form-control" name="name" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description"  class="col-md-4 control-label">Description</label>
                        <div class="col-md-6">
                            <textarea id="description" v-model="edit.description" class="form-control" name="description" value="" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="language" j class="col-md-4 control-label">Language</label>
                        <div class="col-md-6">
                            <input id="language" v-model="edit.language" type="text" class="form-control" name="language" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="version" class="col-md-4 control-label">Version</label>
                        <div class="col-md-6">
                            <input id="version" v-model="edit.version" type="text" class="form-control" name="version" required>
                        </div>
                    </div>
                </form>
            </modal>
        </div>
    </div>
</template>
<script>
 export default{
     data: function(){
         return {
             addNewRequest: {
                 name: '',
                 user_id: '',
                 description: '',
                 language: '',
                 version: '',
             },
             edit: {
                 name: '',
                 user_id: '',
                 description: '',
                 language: '',
                 version: '',
                 id: '',
             },
             modalShowProject: false,
             modalShowEdit: false,
             owns:[],
             member:[],
             proj:{
                 name: '',
                 id: '',
                 user_id: '',
                 description: '',
                 language: '',
                 version: '',
                 username: '',
             },
             message: "",
             modalShow: false
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
         getLinkOwns: function(item){
             this.proj.name = this.owns[item].name;
             this.proj.id = this.owns[item].id;
             this.proj.description = this.owns[item].description;
             this.proj.version = this.owns[item].version;
             this.proj.language = this.owns[item].language;
             this.proj.user_id = this.owns[item].user_id;
             this.proj.username = this.owns[item].username;
             this.modalShowProject= true;
             },
         getLinkMember: function(item){
             this.proj.name = this.member[item].name;
             this.proj.id = this.member[item].id;
             this.proj.description = this.member[item].description;
             this.proj.version = this.member[item].version;
             this.proj.language = this.member[item].language;
             this.proj.user_id = this.member[item].user_id;
             this.proj.username = this.member[item].username;
             this.modalShowProject= true;
             },
        getEdit: function(item){
             this.edit.name = this.owns[item].name;
             this.edit.id = this.owns[item].id;
             this.edit.description = this.owns[item].description;
             this.edit.version = this.owns[item].version;
             this.edit.language = this.owns[item].language;
             this.edit.user_id = this.owns[item].user_id;
             this.modalShowEdit= true;
             },

        addproj: function(){
            this.addNewRequest.user_id=this.user;
            this.$http.post('/api/project/add',this.addNewRequest).then(function(response){
                console.log(response);
            });
            this.addNewRequest = {
                 name: '',
                 user_id: '',
                 description: '',
                 language: '',
                 version: '',
             };
            this.modalShow = false;
            this.update();
             },
        editDetails: function(){
            this.$http.post('/api/project/edit',this.edit);
            this.modalShowEdit = false;
                 this.update();
             },
        cancel: function(){
            this.modalShow = false;
             this.modalShowEdit= false;
             },
        closeDetails: function(){
             this.modalShowProject= false;
                 this.update();
             },
        getBacklogLink: function(item){
            return '/backlog/'+item.id;
             },
     },
 }
</script>
<style scoped>
 .thumbnail{
    width: 100%; // or you could use percentage value for responsive layout
    height: 100px;
    overflow: auto;
}
 .pad{
    padding-right: 45px;
    padding-left: 45px;
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
.nounderline{text-decoration: none}

.thumbnail:hover
{
    box-shadow: 0px 0px 150px #000000;
    z-index: 2;
    -webkit-transition: all 200ms ease-in;
    -webkit-transform: scale(1.5);
    -ms-transition: all 200ms ease-in;
    -ms-transform: scale(1.5);   
    -moz-transition: all 200ms ease-in;
    -moz-transform: scale(1.5);
    transition: all 200ms ease-in;
    transform: scale(1.1);
}
</style>
