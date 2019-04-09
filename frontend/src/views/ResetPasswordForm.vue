<template>
  <div>
    <h2>Reset Password Form</h2>
    <form autocomplete="off" v-on:submit.prevent="resetPassword">
      <div class="form-group">
        <label for="curr_password">Current Password</label>
        <input type="password" id="curr_password" class="form-control" v-model="user.curr_password" required>
      </div>
      <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" id="new_password" class="form-control" v-model="user.new_password" required>
      </div>
      <button class="btn btn-primary">Change Password</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data () {
    return {
      user: {
        curr_password: '',
        new_password: '',
        token: ''
      }
    }
  },
  methods: {
    resetPassword () {
      axios.post('http://localhost:8000/api/password/reset',
        {
          token: localStorage.token_reset,
          curr_password: this.user.curr_password,
          new_password: this.user.new_password
        })
        .then(response => {
          console.log(response)
          localStorage.removeItem('token_reset')
          this.$router.push('/')
        })
        .catch(error => console.log(error))
    }
  }
}
</script>
