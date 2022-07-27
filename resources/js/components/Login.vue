<template>
    <div class="col-md-8 offset-md-2 pt-100">
        <div class="card">
            <article class="card-body">
                <a href="" class="float-right btn btn-outline-primary" @click.prevent="changeType('register')">Sign up</a>
                <h4 class="card-title mb-4 mt-1">Sign in</h4>
                <p>
                    <a href="" class="btn btn-block btn-outline-info"> <i class="fa fa-twitter"></i>   Login via Twitter</a>
                    <a href="" class="btn btn-block btn-outline-primary"> <i class="fa fa-facebook-f"></i>   Login via Facebook</a>
                    <a href="" class="btn btn-block btn-outline-primary"> <i class="fa fa-google"></i>   Login via Gmail</a>
                </p>
                <hr>
                <form @submit.prevent="authenticate">
                    <div class="form-group">
                        <input name="" class="form-control" placeholder="Email or login" type="email" v-model="form.email">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="******" type="password" v-model="form.password">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block"> Login  </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <a class="small" href="#">Forgot password?</a>
                        </div>
                    </div>
                </form>
            </article>
        </div>
    </div>
</template>

<script>
    import { login } from '../helpers/auth';

    export default {
        name: 'Login',
        data() {
            return {
                form: {
                    email: '',
                    password: '',
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
                        this.$store.commit("LOGIN_SUCCESS", res);
                        this.$router.push({path: '/'});
                    })
                    .catch(err => {
                        this.$store.commit("LOGIN_FAILED", {err})
                        this.showAlert(this.authError, 'error');
                    })
            },
        },
        computed: {
            authError() {
                return this.$store.getters.AUTH_ERROR;
            }
        }
    }
</script>
