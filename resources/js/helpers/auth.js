export function login(credential) {
    return new Promise((res, rej) => {
        axios.post('api/auth/login', credential)
            .then(result => {
                console.log("result login : ",result);
                res(result.data);
                console.log ("login send");
            })
            .catch(err => {
                rej("Wrong email or password");
            })
    })
}
export function logout(token) {
    return new Promise((res, rej) => {
        axios.post('api/auth/logout', { headers: { Authorization: 'Bearer '+ token } }) // hoac header bearer token 
            .then(result => {
                console.log("result logout : ",result);
                res(result.data);
                console.log ("logout send");
            })
            .catch(err => {
                rej("Error when logout");
            })
    })
}

export function register(credential) {
    return new Promise((res, rej) => {
        axios.post('api/auth/register', credential)
            .then(result => {
                res(result.data);
                console.log("register send");
            })
            .catch(err => {
                rej("Wrong email or password");
            })
    })
}

export function currentUser() {
    const user = localStorage.getItem('user');

    if (!user) {
        return null;
    }

    return JSON.parse(user);
}
