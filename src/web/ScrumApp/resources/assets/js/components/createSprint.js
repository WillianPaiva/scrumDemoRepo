 export default{
 props: ['boolShow', 'id'],
 data(){
     return {
         missing: false,
         sprintRequest:{
                 id: '',
                 name: '',
                 date_begin: '',
                 date_estimated: '',
                 project_id: ''

         }
     };
 },
     methods:{
         createSprint: function(){
             if(
                 this.sprintRequest.name != '' &&
                 this.sprintRequest.date_begin != '' &&
                 this.sprintRequest.date_estimated != '' 
             ){
                 this.sprintRequest.project_id = this.id;
                 this.$http.post('/api/sprint/add', this.sprintRequest);
                 this.sprintRequest = {
                     id: '',
                     name: '',
                     date_begin: '',
                     date_estimated: '',    
                     project_id: ''
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
         }
     }
 };
