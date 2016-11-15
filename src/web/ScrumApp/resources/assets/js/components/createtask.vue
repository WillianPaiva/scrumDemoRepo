<template>
    <div class="container">
        <modal title="Create New Task"
               :show.sync="boolShow"
               :okText="'Create'"
               :okClass="'btn btn-success'"
               :cancelClass="'btn btn-danger'"
               @ok="createTask"
               @cancel="cancel">


            <form class="form-horizontal" >
                <div class="form-group">
                    <label for="name"  class="col-md-4 control-label">Name</label>
                    <div class="col-md-6">
                        <input id="name" v-model="taskRequest.name" type="text" class="form-control" name="name" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="description"  class="col-md-4 control-label">description</label>
                    <div class="col-md-6">
                        <textarea id="description" v-model="taskRequest.description"
                                  type="text" class="form-control" name="description" required /></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cost"  class="col-md-4 control-label">cost</label>
                    <div class="col-md-2">
                        <input id="cost" v-model="taskRequest.cost"
                               type="number"  class="form-control" name="cost" min="1" step="0.25" required/>
                    </div>
                    <label for="priority"  class="col-md-2 control-label">priority</label>
                    <div class="col-md-2">
                        <input id="priority" v-model="taskRequest.priority"
                               type="number" class="form-control" name="priority" min="1" required />
                    </div>
                </div>
                </div>
            </form>
        </modal>
    </div>
</template>

<script>
 export default{
     data(){
         return{
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
                 user_story_id: '',
                }
         }
     },
     props:['id', 'boolShow'],

     methods:{
         createTask: function(){
             this.taskRequest.user_story_id = this.id;
             this.$http.post('/api/task/add', this.taskRequest);
             this.taskRequest = {
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
                 user_story_id: '',
             }
             this.boolShow = false;
             this.$emit('ok');
         },
         cancel: function(){
             this.boolShow = false;
             this.$emit('cancel');
         },
     }

 }
</script>
