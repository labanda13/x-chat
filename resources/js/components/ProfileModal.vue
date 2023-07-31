<template>
  <div v-if="show" ref="profileModal" class="modal fade show" id="modal-profile" tabindex="-1" aria-labelledby="modal-profile" style="display: block; background: black" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-xl-down">
      <div class="modal-content">

        <!-- Modal body -->
        <div class="modal-body py-0">

          <!-- List -->
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <div class="mb-3">
                <label for="profile__nickname" class="form-label">Tên</label>
                <input v-model="nickname" type="email" class="form-control" id="profile__nickname" aria-describedby="emailHelp">
              </div>
            </li>
            <li class="list-group-item">
              <div class="mb-3">
                <label class="form-label">Giới tính</label>
                <select v-model="gender" class="form-select">
                  <option value="female">Nữ</option>
                  <option value="male">Nam</option>
                  <option value="gay">Gay</option>
                  <option value="less">Less</option>
                </select>
              </div>
            </li>
            <li class="list-group-item">
              <div class="mb-3">
                <label class="form-label">Tuổi</label>
                <select v-model="age" class="form-select">
                  <template v-for="i in 99" :key="i">
                    <option v-if="i > 17" :value="i">
                      {{ i }}
                    </option>
                  </template>
                </select>
              </div>
            </li>
          </ul>
          <!-- List  -->

          <!-- List -->
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <div class="d-grid gap-2">
                <button @click="register" :disabled="isSaving" class="btn btn-primary" type="button">Lưu thông tin</button>
                <button @click="show = false" class="btn btn-secondary" type="button">Đóng lại</button>
              </div>
            </li>
          </ul>
          <!-- List -->
        </div>
        <!-- Modal body -->

      </div>
    </div>
  </div>
</template>

<script>
import parseErrors from '../support/parseErrors'
import axios from 'axios'
import Swal from 'sweetalert2'

export default {

  props: ['guest'],

  data() {
    return {
      nickname: this.guest?.nickname || '',
      gender: this.guest?.gender || 'female',
      age: this.guest?.age || 18,

      isSaving: false,
      show: false
    }
  },

  created() {

  },

  methods: {

    /**
     * Register
     */
    async register() {
      this.isSaving = true
      try {
        const response = await axios.post('/api/guests', {
          nickname: this.nickname,
          gender: this.gender,
          age: this.age
        })
        const key = response.data.key

        // Trigger event
        this.$emit('guest-key', key)

        // Hide modal
        this.show = false

      } catch (error) {
        const errors = parseErrors(error)
        Swal.fire({
          title: 'Lỗi',
          text: errors.join("\n"),
          icon: 'error',
          confirmButtonText: 'Ok, Biết rồi!'
        })
      }

      this.isSaving = false
    },

    setGuestData(data) {
      this.nickname = data.nickname
      this.gender = data.gender
      this.age = data.age
    },

    /**
     * Show the modal
     */
    showModal() {
      this.show = true
    }
  }
}
</script>
