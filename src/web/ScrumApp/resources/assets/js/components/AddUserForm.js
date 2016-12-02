import VueTypeahead from 'vue-typeahead';

export default {
    extends: VueTypeahead, // vue@1.0.22+
    // mixins: [VueTypeahead], // vue@1.0.21-
    props: ['pid','membs'],
    watch: {
        pid: function(){
            this.pullData();
        }
    },
    data () {
        return {
            // The source url
            // (required)
            src: '/api/userlist',

            // The data that would be sent by request
            // (optional)
            data: {},

            // Limit the number of items which is shown at the list
            // (optional)
            limit: 5,

            // The minimum character length needed before triggering
            // (optional)
            minChars: 3,

            // Highlight the first item in the list
            // (optional)
            selectFirst: false,

            // Override the default value (`q`) of query parameter name
            // Use a falsy value for RESTful query
            // (optional)
            queryParamName: 'q'
        };
    },

    methods: {
        // The callback function which is triggered when the user hits on an item
        // (required)
        onHit (item) {
            this.$http.post('/api/adduser/'+item.id+'/'+this.pid);
            this.pullData();
        },
        pullData: function(){
            this.$http.get('/api/members/'+this.pid).then(function (response) {
                this.membs = response.data;
            });
        },
        deleteMember: function(id){
            this.$http.post('/api/members/delete/'+this.pid+'/'+id);
            this.pullData();
        },
        // The callback function which is triggered when the response data are received
        // (optional)
        prepareResponseData (data) {
            return data;
        }
    }
}
