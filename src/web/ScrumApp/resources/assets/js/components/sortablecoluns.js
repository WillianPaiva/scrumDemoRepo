import Sortable from 'sortablejs';
export default{
    data(){
        return {
            colunms:[],
            modalShow: false,
            sprintId:1,
            colname:'',
            check:[],
            ids:[]
        };
    },
    props:['sprintid'],
    mounted(){
        this.sortable();
        this.fetch();
    },
    methods:{

        fetch: function(){
            this.$http.get('/api/kanban/getus/'+this.sprintid).then(function(response){
                this.ids= [];
                 for(var i =0; i < response.data.length; i++){
                     this.ids.push(parseInt(response.data[i].id));
                     }
            });
            this.$http.get('/api/layout/'+this.sprintid).then(function(response){
                this.colunms = response.data;
            });

        },
        sortable: function () {
            var that = this;
            Sortable.create(this.$el.firstChild, {
                draggable: 'li',
                animation: 100,
                onUpdate: function(e) {
                    that.$http.post('/api/layout_pos/'+that.colunms[e.oldIndex].id+'/'+e.newIndex).then(function(){
                        var i;
                        if(e.oldIndex < e.newIndex){
                            for (i = (e.oldIndex+1); i <= e.newIndex; i++) {
                                that.$http.post('/api/layout_pos/'+that.colunms[i].id+'/'+(parseInt(that.colunms[i].position)-1));
                            }
                        }
                        if(e.oldIndex > e.newIndex){
                            for (i = e.newIndex; i < e.oldIndex; i++) {
                                that.$http.post('/api/layout_pos/'+that.colunms[i].id+'/'+(parseInt(that.colunms[i].position)+1));
                            }
                        }
                    });

                }
            });
        },
        addColunm: function(){
            if(this.colname != ''){
                var request = {};
                request.name = this.colname;
                request.position = this.colunms.length;
                request.sprint_id = this.sprintid;
                console.log(request);
                this.$http.post('/api/layout/add', request);
            }
            this.modalShow = false;
            this.colname = '';
            this.fetch();
        },
        deleteCol: function (colname){
            this.$http.get('/api/task/'+colname+'/'+this.sprintid).then(function(response){
                this.check=response.data;
                if (this.check==''){
                    var r = confirm("do you really want to delete  this column ?");
                    if (r == true) {
                        this.$http.post('/api/layout/delete/'+this.sprintid+'/'+colname).then(value => {this.fetch();});
                    }
                }
                else {
                    alert("column not empty");
                }
            });
            console.log('trying to delete this column-->'+colname);
            console.log('the check is --> '+this.check);
            console.log('the sprint id   -->'+this.sprintid);


        }

    }
};
