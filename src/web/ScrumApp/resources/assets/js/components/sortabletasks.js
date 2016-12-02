import Sortable from 'sortablejs';
export default{
    props:['sprintid','status','ids'],
    data(){
        return{
            tasks:[],
            boolCommitShow:false
        };
    },
    mounted(){
        this.fetch();
        this.sortable();
    },
    watch:{
        boolCommitShow: function(){
            console.log('bool ->'+this.boolCommitShow);
        }
    },
    methods:{
      fetch: function(){
          this.$http.get('/api/get_tasks/'+this.sprintid+'/'+this.status).then(function(response){
              this.tasks = response.data;
          });
      },
        getUsIndex: function (item) {
            return this.ids.indexOf(parseInt(item));
        },
        sortable: function () {
            var that = this;
            Sortable.create(this.$el.firstChild, {
                draggable: 'li',
                group: "tasks",
                animation: 100,
                sort: false,
                onAdd: function (evt) {
                    /* var itemEl = evt.item;*/
                    var taskid = this.el.firstChild.getAttribute("taskid");
                    that.$http.post('/api/updatetask/'+taskid+'/'+that.status).then(function (response){
                        if (this.status=='DONE'){
                            console.log('this -->'+this.status);
                            console.log('that-->'+that.status);
                            this.boolTrue();
                        }

                    });
                    that.$http.post('/api/updateus/'+that.sprintid);
                        //that.boolCommitShow=false;
                    /* evt.from;*/
                    // + indexes from onEnd
                },
                onUpdate:function(e){


                },
                onRemove: function (/**Event*/evt) {
                    console.log("this is the removal-->"+that.status);
                },
            });
        },
        boolTrue : function (){
        this.boolCommitShow=true;
        console.log('-boolTrue');
        },
        addCommit: function (){
            console.log('addCommit');
        this.boolCommitShow=false;
        },
        isEmpty: function(){
            return !(this.tasks.lenght > 0);
        },
        cancel:function (){
            console.log('cancel called');
            this.boolCommitShow=false;
        },
        getUsId: function(item){
            return this.array[this.ids.indexOf(item)];
        }
    }
};
