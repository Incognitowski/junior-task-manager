export function getAllUsers() {

    return window.axios.get('/api/users');

}

export function findUser(userId) {

    return window.axios.get('/api/users/' + userId);

}

export function createUser(newUser) {

    let formData = new FormData();
    formData.set('name', newUser.name);
    formData.set('email', newUser.email);

    return window.axios.post('/api/users', formData);

}

export function updateUser(user) {

    let formData = new FormData();
    formData.set('_method', 'PUT');
    formData.set('name', user.name);
    formData.set('email', user.email);

    return window.axios.post('/api/users/' + user.id, formData);

}

export function deleteUser(user) {

    return window.axios.delete('/api/users/' + user.id);

}

