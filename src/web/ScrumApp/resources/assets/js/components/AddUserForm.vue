<template>
    <div>
        <div class="well">
            <ul class="list-group">
                <li class="list-group-item clearfix" style="" v-for="item in membs">
                    <span style="position:absolute; top:30%;"> {{ item.name }}</span>
                    <span class="pull-right button-group">
                        <button type="button" v-on:click="deleteMember(item.id)"
                                class="btn btn-danger"><span class="fa fa-trash"></span></button>
                    </span>
                </li>
            </ul>
        </div>
        <label for="user" class="col-md-4 control-label">User</label>
        <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-spinner fa-spin" v-if="loading"></i>
                <template v-else>
                    <i class="fa fa-search" v-show="isEmpty"></i>
                    <i class="fa fa-times" v-show="isDirty" @click="reset"></i>
                </template>
            </span>
            <input type="text"
                   class="form-control"
                   name="user"
                   placeholder="Search user"
                   autocomplete="on"
                   v-model="query"
                   @keydown.down="down"
                   @keydown.up="up"
                   @keydown.enter="hit"
                   @keydown.esc="reset"
                   @blur="reset"
                   @input="update"/>

        </div><!-- /input-group -->
            <ul v-show="hasItems" class="autocomplist">
                <li v-for="(item,index) in items" :class="activeClass(index)"
                    @mousedown="hit" @mousemove="setActive(index)">
                    <span class="name" v-text="item.name"></span>
                </li>
            </ul>
    </div>
    </div>
</template>

<script>
import VueTypeahead from 'vue-typeahead'

export default {
  extends: VueTypeahead, // vue@1.0.22+
  // mixins: [VueTypeahead], // vue@1.0.21-
     props: ['pid','membs'],
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
    }
  },

    mounted() {
        this.pullData();
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
      return data
    }
  }
}
</script>
<style scoped>
.autocomplist {
  position: absolute;
  padding: 0;
  margin-top: 8px;
  min-width: 100%;
  background-color: #fff;
  list-style: none;
  border-radius: 4px;
  box-shadow: 0 0 10px rgba(0,0,0, 0.25);
  z-index: 1000;
}
.name  {
  padding: 10px 16px;
  border-bottom: 1px solid #ccc;
  cursor: pointer;
}
.active {
  background-color: #3aa373;
}
.active span {
  color: white;
}
.name {
  font-weight: 700;
  font-size: 18px;
  display: block;
  color: #2c3e50;
}
.screen-name {
  font-style: italic;
}
</style>
