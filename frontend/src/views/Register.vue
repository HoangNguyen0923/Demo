<template>
  <div>
    <form autocomplete="off" v-on:submit.prevent="onSubmitted" method="post">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" class="form-control" placeholder="John Milner" v-model="user.name" autofocus required>
        </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="text" id="email" class="form-control" placeholder="John@example.com" v-model="user.email" required>
      </div>
      <div class="form-group">
        <label for="name">Password</label>
        <input type="password" id="password" class="form-control" v-model="user.password" required>
      </div>
      <button class="btn btn-success">Sign up</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data () {
    return {
      user: {
        name: '',
        email: '',
        password: ''
      }
    }
  },
  methods: {
    onSubmitted () {
      axios.post('http://localhost:8000/api/register',
        {
          name: this.user.name,
          email: this.user.email,
          password: this.user.password
        })
        .then(response => console.log(response))
        .catch(error => console.error(error))
      // console.log({content: this.user});
    }
  }
}
</script>
