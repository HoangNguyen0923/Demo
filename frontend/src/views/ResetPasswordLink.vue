<template>
  <div>
    <h1>Get the reset link</h1>
    <form method="post">
        <div class="form-group">
          <span>Email: {{user.email}}</span>
        </div>
        <div class="form-group">
          <router-link to="/reset_password_form">http://redirect/to/{{user.token}}</router-link>
        </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data () {
    return {
      user: {
        email: '',
        token: ''
      }
    }
  },
  created () {
    this.getData()
  },
  methods: {
    getData () {
      axios.post('http://localhost:8000/api/password/email-link',
        {
          'token': localStorage.token_reset
        })
        .then(response => {
          if (response.data.check === 'success') {
            this.user.email = response.data.email
            this.user.token = response.data.token
          }
        })
        .catch(error => console.error(error))
    }
  }
}
</script>
