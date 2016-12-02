
export default{
    data: function(){
        return {
            addNewRequest: {
                name: '',
                user_id: '',
                description: '',
                language: '',
                version: ''
            },
            missing: false,
            edit: {
                name: '',
                user_id: '',
                description: '',
                language: '',
                version: '',
                id: ''
            },
            modalShowProject: false,
            modalShowEdit: false,
            owns:[],
            member:[],
            proj:{
                name: '',
                id: '',
                user_id: '',
                description: '',
                language: '',
                version: '',
                username: ''
            },
            message: "",
            modalShow: false
        };
    },
    props:['user'],

    mounted(){
        this.populate();
    },

    methods:{
        hasOwns: function(){
            return (this.owns.length > 0);
        },
        hasMember: function() {
            return (this.member.length > 0);
        },
        populate: function(){
            this.$http.get('/api/getownproject/'+this.user).then(function(response){
                this.owns = response.data;
            });
            this.$http.get('/api/getmemberproject/'+this.user).then(function(response){
                this.member = response.data;
            });
        },
        deleteProject: function(item){
            var r = confirm("Do you really want to delete "+item.name+" ?");
            if (r == true) {
                this.$http.post('/api/project/delete/'+item.id);
                this.update();
            } else {
            }
        },
        update: function(){
            this.$http.get('/api/getownproject/'+this.user+'/'+this.message).then(function(response){
                this.owns = response.data;
            });
            this.$http.get('/api/getmemberproject/'+this.user+'/'+this.message).then(function(response){
                this.member = response.data;
            });
        },
        getLinkOwns: function(item){
            this.proj.name = this.owns[item].name;
            this.proj.id = this.owns[item].id;
            this.proj.description = this.owns[item].description;
            this.proj.version = this.owns[item].version;
            this.proj.language = this.owns[item].language;
            this.proj.user_id = this.owns[item].user_id;
            this.proj.username = this.owns[item].username;
            this.modalShowProject= true;
        },
        getLinkMember: function(item){
            this.proj.name = this.member[item].name;
            this.proj.id = this.member[item].id;
            this.proj.description = this.member[item].description;
            this.proj.version = this.member[item].version;
            this.proj.language = this.member[item].language;
            this.proj.user_id = this.member[item].user_id;
            this.proj.username = this.member[item].username;
            this.modalShowProject= true;
        },
        getEdit: function(item){
            this.edit.name = this.owns[item].name;
            this.edit.id = this.owns[item].id;
            this.edit.description = this.owns[item].description;
            this.edit.version = this.owns[item].version;
            this.edit.language = this.owns[item].language;
            this.edit.user_id = this.owns[item].user_id;
            this.modalShowEdit= true;
        },

        addproj: function(){
            this.addNewRequest.user_id=this.user;
            if(
                this.addNewRequest.name != '' &&
                    this.addNewRequest.description != '' &&
                    this.addNewRequest.language != '' &&
                    this.addNewRequest.version != ''
            ){
                console.log("test----->"+this.addNewRequest.name);
                this.$http.post('/api/project/add',this.addNewRequest).then(function(response){
                    /* console.log(response);*/
                });
                this.addNewRequest = {
                    name: '',
                    user_id: '',
                    description: '',
                    language: '',
                    version: ''
                };
                this.modalShow = false;
                this.update();
            }else{
                this.missing = true;
            }
        },
        editDetails: function(){
            this.$http.post('/api/project/edit',this.edit);
            this.modalShowEdit = false;
            this.update();
        },
        cancel: function(){
            this.modalShow = false;
            this.modalShowEdit= false;
        },
        closeDetails: function(){
            this.modalShowProject= false;
            this.update();
        },
        getBacklogLink: function(item){
            return '/backlog/'+item.id;
        }
    }
};
