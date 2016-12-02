
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
                project_id: ''

            }
        };
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
        }
    }
};
