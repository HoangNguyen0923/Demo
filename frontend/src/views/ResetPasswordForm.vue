<template>
  <div>
    <h2>Reset Password Form</h2>
    <form autocomplete="off" v-on:submit.prevent="resetPassword" method="post">
      <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" id="new_password" class="form-control" v-model="user.new_password" required>
      </div>
      <div class="form-group">
        <label for="new_password_confirm">New Password Confirm</label>
        <input type="password" id="new_password_confirm" class="form-control" v-model="user.new_password_confirm" required>
      </div>
      <button class="btn btn-primary">Reset Password</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data () {
    return {
      user: {
        new_password: '',
        new_password_confirm: '',
        token: ''
      }
    }
  },
  methods: {
    resetPassword () {
      axios.post('http://localhost:8000/api/password/reset',
        {
          token: localStorage.token_reset,
          new_password: this.user.new_password,
          new_password_confirm: this.user.new_password_confirm
        })
        .then(response => {
          if (response.data.check === 'update success') {
            console.log(response)
            localStorage.removeItem('token_reset')
            this.$router.push('/login')
          }
        })
        .catch(error => console.log(error))
    }
  }
}
</script>
