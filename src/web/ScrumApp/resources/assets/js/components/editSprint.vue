<template>
<div class="container">
            <modal title="Edit Sprint"
                   :show.sync="boolShow"
                   :okText="'Edit'"
                   :okClass="'btn btn-success'"
                   :cancelClass="'btn btn-danger'"
                   @ok="editSprint"
                   @cancel="cancel">


                <form class="form-horizontal" >
                    <div class="form-group">
                        <label for="name"  class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input id="name" v-model="editSprintRequest.name"
                                            type="text" class="form-control" name="name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date"  class="col-md-4 control-label">Date Beguin</label>
                        <div class="col-md-6">
                            <input id="date_begin" v-model="editSprintRequest.date_begin"
                                            type="date" class="form-control" name="date_begin" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date"  class="col-md-4 control-label">Date Estimated</label>
                        <div class="col-md-6">
                            <input id="date_estimated" v-model="editSprintRequest.date_estimated"
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
 watch:{
      boolShow:function(){
           this.update();
      }
},
 data(){
     return {
         editSprintRequest:{
                 id: '',
                 name: '',
                 date_begin: '',
                 date_estimated: '',
                 project_id: '',

         }
     }
 },
     methods:{
          update: function (){
               console.log('hello --->'+this.id);
               this.$http.get('/api/sprintEdit/'+this.id).then(function(response){
                    this.editSprintRequest=response.data;
               });
          },
         editSprint: function(){
              this.$http.post('/api/sprint/edit',this.editSprintRequest);
              this.boolShow=false;
              this.$emit('ok');

         },
         cancel: function(){
             this.boolShow = false;
             this.$emit('close');
         },
     }
     }
</script>
