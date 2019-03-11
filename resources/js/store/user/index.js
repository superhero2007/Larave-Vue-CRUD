const USER_URL = '/api/user';

export default {
  state: {
    loadedUsers: []
  },
  mutations: {
    setLoadedUsers (state, payload) {
      state.loadedUsers = payload
    },
    createUser (state, payload) {
      state.loadedUsers.push(payload)
    },
    updateUser (state, payload) {
      const index = state.loadedUsers.findIndex(user => {
        return user.id === payload.id
      })
      state.loadedUsers.splice(index, 1, payload.user)
    },
    deleteUser (state, payload) {
      state.loadedUsers = state.loadedUsers.filter(e => {
        return e.id !== payload.id
      })
    }
  },
  actions: {
    loadUsers ({commit}) {
      commit('setLoading', true)
      window.axios.get(USER_URL)
        .then(
          response => {
            commit('setLoading', false)
            commit('setLoadedUsers', response['data']['users'])
          }
        )
        .catch(
          error => {
            commit('setLoading', false)
            console.log(error)
          }
        )
    },
    createUser ({commit, getters}, payload) {
      const user = {
        name: payload.name,
        email: payload.email,
        phonenumber: payload.phonenumber,
        image: payload.image,
        password: 'password'
      };
      commit('setLoading', true)
      return new Promise((resolve, reject) => {
        window.axios.post(USER_URL, user)
          .then(
            response => {
              commit('setLoading', false)
              commit('createUser', response['data']['user'])
              resolve(response)
            }
          )
          .catch(
            error => {
              commit('setLoading', false)
              reject(error)
            }
          )
      })
    },
    updateUser ({commit}, payload) {
      commit('setLoading', true)
      const user = {
        name: payload.name,
        email: payload.email,
        phonenumber: payload.phonenumber,
        image: payload.image,
        password: 'password'
      };

      return new Promise((resolve, reject) => {
        window.axios.put(USER_URL + '/' + payload.id, user)
          .then(response => {
            commit('setLoading', false)
            const updateObject = {
              id: payload.id,
              user: response['data']['user']
            }
            commit('updateUser', updateObject)
            resolve(response)
          })
          .catch(error => {
            commit('setLoading', false)
            reject(error)
          })
      })
    },
    deleteUser ({commit}, payload) {
      commit('setLoading', true)
      window.axios.delete(USER_URL + '/' + payload.id)
        .then(() => {
          commit('setLoading', false)
          commit('deleteUser', payload)
        })
        .catch(error => {
          console.log(error)
          commit('setLoading', false)
        })
    }
  },
  getters: {
    loadedUsers (state) {
      return state.loadedUsers
    }
  }
}
