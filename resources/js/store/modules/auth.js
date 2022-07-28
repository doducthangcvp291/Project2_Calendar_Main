import { currentUser } from "../../helpers/auth";
const user = currentUser();

export default {
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        authError: null,
    },
    getters: {
        IS_LOADING: state => {
            return state.loading;
        },
        IS_LOGGEND_IN: state => {
            return state.isLoggedIn;
        },
        CURRENT_USER: state => {
            return state.currentUser;
        },
        AUTH_ERROR: state => {
            return state.authError;
        },
        CURRENT_USER_ACCESS_TOKEN: state => {
            return state.currentUser.token;
        }
    },
    mutations: {
        LOGIN: state => {
            state.loading = true;
            state.authError = null;
        },
        LOGIN_SUCCESS: (state, payload) => {
            state.authError = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});
            //console.log("state: ",state);
            localStorage.setItem('user', JSON.stringify(state.currentUser));
        },
        LOGIN_FAILED: (state, payload) => {
            state.authError = payload.err;
            state.loading = false;
        },
        LOGOUT: (state) => {
            localStorage.removeItem('user');
            state.isLoggedIn = false;
            state.currentUser = null;
        },
    },
    actions: {
        LOGIN: (context) => {
            context.commit('LOGIN');
        },
        LOGOUT: (context) => {
            context.commit('LOGOUT');
        }
    }
}
