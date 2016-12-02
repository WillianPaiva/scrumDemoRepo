export default{
    data(){
        return{
            sprints:[],
            us:[]
        };
    },
    props: ['id'],
    mounted(){
        this.fetch();
    },
    methods:{
        fetch: function(){
            this.$http.get('/api/sprint/'+this.id).then(function(response){
                this.sprints = response.data;
            });
            this.$http.get('/api/backlog/'+this.id+'/created_at').then(function(response){
                this.us= response.data;
                console.log(this.us);
            });
        }

    }
};
