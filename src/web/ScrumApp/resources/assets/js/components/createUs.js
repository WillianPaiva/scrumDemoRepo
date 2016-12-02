
export default{props: ['boolShow', 'id'],
               data(){
                   return {
                       missing: false,
                       userStoryRequest:{
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
               methods:{
                   createUs: function(){
                       if(
                           this.userStoryRequest.description != ''
                       ){
                           this.userStoryRequest.project_id = this.id;
                           this.$http.post('/api/us/add', this.userStoryRequest);

                           this.userStoryRequest = {
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
                           };
                           this.boolShow = false;
                           this.$emit('close');
                       }else{
                           this.missing = true;
                       }
                   },
                   cancel: function(){
                       this.boolShow = false;
                       this.$emit('close');
                   },
               }
              };
