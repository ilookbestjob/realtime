<script setup lang="ts">
const props = defineProps<{
    time?:string;
    position?:string;
    event?:string
}>();
</script>

<template>
  <div class="logitem">
    <div class="time">{{ time }}</div>
    <div class="position">{{ position }}</div>
    <div class="event">{{ event }}</div>
  </div>
</template>
<style lang="scss">


.logitem {
    display:grid;
    grid-template-columns: 200px 200px 1fr;

  .time {
  }
  .position {
  }
  .event {
  }
}
</style>
