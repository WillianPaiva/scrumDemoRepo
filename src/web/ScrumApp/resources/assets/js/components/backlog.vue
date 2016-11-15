<template>
    <div>
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <div class="container-fluid panel-container">
                                <div class="col-xs-3 text-left">
                                    <h4 class="panel-title abc">
                                        {{ project.name }}
                                    </h4>
                                </div>


                             <div class="col-xs-6 text-center ">
                                 <select  v-model="order" class="soflow">
                                     <option value="created_at">created</option>
                                     <option value="effort">effort</option>
                                     <option value="priority">priority</option>
                                 </select>
                             </div>

                             <div class="col-xs-3 text-right">
                                 <button class="btn btn-success pull-right" v-on:click="showAddUs = true">
                                     <i class="fa fa-plus"></i>
                                 </button>
                             </div>

                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="well">
                                <div v-if="isEmpty()">
                                    <h1>backlog is empty</h1>
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item clearfix"
                                        v-for="(item , index) in userstory"
                                    >
                                        <p style="top:15%;" class="truncate">

                                            <label class="label label-warning" style="margin-right: 7px;">
                                                US#{{getIndex(item.id)}}
                                            </label>
                                               {{ item.description }}
                                        </p>
                                        <div>
                                            <label class="label label-success">
                                                Effort
                                                <span class="badge">{{ item.effort }}</span>
                                            </label>
                                            <label class="label label-info">
                                                Priority
                                                <span class="badge">{{ item.priority }}</span>
                                            </label>
                                                <label class="label label-danger" v-if="item.sprint_id > 0" style="margin-right: 7px;" >

                                                sprint#{{ getIndexSprint(item.sprint_id) }}
                                            </label>

                                            <label class="label label-success" v-if="item.date_estimated != null" style="margin-right: 7px;" >
                                                begin {{ item.date_begin }}
                                            </label>
                                            <label class="label label-info" v-if="item.date_estimated !=null" style="margin-right: 7px;" >
                                                expected {{ item.date_estimated }}
                                            </label>

                                            <button class="btn btn-danger pull-right" v-on:click="deleteUs(item)"><span class="fa fa-trash"></span></button>
                                            <a class="btn btn-info pull-right" :href="openus(item)"><span class="fa fa-gear"></span></a>
                                        <button class="btn btn-info pull-right" v-on:click="getUs(item)" ><span class="fa fa-pencil-square-o"></span></button>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title pull-left" style="padding-top: 7.5px;">
                                Sprints
                            </h4>
                            <button class="btn btn-success pull-right" v-on:click="showAddSprint = true" >
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>

                        <div class="panel-body">
                            <div class="well">
                                <div v-if="SprintisEmpty()">
                                    <h1>No Sprints</h1>
                                </div>
                                    <ul class="list-group">
                                        <li class="list-group-item clearfix" style="" v-for="item in sprint">
                                        <p style="top:15%;" class="truncate">
                                            <label class="label label-warning" style="margin-right: 7px;">
                                               Sprint#{{ getIndexSprint(item.id) }}
                                            </label>
                                                    {{ item.name }}
                                        </p>
                                            <div>
                                                <label class="label label-info" style="margin-right: 7px;" >
                                                    Begin: {{ item.date_begin }} </label> <label class="label label-success"> Finish: {{ item.date_estimated }} </label>
                                                <button class="btn btn-danger pull-right" v-on:click="deleteSprint(item)"><span class="fa fa-trash"></span></button>
                                                <button class="btn btn-info pull-right" v-on:click="getSprint(item)" ><span class="fa fa-pencil-square-o"></span></button>
                                            </div>
                                        </li>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <createus v-bind:boolShow="showAddUs" :id="id" @close="close()"></createus>
        <editus  v-bind:boolShow="showEditUs" :id="idTosend" @close="close()" @ok="update()"></editus>
        <createsprint v-bind:boolShow="showAddSprint" :id="id" @close="close()"></createsprint>
        <editsprint v-bind:boolShow="showEditSprint" :id="SprintId" @close="close()" @ok="update()"></editsprint>



    </div>
</template>
<script>
 export default{
     data(){
         return{
             order: 'created_at',
             project:{},
             idTosend:1,
             SprintId:1,
             userstory:[],
             ids:[],
             showAddUs: false,
             showEditUs:false,
             showAddSprint: false,
             showEditSprint:false,
             SprintsIds:[],
             sprint:[],
         }
     },
     watch: {
         order: function(){
             this.fetch();
         }
     },
     props:['id'],
     mounted(){
         this.fetch();
     },
     methods:{
         fetch: function(){

             this.$http.get('/api/backlog/'+this.id+'/created_at').then(function(response){

                 this.ids= []
                 for(var i =0; i < response.data.length; i++){
                     this.ids.push(response.data[i].id);
                     }

             });
            this.$http.get('/api/sprint/'+this.id).then(function(response){
                 this.sprint = response.data;
                 this.SprintsIds= []
                 for(var i =0; i < response.data.length; i++){
                     this.SprintsIds.push(response.data[i].id);
                     }
             });
             this.$http.get('/api/backlog/'+this.id+'/'+this.order).then(function(response){
                 this.userstory = response.data;
             });
             this.$http.get('/api/project/'+this.id).then(function(response){
                 this.project = response.data;
             });

         },
         isEmpty: function(){
             return !(this.userstory.length > 0);
         },
         deleteUs: function(item){

             var r = confirm("do you really want to delete  this us ?");
             if (r == true) {
                 this.$http.post('/api/us/delete/'+item.id);
             this.fetch();
             } else {
             }

         },
         getUs: function (item){
            this.idTosend=item.id;
            this.showEditUs=true;
        },
        getSprint: function (item){
            this.SprintId=item.id;
            this.showEditSprint=true;
        },

         SprintisEmpty: function(){
             return !(this.sprint.length > 0);
         },

        deleteSprint: function(item){
             var r = confirm("do you really want to delete  this sprint ?");
             if (r == true) {
                 this.$http.post('/api/sprint/delete/'+item.id);
                 this.fetch();
             } else {
             }
         },

         close: function(){
             this.showAddUs = false;
             this.showUs = false;
             this.showEditUs=false;
             this.showAddSprint = false;
             this.showEditSprint=false;
             this.fetch();
             },

         update: function(){
             this.showEditUs=false;
             this.showEditSprint=false;
             this.fetch();
             },

         getIndex: function(item){
             return this.ids.indexOf(item);
         },
         getIndexSprint: function(item){
             return this.SprintsIds.indexOf(item);
         },
         openus: function(item){
             return '/userstory/'+item.id+'/'+this.getIndex(item.id);
        },

     }

     }

</script>
<style>
.truncate {
  width: 100%;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.panel-container {
    padding-right: 0 !important;
    padding-left: 0 !important;
    height:35px;
}
.abc{
    height:35px;
      display:table-cell !important;
      vertical-align:middle;
}
.soflow {
   -webkit-appearance: button;
   -webkit-border-radius: 2px;
   -webkit-box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
   -webkit-padding-end: 20px;
   -webkit-padding-start: 2px;
   -webkit-user-select: none;
   background-image: url(http://i62.tinypic.com/15xvbd5.png), -webkit-linear-gradient(#FAFAFA, #F4F4F4 40%, #E5E5E5);
   background-position: 97% center;
   background-repeat: no-repeat;
   border: 1px solid #AAA;
   color: #555;
   font-size: inherit;
   margin: 5px;
   overflow: hidden;
   padding: 5px 10px;
   text-overflow: ellipsis;
   white-space: nowrap;
   width: 300px;
}
 .mg{
     margin: 3px;
 }

 </style>
