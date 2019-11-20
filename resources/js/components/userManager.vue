<template>
  <div class="relative w-full h-full flex flex-col p-5">
    <div class="flex justify-between w-full">
      <p class="w-full text-xl tracking-widest font-light">Usuários</p>
      <button
        @click="openNewUserDrawer"
        class="text-gray-600 text-xl mr-3 mt-1"
        title="Novo Usuário"
      >
        <i class="fas fa-plus"></i>
      </button>
    </div>
    <hr class="mt-2 bg-gray-500" />
    <div
      v-show="users.length == 0"
      class="w-full text-gray-600 mt-5 tracking-wide font-ligth text-center"
    >Nenhum Usuário Cadastrado</div>
    <table v-show="users.length > 0" class="w-full h-full overflow-x-hidden overflow-y-scroll">
      <tbody>
        <tr class="border-b border-gray-300 p-3 flex w-full justify-between text-gray-600">
          <td class="font-bold text-left w-1/3">Nome</td>
          <td class="font-bold text-left w-1/3">E-Mail</td>
          <td class="w-1/6"></td>
        </tr>
        <tr
          v-for="user in users"
          :key="user.id"
          class="border-b border-gray-300 p-3 flex w-full justify-between text-gray-600"
        >
          <td class="text-left w-1/3">{{ user.name }}</td>
          <td class="text-left w-1/3">{{ user.email }}</td>
          <td class="text-right flex justify-around w-1/6">
            <button
              @click="openDeleteUserToast(user)"
              class="mr-3 bg-red-400 shadow rounded-sm text-white px-2 py-1 w-full"
            >
              <i class="fas fa-trash"></i>
            </button>
            <button
              @click="openEditUserDrawer(user)"
              class="bg-blue-400 shadow rounded-sm text-white px-2 py-1 w-full"
            >
              <i class="fas fa-edit"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- DRAWER NOVO USUÁRIO -->
    <div class="drawer" :class="{'drawer-open': !isNewUserDrawerOpen}">
      <p class="w-full text-xl tracking-widest font-light">Novo Usuário</p>
      <hr class="mt-2 bg-gray-500 mb-2" />
      <div class="flex flex-col mb-2">
        <label for="nome" class="text-gray-600">Nome</label>
        <input
          type="text"
          v-model="newUser.name"
          autocomplete="off"
          class="text-sm border border-gray-500"
          id="nome"
        />
      </div>
      <div class="flex flex-col mb-2">
        <label for="email" class="text-gray-600">E-Mail</label>
        <input
          type="email"
          v-model="newUser.email"
          autocomplete="off"
          class="text-sm border border-gray-500"
          id="email"
        />
      </div>
      <button
        @click="saveNewUser"
        class="bg-green-400 shadow rounded-sm text-white px-2 py-1 w-full"
      >Salvar</button>
      <button
        @click="closeNewUserDrawer"
        class="mt-1 bg-red-400 shadow rounded-sm text-white px-2 py-1 w-full"
      >Cancelar</button>
    </div>
    <!-- FIM DRAWER NOVO USUÁRIO -->
    <!-- INÍCIO DRAWER EDIÇÃO USUÁRIO -->
    <div class="drawer" :class="{'drawer-open': !isUserEditingDrawerOpen}">
      <p class="w-full text-xl tracking-widest font-light">Editar Usuário</p>
      <hr class="mt-2 bg-gray-500 mb-2" />
      <div class="flex flex-col mb-2">
        <label for="editingNome" class="text-gray-600">Nome</label>
        <input
          type="text"
          v-model="editingUser.name"
          autocomplete="my-autocomplete-cheat-nome"
          class="text-sm border border-gray-500"
          id="editingNome"
        />
      </div>
      <div class="flex flex-col mb-2">
        <label for="editingEmail" class="text-gray-600">E-Mail</label>
        <input
          type="email"
          v-model="editingUser.email"
          autocomplete="my-autocomplete-cheat-email"
          class="text-sm border border-gray-500"
          id="editingEmail"
        />
      </div>
      <button
        @click="updateSelectedUser"
        class="bg-green-400 shadow rounded-sm text-white px-2 py-1 w-full"
      >Salvar</button>
      <button
        @click="closeUserEditingDrawer"
        class="mt-1 bg-red-400 shadow rounded-sm text-white px-2 py-1 w-full"
      >Cancelar</button>
    </div>
    <!-- FIM DRAWER EDIÇÃO USUÁRIO -->
  </div>
</template>

<script>
import {
  getAllUsers,
  createUser,
  updateUser,
  deleteUser
} from "../requests/user";

export default {
  mounted() {
    this.refreshUserList();
  },
  data() {
    return {
      isNewUserDrawerOpen: false,
      isUserEditingDrawerOpen: false,
      users: [],
      newUser: {
        name: "",
        email: ""
      },
      editingUser: {
        name: "",
        email: ""
      }
    };
  },
  methods: {
    openNewUserDrawer() {
      this.isNewUserDrawerOpen = true;
    },
    closeNewUserDrawer() {
      this.isNewUserDrawerOpen = false;
    },
    closeUserEditingDrawer() {
      this.isUserEditingDrawerOpen = false;
    },
    refreshUserList() {
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
    },
    saveNewUser() {
      let newUser = {
        name: this.newUser.name,
        email: this.newUser.email
      };

      createUser(newUser)
        .then(r => {
          this.closeNewUserDrawer();

          this.refreshUserList();

          this.newUser.name = "";
          this.newUser.email = "";

          iziToast.show({
            color: "green",
            position: "bottomCenter",
            message: r.data.message
          });
        })
        .catch(e => {
          iziToast.show({
            color: "red",
            position: "bottomCenter",
            message: e.response.data.message
          });
        });
    },
    openEditUserDrawer(user) {
      this.editingUser = Object.assign({}, user);
      this.isUserEditingDrawerOpen = true;
    },
    updateSelectedUser() {
      let userToUpdate = Object.assign({}, this.editingUser);

      updateUser(userToUpdate)
        .then(r => {
          this.closeUserEditingDrawer();

          this.refreshUserList();

          iziToast.show({
            color: "green",
            position: "bottomCenter",
            message: r.data.message
          });
        })
        .catch(e => {
          iziToast.show({
            color: "red",
            position: "bottomCenter",
            message: e.response.data.message
          });
        });
    },
    openDeleteUserToast(user) {
      let deleteFunction = this.attemptUserDeletion;

      iziToast.question({
        timeout: 10000,
        close: false,
        displayMode: "once",
        id: "question",
        zindex: 999,
        message: "Deseja mesmo excluir este usuário?",
        position: "bottomCenter",
        buttons: [
          [
            "<button><b>Sim</b></button>",
            function(instance, toast) {
              deleteFunction(user);
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
    attemptUserDeletion(user) {
      deleteUser(user)
        .then(r => {
          this.refreshUserList();

          iziToast.show({
            color: "green",
            position: "bottomCenter",
            message: r.data.message
          });
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