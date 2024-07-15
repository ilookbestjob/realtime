
<script setup lang="ts">

const props=defineProps<{
    
    name?: string
    
    
  }>() 





 
 
  </script>
  

<template>

<div class="tab" >{{name}}</div>

</template>


<style scope lang="scss">
$background:#fafafa;
.tab{
display: inline;
background: $background;
margin:10px 5px;
height:20px;
font-family:tahoma;
padding:3px 6px;
cursor:pointer;
border-radius: 3px;
box-shadow: 0px 0px 3px 2px rgba(0,0,0,0.07);

}
.tab:hover{
  background: darken($background,10);
}
.selected{

  background:forestgreen;
  color:#fff
}

</style>