<template>
  <div class="welcome">
    <h1>{{ msg }}</h1>
  </div>
</template>

<script>
export default {
  name: 'Welcome',
  props: {
    msg: String
  }
}
</script>

<style lang="scss" scoped>

</style>
