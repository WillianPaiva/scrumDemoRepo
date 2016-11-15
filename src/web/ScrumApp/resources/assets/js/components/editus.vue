<template>
    <div class="container">
        <modal title="Edit User Story"
        :show.sync="boolShow"
        :okText="'Edit'"
        :okClass="'btn btn-success'"
        :cancelClass="'btn btn-danger'"
        @ok="editUs"
        @cancel="cancel">


        <form class="form-horizontal" >
            <div class="form-group">
                <label for="name"  class="col-md-4 control-label">description</label>
                <div class="col-md-6">
                    <textarea id="name" v-model="editUserStoryRequest.description"
                    type="text" class="form-control" name="name" required /></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="name"  class="col-md-4 control-label">effort</label>
                <div class="col-md-2">
                    <select class="form-control" v-model="editUserStoryRequest.effort" required>
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
                    <input id="name" v-model="editUserStoryRequest.priority"
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
    watch: {
        boolShow: function(){
            this.update();
        }
    },
    data(){
        return {
            userstory:[],
            editUserStoryRequest:{
                id: '',
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
        update: function(){
            this.$http.get('/api/us/'+this.id).then(function(response){
                this.editUserStoryRequest=response.data;
            });

        },
        editUs: function(){
            this.$http.post('/api/us/edit',this.editUserStoryRequest);
            this.boolShow = false;
            this.$emit('ok');

        },

        cancel: function(){
            this.boolShow = false;
            this.$emit('close');
        },
    }
}
</script>
