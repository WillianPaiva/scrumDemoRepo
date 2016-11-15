<template>
        <div class="container">
            <modal title="Create New Project"
                   :show.sync="boolShow"
                   :okText="'Create'"
                   :okClass="'btn btn-success'"
                   :cancelClass="'btn btn-danger'"
                   @ok="createUs"
                   @cancel="cancel">


                <form class="form-horizontal" >
                    <div class="form-group">
                        <label for="name"  class="col-md-4 control-label">description</label>
                        <div class="col-md-6">
                            <textarea id="name" v-model="userStoryRequest.description"
                                      type="text" class="form-control" name="name" required /></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name"  class="col-md-4 control-label">effort</label>
                        <div class="col-md-2">
                            <select class="form-control" v-model="userStoryRequest.effort" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="5">5</option>
                                <option value="8">8</option>
                                <option value="13">13</option>
                                <option value="21">21</option>
                                <option value="34">34</option>
                                <option value="55">55</option>
                                <option value="89">89</option>
                            </select>
                        </div>
                        <label for="name"  class="col-md-2 control-label">priority</label>
                        <div class="col-md-2">
                            <input id="name" v-model="userStoryRequest.priority"
                                   type="number" class="form-control" name="name" required />
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
     }
 },
     methods:{
         createUs: function(){
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
