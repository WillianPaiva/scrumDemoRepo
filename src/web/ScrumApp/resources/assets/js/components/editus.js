
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
        };
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
};
