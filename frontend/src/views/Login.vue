<template>
  <div>
    <form autocomplete="off" v-on:submit.prevent="onSubmitted" method="post">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" id="email" class="form-control" placeholder="John@example.com" v-model="user.email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" class="form-control" v-model="user.password" required>
      </div>
      <div class="form-group">
        <router-link to='/reset_password'>Forget Password</router-link>
      </div>
      <button class="btn btn-primary">Sign in</button>
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
        password: ''
      }
    }
  },
  methods: {
    onSubmitted () {
      axios.post('http://localhost:8000/api/login',
        {
          email: this.user.email,
          password: this.user.password
        })
        .then(response => {
          console.log(response.data)
          if (response.data.auth === 'Login success') {
            localStorage.setItem('storedData', response.data.user_token)
            this.$router.push('dashboard')
          }
        })
        .catch(error => console.error(error))
    }
  }
}
</script>
