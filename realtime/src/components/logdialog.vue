<script setup lang="ts">
import logitem from "../components/logitem.vue";
import { computed, inject, ref } from "vue";
</script>
<script lang="ts">
interface data {
  logs: Object;
  path: string;
  alerts: any;
  header: Object;
}

export default {
  name: "DiaLog",

  data() {
    return {
      logs: [""],
      path: "",
      alerts: {},
      header: ref(null),
    } as data;
  },

  created() {
    //this.getLog();
    //setInterval(this.getLog, 1000);
    let t = inject("");

    this.alerts = inject("alerts");
    this.header = computed(() => {
      console.log(this.alerts[0].name, this.$props.id);
      return "#" + this.alerts[this.id].row_id + " " + this.alerts[this.id].name;
    });
  },

  methods: {
    async getLog() {
      const res = await fetch("http://192.168.0.65/log.txt");
      this.logs = await res.json();
    },
  },

  props: ["path", "visible", "id"],
};
</script>

<template>
  <div class="log" v-if="visible">
    <div class="header">
      <div class="text">{{ header }}</div>
      <div class="close" @click="$emit('close')">&#9587;</div>
    </div>
    <div class="main"><logitem v-for="log in logs" v-bind="log" /></div>
    <div class="footer"></div>
  </div>
</template>

<style scope lang="scss">
@mixin radius($position) {
  border-#{$position}-left-radius: $radius;
  border-#{$position}-right-radius: $radius;
}
@mixin button {
  color: #fff;
  background: darken($header, 10);
  font-family: tahoma;
  display: flex;
  align-items: center;
  justify-content: center;
}

.log {
  display: grid;
  grid-template-columns: 1fr;
  grid-template-rows: 50px 1fr 70px;
  position: fixed;

  top: 0;
  left: 0;
  right: 0;
  bottom: 0;

  margin: 30px;

  width: auto;
  height: auto;

  background: $bgcolor;
  box-shadow: $shadow;

  border-radius: $radius;

  .header {
    font-family: tahoma;
    background: $header;
    color: $headertext;
    padding: 10px 5px;
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: center;

    @include radius(top);
    .text {
    }

    .close {
      @include button;
      width: $closesize;
      height: $closesize;
      border-radius: 50%;
      margin-right: 10px;
      padding: 5px;
      cursor: pointer;
      font-weight: bold;
    }
    .close:hover {
      background: darken($header, 5);
    }
  }
  .main {
  }
  .footer {
    @include radius(bottom);
  }
}
</style>
