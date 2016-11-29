<script>
import { Line } from 'vue-chartjs'

 export default Line.extend({
     data(){
         return {
             labels: [],
             expected: [40,30,10,0],
             done: [40,35,5,],
         }
     },

     props:['id','sprints', 'us'],
     watch:{
         labels: function(){
             this.plot();
         },
         sprints: function(){
             this.genLabels();
             this.plot();
         },
         us: function(){
             this.genLabels();
             this.plot();
         }
     },
     mounted () {
         this.genLabels();
         this.plot();
     },
     methods:{
         plot: function(){
             this.renderChart({
                 labels: this.labels,
                 datasets: [
                     {
                         label: 'Expected',
                         fill: false,
                         borderColor: '#faa123',
                         backgroundColor: '#faa123',
                         data: this.expected,
                     },
                     {
                         label: 'Done',
                         fill: false,
                         borderColor: '#5bc0de',
                         backgroundColor: '#5bc0de',
                         data: this.done,
                     }
                 ]
             });
         },
         genLabels: function(){
             this.labels = [''];
             for(var i =0; i < this.sprints.length; i++){
                 this.labels.push('Sprint#'+i);
             }
             var total = 0;

             for(var i =0; i < this.us.length; i++){
                 total += parseInt(this.us[i].effort);
             }
             this.expected = [total]; 
             this.done = [total]; 
             var leftexpec = total;
             for(var i =0; i < this.sprints.length; i++){
                 var temp = 0;
                 for(var x =0; x < this.us.length; x++){
                     if(this.us[x].sprint_id == this.sprints[i].id){
                         temp += parseInt(this.us[x].effort);
                     }
                 }
                 leftexpec -= temp;
                 this.expected.push(leftexpec);
             }
             var leftdone = total;
             for(var i =0; i < this.sprints.length; i++){
                 var temp = 0;
                 var begindate = new Date(this.sprints[i].date_begin);
                 var findate = new Date(this.sprints[i].date_estimated);
                 var today = new Date();
                 if(today >= begindate){
                     for(var x =0; x < this.us.length; x++){
                         if(this.us[x].date_finished != null){
                             var usdate = new Date(this.us[x].date_finished);
                             if(usdate <= findate && usdate >= begindate){
                                 temp += parseInt(this.us[x].effort);
                             }
                         }
                     }
                     leftdone -= temp;
                     this.done.push(leftdone);
                     }
             }

         }

     }

 })
</script>
<style>
 canvas{
        width: 100% !important;
        max-width: 800px;
        height: auto !important;
     margin-left: auto;
     margin-right: auto;
     display: block;
    }
</style>
