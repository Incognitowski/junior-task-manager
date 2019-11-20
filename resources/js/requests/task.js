export function getAllTasks() {

    return window.axios.get('/api/tasks');

}

export function findTask(taskId) {

    return window.axios.get('/api/tasks/' + taskId);

}

export function createTask(newTask) {

    let formData = new FormData();
    formData.set('description', newTask.description);
    formData.set('user_id', newTask.user_id);
    formData.set('deadline', newTask.deadline);

    return window.axios.post('/api/tasks', formData);

}

export function updateTask(task) {

    let formData = new FormData();
    formData.set('_method', 'PUT');
    formData.set('description', task.description);
    formData.set('user_id', task.user_id);
    formData.set('deadline', task.deadline);

    return window.axios.post('/api/tasks/' + task.id, formData);

}

export function deleteTask(task) {

    return window.axios.delete('/api/tasks/' + task.id);

}

