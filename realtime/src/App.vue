<script setup lang="ts">
import alertitem from "./components/alertitem.vue";
import servertabs from "./components/servertabs.vue";
import checkbox from "./components/checkbox.vue";
import logdialog from "./components/logdialog.vue";
import { provide, ref, computed } from "vue";
</script>

<script lang="ts">
interface data {
  alerts: Object;
  servers: Object;
}

export default {
  name: "App",

  data() {
    return {
      logdialogModel: {
        logdialogvisible: ref(false),
        currentalert: ref(0),
      },
      alerts: [
        {
          name: "nm77",
          data: "",
        },
      ],
      servers: [
        {
          name: "Все",
          variants: ["0"],
        },
        {
          name: "Zod",
          variants: ["192.168.0.65"],
        },
        {
          name: "Web",
          variants: ["192.168.0.67"],
        },
        {
          name: "Team",
          variants: ["192.168.0.61"],
        },
        {
          name: "BigData",
          variants: ["192.168.0.69"],
        },
        {
          name: "Zod Spb",
          variants: ["192.168.1.199"],
        },
        {
          name: "Zod Msk",
          variants: ["192.168.2.61"],
        },
      ],
      count: 55,
      serverttabId: ref(0),
      actual: ref(true),
      working: ref(false),
      delay: ref(true),
      errors: ref(true),
    };
  },

  created() {
    this.fetchData();
    setInterval(this.fetchData, 1000);

    provide("servertabs", this.servers);
    provide(
      "actual",
      computed(() => this.actual)
    );
    provide(
      "working",
      computed(() => this.working)
    );
    provide(
      "delay",
      computed(() => this.delay)
    );
    provide(
      "errors",
      computed(() => this.errors)
    );

    provide(
      "alerts",
      computed(() => this.alerts)
    );
    provide("convertDate", this.convertDate);
    provide("prapareDate", this.prapareDate);
  },

  methods: {
    async fetchData() {
      const res = await fetch("http://192.168.0.67/realtime.php");
      const data = await res.json();

      this.alerts = data.filter((item: any) => {
        if (this.serverttabId == 0) return true;

        return item.phpserver
          ? item.phpserver.indexOf(this.servers[this.serverttabId].variants[0]) >= 0
          : false;
      });
    },
    convertDate(date: string) {
      const dateparts: any = date.split(/[- :]/);
      console.log(date, dateparts);
      return new Date(
        dateparts[0],
        dateparts[1] - 1,
        dateparts[2],
        dateparts[3] || 0,
        dateparts[4] || 0,
        dateparts[5] || 0
      );
    },

    prapareDate(date: string) {
      let dateresult: string = "";
      if (date) {
        let dateParts: number | any = date.split("-");

        if (dateParts.length > 2) {
          if (
            new Date().getMonth() != dateParts[1] * 1 ||
            new Date().getDate() != dateParts[2].substr(0, 2) * 1
          ) {
            dateresult =
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
              ][dateParts[1] * 1];
          }

          if (new Date().getFullYear() != dateParts[0] * 1) {
            dateresult = dateresult + " '" + dateParts[0].substr(2, 2);
          }

          dateresult = dateresult + date.split(" ")[1];
        }
      }
      return dateresult;
    },
  },
};
</script>

<template>
  <header>
    <servertabs v-model="serverttabId"></servertabs>
    <checkbox label="Актуальные" v-model="actual"></checkbox>
    <checkbox label="Работающие" v-model="working"></checkbox>
    <checkbox label="Задержка запуска" v-model="delay"></checkbox>
    <checkbox label="Ошибки" v-model="errors"></checkbox>
  </header>

  <main>
    <alertitem
      v-for="(alert, index) in alerts"
      v-bind="alert"
      :data="alert.data"
      :active="actual"
      :index="index"
      v-model="logdialogModel"
      @displayLogs="(index)=>{logdialogModel.logdialogvisible=true;logdialogModel.currentalert=index}"
    />
  </main>
  <logdialog :visible="logdialogModel.logdialogvisible" :id="logdialogModel.currentalert" @close="logdialogModel.logdialogvisible=false"/>
</template>

<style scoped>
header {
  display: flex;
  position: fixed;
  height: 60px;
  width: 100%;
  background: rgb(207, 207, 207);
  align-items: center;
  padding: 0 10px;
}
main {
  margin-top: 70px;
}
</style>
