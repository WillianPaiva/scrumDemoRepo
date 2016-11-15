<template>
    <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-0">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                            <label class="label label-warning" style="margin-right: 7px;">
                                US#{{nb}}
                            </label>

                            <label class="label label-success" style="margin-right: 7px;">
                                effort
                                <span class="badge">{{ us.effort }}</span> 
                            </label>

                            <label class="label label-info" style="margin-right: 7px;">
                                priority
                                <span class="badge">{{ us.priority }}</span> 
                            </label>

                                 <button class="btn btn-success pull-right" v-on:click="showAddTask = true">
                                     New Task
                                 </button>

                        </div>
                        <div class="panel-body">
                            <label class="col-md-4 control-label" for="">Description</label>
                        </br>
                            <div class="well">{{us.description}}</div>

                            <label class="col-md-4 control-label" for="">Tasks</label>
                        </br>
                        <div class="well" v-if="isEmpty()"><h3>no tasks</h3></div>

                        <div class="well">
                            <ul class="list-group">
                                <li class="list-group-item clearfix" v-for="(item , index) in tasks">
                                    {{item.name}}

                                        <div>
                                            <label class="label label-success">
                                                Cost
                                                <span class="badge">{{ item.cost }}</span>
                                            </label>
                                            <label class="label label-danger">
                                                Priority
                                                <span class="badge">{{ item.priority }}</span>
                                            </label>
                                            <label class="label label-success" v-if="item.date_begin != ''" style="margin-right: 7px;" >
                                                begin {{ item.date_begin }}
                                            </label>
                                            <label class="label label-info" v-if="item.date_estimated != ''" style="margin-right: 7px;" >
                                                expected {{ item.date_estimated }}
                                            </label>
                                            <label class="label label-warning" v-if="item.date_finished !=''" style="margin-right: 7px;" >
                                                finished {{ item.date_finished }}
                                            </label>

                                    <button class="btn btn-danger pull-right"
                                            v-on:click="deleteTask(item)">
                                        <span class="fa fa-trash"></span>
                                        </div>
                                    </button>
                                </li>
                            </ul>

                        </div>
                        </div>

                    </div>
                </div>
            </div>
            <createtask
                v-bind:boolShow="showAddTask"
                :id="id"
                @cancel="close"
                @ok="close"
            ></createtask>
    </div>
</template>
<script>
 export default{
     data(){
         return{
             tasks:[],
             usid:'',
             showAddTask:false,
             us:{
                 description: '',
                 status: '',
                 commit: '',
                 date_begin: '',
                 date_estimated: '',
                 date_finished: '',
                 effort: '1',
                 priority: '0',
                 project_id: '',
                 sprint_id: ''
             }
         }
     },
     props:['id','nb'],
     mounted(){
         this.getUS();
         },
     watch:{
         boolShow:function(){
             this.getUS();
         }
     },

     methods:{
         getUS: function(){
             this.$http.get('/api/us/'+this.id).then(function(response){
                 this.us = response.data;
             });
             this.$http.get('/api/tasks/'+this.id).then(function(response){
                 this.tasks = response.data; 
             });
         },
         isEmpty: function(){
             return !(this.tasks.length > 0)
         },
         close: function(){
             this.showAddTask = false;
             this.getUS();
         },
         deleteTask: function(item){

             var r = confirm("do you really want to delete  this task ?");
             if (r == true) {
                 this.$http.post('/api/task/delete/'+item.id);
                 this.getUS();
             } else {
             }
         }
     }

 }
</script>
