<script setup lang="ts">
import alert from "../assets/alert.png";
import bug from "../assets/bug.png";
import { computed, ref, inject } from "vue";

const props = defineProps<{
  phpserver?: string;
  name?: string;
  data: string;
  startDate?: string;
  row_id?: number;
  active?: boolean | any;
  del?: number;
  index: number;
}>();

const convertDate: any = inject("convertDate");
const  prepareDate: any = inject("prepareDate");

const endDate = computed(() => (props.data ? convertDate(props.data) : false));
const stDate = computed(() =>
  props.startDate ? convertDate(props.startDate) : false
);

let displaydata = computed(() => {
  if (props.data) {
    let dateParts: number | any = props.data.split("-");

    if (dateParts.length > 2) {
      return (
        dateParts[2].substr(0, 2) +
        " " +
        [
          "Янв",
          "Фев",
          "Мар",
          "Апр",
          "Май",
          "Июн",
          "Июл",
          "Авг",
          "Сен",
          "Окт",
          "Ноя",
          "Дек",
        ][dateParts[1] * 1] +
        " '" +
        dateParts[0].substr(2, 2)
      );
    }
  }
  return props.data;
});





//let displaydata=computed(()=>prepareDate(props.data))

let actual: any = inject("actual");
let working: any = inject("working");
let delay: any = inject("delay");
let errors: any = inject("errors");

const visible = computed(() => {
  if (props.del == 1) return false;

  let result: boolean = true;
//////фильтр актуальные
  if (actual.value) {
    if (props.data) {
      let dateParts: number | any = props.data.split("-");
      const currentDate = new Date();

      result= dateParts[0] >= currentDate.getFullYear() - 1 && dateParts[1] >= currentDate.getMonth()
      
    }
  }


/////фильтр работающие

if (working.value){
result=false;
if (stDate)
{

  if (stDate>endDate) result=true

}


}


return result

});



</script>

<template>
  <div
  @click="$emit('displayLogs',props.index)"
    v-if="visible"
    class="alertitem"
    :class="{ alert: Math.random() > 0.5, working: Math.random() > 0.5 }"
  >
    <div class="server">
      <img src="../assets/server.png" />{{ phpserver ? phpserver : "Неизвестен" }}
    </div>
    <div class="name">#{{ row_id }}&nbsp;{{ name }}</div>

    <footer>
      <div class="last">{{ displaydata }}</div>
      <div class="errors">
        <img v-if="Math.random() > 0.5" :src="alert" />
        </div>
 

      
    </footer>
  </div>
</template>

<style scope lang="scss">

.alertitem {
  background: $bgcolor;
  width: 300px;
  height: auto;
  min-height: 150px;
  margin: 10px;
  border: solid 1px darken($bgcolor, 10);
  font-family: tahoma;
  padding: 7px;
  display: grid;
  grid-template-columns: 1fr;
  grid-template-rows: 40px 40px;
  box-shadow: 0px 0px 7px 6px rgba(0, 0, 0, 0.07);
  cursor: pointer;

  .server {
    display: flex;
    align-items: center;

    img {
      height: 25px;
      width: auto;
      margin-right: 10px;
    }
  }

  .name {
  }

  .last {
    margin-right: 10px;
    justify-self: flex-start;
  }
  footer {
    width: 100%;
    display: grid;
    justify-content: flex-end;
    align-items: center;
    grid-template-columns: 1fr 40px auto;

    .debug {
      display: flex;
      justify-content: center;
      align-items: center;
      background:  $button;
      color:$buttontext;
      border-radius: 4px;
      padding: 3px 5px;


      img{
        height:25px;
        width:auto;
        margin-right:6px;

      }
    }


    .errors {
      img {
        height: 25px;
        width: auto;
      }
    }
  }
}

.alertitem:hover {
  background: darken($bgcolor, 2);
  border-right: solid 1px darken($bgcolor, 14);
  border-top: solid 1px darken($bgcolor, 14);
  border-bottom: solid 1px darken($bgcolor, 14);
}

.alert {
  border-left: 4px solid orange;
}

.working {
  border-left: 4px solid forestgreen;
}
</style>
