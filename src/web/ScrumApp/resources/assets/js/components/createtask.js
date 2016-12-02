
 export default{
     data(){
         return{
             missing: false,
             taskRequest:{
                 id: '',
                 name: '',
                 description: '',
                 status: '',
                 commit: '',
                 cost: '1',
                 priority: '1',
                 date_begin: '',
                 date_estimated: '',
                 date_finished: '',
                 user_story_id: ''
                }
         };
     },
     props:['id', 'boolShow'],

     methods:{
         createTask: function(){
             if(
                 this.taskRequest.name != '' &&
                 this.taskRequest.description != '' 
             ){
                 this.taskRequest.user_story_id = this.id;
                 this.$http.post('/api/task/add', this.taskRequest);
                 this.taskRequest = {
                     id: '',
                     name: '',
                     description: '',
                     status: '',
                     commit: '',
                     cost: '1',
                     priority: '1',
                     date_begin: '',
                     date_estimated: '',
                     date_finished: '',
                     user_story_id: ''
                 };
                 this.boolShow = false;
                 this.$emit('ok');
             }else{
                 this.missing = true;
             }
         },
         cancel: function(){
             this.boolShow = false;
             this.$emit('cancel');
         }
     }

 };
