
<script setup lang="ts">
import tab from '../components/tab.vue'
import {inject,provide} from 'vue'

const model = defineModel()

let servers:any=inject("servertabs")
const setTab:any=inject("setTab")

function select(i:number){

    model.value=i;

}

  </script>

<template>
<span>Сервер</span>
<tab v-for="(server,index) in servers"  :class="{selected:index==model}" v-bind="server" :index="index"  @click="select(index)" />

</template>



<style scope lang="scss">

span{

  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin-right: 10px;
}


</style>