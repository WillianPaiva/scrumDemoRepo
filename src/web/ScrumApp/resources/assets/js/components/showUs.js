
 export default{
     data(){
         return{
             tasks:[],
             usid:'',
             showAddTask:false,
             showEditTask:false,
             showCommit:false,
             taskCommitId:1,
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
         };
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

        getTask: function (item){
            this.TaskId=item.id;
            this.showEditTask=true;
        },
        getCommit: function (item){
          this.taskCommitId= item.id;
          this.showCommit=true;
        },
         isEmpty: function(){
             return !(this.tasks.length > 0);
         },
         close: function(){
             this.showAddTask = false;
             this.showEditTask = false,
             this.showCommit=false,
             this.getUS();
         },
        checkUsDone : function(){
            if(this.us.date_finished != null || this.us.status == "DONE"){
                return "background-color :rgb(119,136,153);";
            }else{
                return "";
            }
         },
         disabledButton : function(){
            if(this.us.date_finished != null || this.us.status == "DONE"){
                return true;
            } else {
                return false;
            }
         },
         deleteTask: function(item){

             var r = confirm("Do you really want to delete this task ?");
             if (r == true) {
                 this.$http.post('/api/task/delete/'+item.id);
                 this.getUS();
             } else {
             }
         }
     }

 };
