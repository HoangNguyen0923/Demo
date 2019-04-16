<template>
  <div>
    <div>
      <router-link class="dashboard" to="/dashboard"><h2>Dashboard</h2></router-link>
      <form v-on:submit.prevent="onSubmitted" method="get">
        <button class="btn btn-danger">Log out</button>
      </form>
    </div>
    <div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown button</button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <router-link class="dropdown-item" to="/dashboard/changepassword">ChangePassword</router-link>
        <router-link class="dropdown-item" to="/dashboard/product">Product</router-link>
      </div>
    </div>
    <div>
      <!-- Outlet for children routes -->
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
// import ChangePassword from '@/components/Dashboard/ChangePassword.vue'
export default {
  methods: {
    onSubmitted () {
      let config = {
        headers: {
          'Authorization': 'Bearer ' + localStorage.storedData
        }
      }
      axios.get('http://localhost:8000/api/logout', config)
        .then(response => {
          console.log(response)
          localStorage.removeItem('storedData')
          this.$router.push('/')
        })
        .catch(error => console.error(error))
    }
  }
}
</script>

<style lang="scss" scoped>
  .dashboard {
    text-decoration: none;
    color: black;
  }
  .dropdown {
    position: absolute;
    right: 0;
    top: 0;
  }
</style>
