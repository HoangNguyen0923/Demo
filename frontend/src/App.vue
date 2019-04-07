<template>
  <div id="app">
    <nav class="navbar navbar-expand-sm bg-light">
      <ul class="navbar-nav">
        <li class="nav-item"><router-link to='/login'>Login</router-link></li>
        <li class="nav-item"><router-link to='/register'>Register</router-link></li>
        <!-- <li class="nav-item"><router-link to='/dashboard'>Dashboard</router-link></li> -->
      </ul>
    </nav>
    <div class="row">
      <div class="col-xs-12">
        <div id="view">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
  li {
    margin-inline-end: 2rem;
  }
  .row {
    margin: 0;
  }
</style>
