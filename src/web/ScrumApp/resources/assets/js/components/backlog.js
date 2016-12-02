
export default{
    data(){
        return{
            order: 'created_at',
            orderSprint: 'created_at',
            project:{},
            idTosend:1,
            SprintId:1,
            userstory:[],
            ids:[],
            showAddUs: false,
            showEditUs:false,
            showAddSprint: false,
            showEditSprint:false,
            SprintsIds:[],
            sprint:[],
        };
    },
    watch: {
        order: function(){
            this.fetch();
        },
        orderSprint : function(){
            this.fetch();
        }
    },
    props:['id'],
    mounted(){
        this.fetch();
    },
    methods:{
        fetch: function(){

            this.$http.get('/api/backlog/'+this.id+'/created_at').then(function(response){

                this.ids= [];
                for(var i =0; i < response.data.length; i++){
                    this.ids.push(response.data[i].id);
                }

            });
            this.$http.get('/api/sprint/'+this.id).then(function(response){
                this.sprint = response.data;
                this.SprintsIds= [];
                for(var i =0; i < response.data.length; i++){
                    this.SprintsIds.push(response.data[i].id);
                }
            });
            this.$http.get('/api/backlog/'+this.id+'/'+this.order).then(function(response){
                this.userstory = response.data;
            });
            this.$http.get('/api/sprint/'+this.id+'/'+this.orderSprint).then(function(response){
                this.sprint = response.data;
            });
            this.$http.get('/api/project/'+this.id).then(function(response){
                this.project = response.data;
            });

        },
        isEmpty: function(){
            return !(this.userstory.length > 0);
        },
        deleteUs: function(item){

            var r = confirm("Do you really want to delete this user story ?");
            if (r == true) {
                this.$http.post('/api/us/delete/'+item.id);
                this.fetch();
            } else {
            }

        },
        getUs: function (item){
            this.idTosend=item.id;
            this.showEditUs=true;
        },
        getSprint: function (item){
            this.SprintId=item.id;
            this.showEditSprint=true;
        },
        openus: function(item){
            return '/userstory/'+item.id+'/'+this.getIndex(item.id);
        },
        SprintisEmpty: function(){
            return !(this.sprint.length > 0);
        },

        deleteSprint: function(item){
            var r = confirm("Do you really want to delete this sprint ?");
            if (r == true) {
                this.$http.post('/api/sprint/delete/'+item.id);
                this.fetch();
            } else {
            }
        },

        close: function(){
            this.showAddUs = false;
            this.showUs = false;
            this.showEditUs=false;
            this.showAddSprint = false;
            this.showEditSprint=false;
            this.fetch();
        },

        update: function(){
            this.showEditUs=false;
            this.showEditSprint=false;
            this.fetch();
        },

        getIndex: function(item){
            return this.ids.indexOf(item);
        },
        getIndexSprint: function(item){
            return this.SprintsIds.indexOf(item);
        },
        getKanbanLink: function(item){
            return '/kanban/'+item;
        },
        setSprint: function(usid,sprintid){
            this.$http.post('/api/userstory/setsprint/'+usid+'/'+sprintid);
            this.fetch();
        },
        checkDate: function(item){
            var begin = new Date(item.date_begin);
            var end = new Date(item.date_estimated);
            var today = new Date();
            if(begin <= today && today <= end){
                return " -moz-box-shadow: inset 0 0 15px #faa123; -webkit-box-shadow: inset 0 0 15px #faa123; box-shadow:inset 0 0 15px #faa123; ";
            }else{
                return "";
            }
        },
        checkUsDone : function(item){
            var status = item.status;
            if(item.date_finished != null || status == "DONE"){
                return "background-color :rgb(119,136,153);";
            }else{
                return "";
            }
        },
        getStatsLink: function(){
            return '/stats/'+this.id;
        }

    }

};
