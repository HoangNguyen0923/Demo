<template>
  <div>
    <h2>Reset Password</h2>
    <form autocomplete="off" v-on:submit.prevent="sendPasswordLink" method="post">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" id="email" class="form-control" placeholder="John@example.com" v-model="user.email" required>
      </div>
      <button class="btn btn-primary">Send Password Reset Link</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data () {
    return {
      user: {
        email: ''
      }
    }
  },
  methods: {
    sendPasswordLink () {
      axios.post('http://localhost:8000/api/password/email',
        {
          email: this.user.email
        })
        .then(response => {
          console.log(response)
          localStorage.setItem('token_reset', response.data.token)
          this.$router.push('reset_password_link')
        })
        .catch(error => console.error(error))
    }
  }
}
</script>
