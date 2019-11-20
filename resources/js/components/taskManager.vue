<template>
  <div class="relative w-full h-full flex flex-col p-5">
    <div class="flex justify-between w-full">
      <p class="w-full text-xl tracking-widest font-light">Tarefas</p>
      <button
        @click="openNewTaskDrawer"
        class="text-gray-600 text-xl mr-3 mt-1"
        title="Nova Tarefa"
      >
        <i class="fas fa-plus"></i>
      </button>
    </div>
    <hr class="mt-2 bg-gray-500" />
    <div
      v-show="tasks.length == 0"
      class="w-full text-gray-600 mt-5 tracking-wide font-ligth text-center"
    >Nenhuma Tarefa Cadastrada</div>
    <table v-show="tasks.length > 0" class="w-full h-full overflow-x-hidden overflow-y-scroll">
      <tbody>
        <tr class="border-b border-gray-300 p-3 flex w-full justify-between text-gray-600">
          <td class="font-bold text-left w-1/4">Descrição</td>
          <td class="font-bold text-left w-1/4">Responsável</td>
          <td class="font-bold text-left w-1/4">Deadline</td>
          <td class="w-1/6"></td>
        </tr>
        <tr
          v-for="task in tasks"
          :key="task.id"
          class="border-b border-gray-300 p-3 flex w-full justify-between text-gray-600"
        >
          <td class="text-left w-1/4">{{ task.description }}</td>
          <td class="text-left w-1/4">{{ task.user.name }}</td>
          <td class="text-left w-1/4">{{ task.deadline }}</td>
          <td class="text-right flex justify-around w-1/6">
            <button
              @click="openDeleteTaskToast(task)"
              class="mr-3 bg-red-400 shadow rounded-sm text-white px-2 py-1 w-full"
            >
              <i class="fas fa-trash"></i>
            </button>
            <button
              @click="openEditTaskDrawer(task)"
              class="bg-blue-400 shadow rounded-sm text-white px-2 py-1 w-full"
            >
              <i class="fas fa-edit"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- DRAWER NOVA TAREFA -->
    <div class="drawer" :class="{'drawer-open': !isNewTaskDrawerOpen}">
      <p class="w-full text-xl tracking-widest font-light">Nova Tarefa</p>
      <hr class="mt-2 bg-gray-500 mb-2" />
      <div class="flex flex-col mb-2">
        <label for="taskDescription" class="text-gray-600">Descrição</label>
        <input
          type="text"
          v-model="newTask.description"
          autocomplete="off"
          class="text-sm border border-gray-500"
          id="taskDescription"
        />
      </div>
      <div class="flex flex-col mb-2">
        <label for="taskUser" class="text-gray-600">Responsável</label>
        <select
          v-model="newTask.user_id"
          autocomplete="off"
          class="text-sm border border-gray-500"
          id="taskUser"
        >
          <option v-for="user in users" :key="user.id" :value="user.id">{{user.name}}</option>
        </select>
      </div>
      <div class="flex flex-col mb-2">
        <label for="taskDeadline" class="text-gray-600">Deadline</label>
        <input
          type="date"
          v-model="newTask.deadline"
          autocomplete="off"
          class="text-sm border border-gray-500"
          id="taskDeadline"
        />
      </div>
      <button
        @click="saveNewTask"
        class="bg-green-400 shadow rounded-sm text-white px-2 py-1 w-full"
      >Salvar</button>
      <button
        @click="closeNewTaskDrawer"
        class="mt-1 bg-red-400 shadow rounded-sm text-white px-2 py-1 w-full"
      >Cancelar</button>
    </div>
    <!-- FIM DRAWER NOVA TAREFA -->
    <!-- INÍCIO DRAWER EDIÇÃO TAREFA -->
    <div class="drawer" :class="{'drawer-open': !isTaskEditingDrawerOpen}">
      <p class="w-full text-xl tracking-widest font-light">Editar Tarefa</p>
      <hr class="mt-2 bg-gray-500 mb-2" />
      <div class="flex flex-col mb-2">
        <label for="editingTaskDescription" class="text-gray-600">Descrição</label>
        <input
          type="text"
          v-model="editingTask.description"
          autocomplete="off"
          class="text-sm border border-gray-500"
          id="editingTaskDescription"
        />
      </div>
      <div class="flex flex-col mb-2">
        <label for="editingTaskUser" class="text-gray-600">Responsável</label>
        <select
          v-model="editingTask.user_id"
          autocomplete="off"
          class="text-sm border border-gray-500"
          id="editingTaskUser"
        >
          <option v-for="user in users" :key="user.id" :value="user.id">{{user.name}}</option>
        </select>
      </div>
      <div class="flex flex-col mb-2">
        <label for="taskDeadline" class="text-gray-600">Deadline</label>
        <input
          type="date"
          v-model="editingTask.deadline"
          autocomplete="off"
          class="text-sm border border-gray-500"
          id="taskDeadline"
        />
      </div>
      <button
        @click="updateSelectedTask"
        class="bg-green-400 shadow rounded-sm text-white px-2 py-1 w-full"
      >Salvar</button>
      <button
        @click="closeTaskEditingDrawer"
        class="mt-1 bg-red-400 shadow rounded-sm text-white px-2 py-1 w-full"
      >Cancelar</button>
    </div>
    <!-- FIM DRAWER EDIÇÃO TAREFA -->
  </div>
