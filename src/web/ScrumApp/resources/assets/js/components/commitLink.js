 export default{
     data(){
         return{
             commitLinkRequest:{
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
     props:['id','boolShow'],
 watch:{
      boolShow:function(){
           this.update();
      }
},
     methods:{
          update: function (){
               console.log('/api/taskEdit/'+this.id);
               this.$http.get('/api/taskEdit/'+this.id).then(function(response){
                    this.commitLinkRequest=response.data;
               });
            console.log('hello --->'+this.commitLinkRequest.id);

          },
         editTask: function(){
             this.commitLinkRequest.user_story_id = this.id;
             this.$http.post('/api/task/edit', this.commitLinkRequest);
             this.commitLinkRequest = {
                 id: '',
                 name: '',
                 description: '',
                 status: '',
                 commit: '',
                 cost: '',
                 priority: '',
                 date_begin: '',
                 date_estimated: '',
                 date_finished: '',
                 user_story_id: ''
             };
             this.boolShow = false;
             this.$emit('ok');
         },
         cancel: function(){
             this.boolShow = false;
             this.$emit('cancel');
         }
     }

 };
