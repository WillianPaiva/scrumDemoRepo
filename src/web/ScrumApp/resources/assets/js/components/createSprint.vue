<template>
<div class="container">
            <modal title="Create New Sprint"
                   :show.sync="boolShow"
                   :okText="'Create'"
                   :okClass="'btn btn-success'"
                   :cancelClass="'btn btn-danger'"
                   @ok="createSprint"
                   @cancel="cancel">


                <form class="form-horizontal" >
                    <div class="form-group">
                        <label for="name"  class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input id="name" v-model="sprintRequest.name" 
                                            type="text" class="form-control" name="name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date"  class="col-md-4 control-label">Date Beguin</label>
                        <div class="col-md-6">
                            <input id="date_begin" v-model="sprintRequest.date_begin" 
                                            type="date" class="form-control" name="date_begin" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date"  class="col-md-4 control-label">Date Estimated</label>
                        <div class="col-md-6">
                            <input id="date_estimated" v-model="sprintRequest.date_estimated" 
                                            type="date" class="form-control" name="date_estimated" required />
                        </div>
                    </div>
                </form>
            </modal>
        </div>
</template>
<script>
 export default{
 props: ['boolShow', 'id'],
 data(){
     return {
         sprintRequest:{
                 id: '',
                 name: '',
                 date_begin: '',
                 date_estimated: '',
                 project_id: '',

         }
     }
 },
     methods:{
         createSprint: function(){
             this.sprintRequest.project_id = this.id;
             this.$http.post('/api/sprint/add', this.sprintRequest);
             this.sprintRequest = {
                 id: '',
                 name: '',
                 date_begin: '',
                 date_estimated: '',    
                 project_id: '',            
             }

             this.boolShow = false;
             this.$emit('close');
         },
         cancel: function(){
             this.boolShow = false;
             this.$emit('close');
         },
     }
     }
</script>