</template>

<script>
import {
  getAllTasks,
  createTask,
  updateTask,
  deleteTask
} from "../requests/task";

import { getAllUsers } from "../requests/user";

export default {
  mounted() {
    this.refreshTaskList();
    this.populateUsersList();
  },
  data() {
    return {
      isNewTaskDrawerOpen: false,
      isTaskEditingDrawerOpen: false,
      tasks: [],
      users: [],
      newTask: {},
      editingTask: {}
    };
  },
  methods: {
    refreshTaskList() {
      getAllTasks()
        .then(r => {
          this.tasks = r.data.data;
        })
        .catch(e => {
          iziToast.show({
            color: "red",
            position: "bottomCenter",
            message: e.response.data.message
          });
        });
    },
    openNewTaskDrawer() {
      this.isNewTaskDrawerOpen = true;
    },
    closeNewTaskDrawer() {
      this.isNewTaskDrawerOpen = false;
    },
    closeTaskEditingDrawer() {
      this.isTaskEditingDrawerOpen = false;
    },
    openEditTaskDrawer(task) {
      let taskToEdit = Object.assign({}, task);

      let dateSplit = taskToEdit.deadline.split("/");

      taskToEdit.deadline =
        dateSplit[2] + "-" + dateSplit[1] + "-" + dateSplit[0];

      this.editingTask = Object.assign({}, taskToEdit);
      this.isTaskEditingDrawerOpen = true;
    },
    saveNewTask() {
      let newTask = Object.assign({}, this.newTask);

      createTask(newTask)
        .then(r => {
          this.refreshTaskList();

          this.newTask = {};

          iziToast.show({
            color: "green",
            position: "bottomCenter",
            message: r.data.message
          });

          this.closeNewTaskDrawer();
        })
        .catch(e => {
          iziToast.show({
            color: "red",
            position: "bottomCenter",
            message: e.response.data.message
          });
        });
    },
    updateSelectedTask() {
      updateTask(this.editingTask)
        .then(r => {
          this.refreshTaskList();

          this.editingTask = {};

          iziToast.show({
            color: "green",
            position: "bottomCenter",
            message: r.data.message
          });

          this.closeTaskEditingDrawer();
        })
        .catch(e => {
          iziToast.show({
            color: "red",
            position: "bottomCenter",
            message: e.response.data.message
          });
        });
    },
    attemptTaskDeletion(task) {
      deleteTask(task)
        .then(r => {
          iziToast.show({
            color: "green",
            position: "bottomCenter",
            message: r.data.message
          });
          this.refreshTaskList();
        })
        .catch(e => {
          iziToast.show({
            color: "red",
            position: "bottomCenter",
            message: e.response.data.message
          });
        });
    },
    openDeleteTaskToast(task) {
      let deleteFunction = this.attemptTaskDeletion;

      iziToast.question({
        timeout: 10000,
        close: false,
        displayMode: "once",
        id: "question",
        zindex: 999,
        message: "Deseja mesmo excluir esta tarefa?",
        position: "bottomCenter",
        buttons: [
          [
            "<button><b>Sim</b></button>",
            function(instance, toast) {
              deleteFunction(task);
              instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            },
            true
          ],
          [
            "<button>Não</button>",
            function(instance, toast) {
              instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            }
          ]
        ]
      });
    },
    populateUsersList() {
      getAllUsers()
        .then(r => {
          this.users = r.data.data;
        })
        .catch(e => {
          iziToast.show({
            color: "red",
            position: "bottomCenter",
            message: e.response.data.message
          });
        });
    }
  }
};
</script>

<style>
</style>