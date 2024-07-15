<script setup lang="ts">
const props = defineProps<{
  label?: string;
}>();

const data = defineModel();

function setData() {
  data.value = !data.value;
}
</script>

<template>
  <div class="ckeckboxcontainer">
    <div class="label">{{ label }}</div>
    <div class="checkbox" :class="{ off: !data }" @click="setData()">
      <div class="slider"></div>
    </div>
  </div>
</template>

<style scoped lang="scss">
$bgcolor: #fafafa;

.ckeckboxcontainer {
  margin: 0 10px;
  display: inline-grid;
  width: auto;
  grid-template-columns: auto 40px;
  font-family: tahoma;
  align-items: center;

  .label {
    margin-right: 10px;
  }
  .checkbox {
    cursor: pointer;

    background: darken($bgcolor, 7);
    height: 20px;
    border-radius: 30px;

    .slider {
      background-color: forestgreen;
      border-radius: 30px;
      width: 20px;
      height: 20px;
      margin-left: 0;
      transition-property: margin-left, background-color;
      transition-duration:0.5s;
    }
  }

  .off {
    .slider {
      margin-left: calc(100% - 20px);
      background-color: darken($bgcolor, 35);;
    }
  }
}
</style>
