<template>
    <div>
    <ul class="list-group">
        <li class="list-group-item clearfix"
            v-for="task in tasks" :taskid="task.id">{{task.name}}</li>
    </ul>
    </div>
</template>
<script>
 import Sortable from 'sortablejs'
 export default{
     props:['sprintid','status'],
     data(){
         return{
             tasks:[],
         }
     },
     mounted(){
         this.fetch();
         this.sortable();
     },
     methods:{
         fetch: function(){
             this.$http.get('/api/get_tasks/'+this.sprintid+'/'+this.status).then(function(response){
                 this.tasks = response.data;
             });
         },
         sortable: function () {
             var that = this;
             Sortable.create(this.$el.firstChild, {
                 draggable: 'li',
                 group: "tasks",
                 animation: 100,
                 sort: false,
                 onAdd: function (evt) {
                     /* var itemEl = evt.item;*/
                     var taskid = this.el.firstChild.getAttribute("taskid");
                     that.$http.post('/api/updatetask/'+taskid+'/'+that.status)

                     /* evt.from;*/ 
                     // + indexes from onEnd
                 },
             });
         },
         isEmpty: function(){
             return !(this.tasks.lenght > 0);
         }
     }
 }
</script>
<style>
 .list-group{
     min-height: 50px;
 }
</style>
