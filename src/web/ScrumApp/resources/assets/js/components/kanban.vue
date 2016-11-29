<template>
    <div>
        <div class="DocumentList">
            <sortablecoluns :sprintid="sprintid"></sortablecoluns>
        </div>
    </div>
</template>
<script>
 export default{
     props:['sprintid'],
 }
</script>
<style>
 .DocumentList
 {
     /* overflow-x:hidden; */
     /* overflow-y:hidden; */
     height:100%;
     width:100%;
     padding: 0 15px;
 }

 .DocumentItem
 {
     padding:0;
     height:100%;
     width:300px;
 }

 .list-inline {
     white-space:nowrap;
 }

</style>
