<template>
  <div>
    <h2>Dashboard</h2>
    <form v-on:submit.prevent="onSubmitted" method="get">
      <button class="btn btn-danger">Log out</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
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
