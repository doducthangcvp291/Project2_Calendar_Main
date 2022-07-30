<template>
    <div >
        <h2>Login Form</h2>
        <button class="btn btn-sm btn-secondary" @click="loginOrRegister = !loginOrRegister">Register</button>
            <div class="card" v-if="loginOrRegister">
                <article class="card-body">

                <form @submit.prevent="authenticate">
                        <div class="imgcontainer">
                            <img src="./schedule.png" alt="Avatar" class="avatar">
                        </div>

                        <div class="container">
                            <div class="form-group">
                                <label for="email"><b>Username</b></label>
                                <input type="email" class="form-control" placeholder="Enter Email" name="email" v-model="form.email" required>
                            </div>
                            <div class="form-group">
                                <label for="password"><b>Password</b></label>
                                <input type="password" class="form-control" placeholder="******" name="psw" v-model="form.password" required>
                            </div>
                            <div class="form-group">
                                <button type="submit">Login</button>
                            </div>
                            <label>
                            <input type="checkbox" checked="checked" name="remember"> Remember me
                            </label>
                        </div>

                        <div class="container" style="background-color:#f1f1f1">
                            <button type="button" class="cancelbtn">Cancel</button>
                            <span class="psw">Forgot <a href="#">password?</a></span>
                        </div>
                </form>
                </article>
        </div>
        <template v-else>
                <div  class="card">
                    <article class="card-body">
                        <form @submit.prevent="registerAc">
                        <div class="imgcontainer">
                            <img src="./schedule.png" alt="Avatar" class="avatar">
                        </div>

                        <div class="container">
                            <div class="form-group">
                                <label for="name"><b>Name</b></label>
                                <input type="text" class="form-control" placeholder="Enter Your Name" name="name" v-model="form.name" required>
                            </div>
                            <div class="form-group">
                                <label for="email"><b>Username</b></label>
                                <input type="email" class="form-control" placeholder="Enter Email" name="email" v-model="form.email" required>
                            </div>
                            <div class="form-group">
                                <label for="password"><b>Password</b></label>
                                <input type="password" class="form-control" placeholder="******" name="psw" v-model="form.password" required>
                            </div>
                            <div class="form-group">
                                <div >
                                    <button type="submit">Register</button>
                                </div>
                            </div>

                        </div>
                        </form>
                    </article>
                </div>
        </template>
    </div>
</template>



<script>
    import { login , register } from '../helpers/auth';  

    export default {
        name: 'Login',
        data() {
            return {
                loginOrRegister: true ,
                form: {
                    email: '',
                    password: '',
                    name: ''
                },
                type: 'login',
                error: null,
            }
        },
        methods: {
            authenticate() {
                this.$store.dispatch("LOGIN");

                login(this.$data.form)// ham login ben help/auth
                    .then(res => {
                        console.log("res after login:  ",res);
                        this.$store.commit("LOGIN_SUCCESS", res);
                        this.$router.push({path: '/'}).catch(()=>{});
                        //console.log("state after login : ",this.$store.state)
                    })
                    .catch(err => {
                        this.$store.commit("LOGIN_FAILED", {err})
                        this.showAlert(this.authError, 'error');
                    })
            },
            registerAc(){
                register(this.$data.form)
                    .then(res => {
                        console.log("res after register:  ",res);
                        this.loginOrRegister = !this.loginOrRegister ;                        
                        // this.$router.push({path: '/login'}).catch(()=>{});
                        //console.log("state after login : ",this.$store.state)
                    })
                    .catch(err => {
                        
                        console.log('error register');
                    })                
            }
        },
        computed: {
            authError() {
                return this.$store.getters.AUTH_ERROR;
            }
        }
    }
</script>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}



input[type=email],[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  /* display: inline-block; */
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}
.form-group {
    position: relative;
}
.center {
  margin: 0;
  position: relative;
 top: 50%;
  left: 50%;
  /* right: 0px ;
  bottom: 0px;  */
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

/* button:hover {
  opacity: 0.8;
} */

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  /* display: block; */
  margin-left: auto;
  margin-right: auto;
  width: 50%;    

}

/* .avatar {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
} */

img.avatar {
  width: 40%;
  border-radius: 50%;
}

/* .container {
  padding: 16px;
} */

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
