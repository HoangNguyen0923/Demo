<template>
  <div class="changePassword">
    <h2>Change Password</h2>
    <form autocomplete="off" v-on:submit.prevent="changePassword" method="post">
      <div class="form-group">
        <label for="curr_password">Current Password</label>
        <input type="password" id="curr_password" class="form-control" v-model="user.curr_password" required>
      </div>
      <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" id="new_password" class="form-control" v-model="user.new_password" required>
      </div>
      <div class="form-group">
        <label for="new_password">New Password Confirm</label>
        <input type="password" id="new_password_confirm" class="form-control" v-model="user.new_password_confirm" required>
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
        new_password_confirm: '',
        token: ''
      }
    }
  },
  methods: {
    changePassword () {
      axios.post('http://localhost:8000/api/password/change',
        {
          token: localStorage.storedData,
          curr_password: this.user.curr_password,
          new_password: this.user.new_password,
          new_password_confirm: this.user.new_password_confirm
        })
        .then(response => {
          if (response.data.check === 'change password success') {
            console.log(response)
          }
        })
        .catch(error => console.log(error))
    }
  }
}
</script>

<style lang="scss" scoped>
</style>
