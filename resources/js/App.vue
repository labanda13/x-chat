<template>
  <div id="app" ref="app">

    <div v-if="appLoading" class="d-flex justify-content-center align-items-center" style="height: 100%">
      <div class="text-center">
        <Loader />
        <h3>...Đang tải...</h3>
      </div>
    </div>
    <div v-else class="layout overflow-hidden">

      <!-- Sidebar -->
      <aside class="sidebar bg-light h-100">
        <div class="tab-content h-100" role="tablist">

          <!-- Chats -->
          <div class="tab-pane fade h-100 show active" id="tab-content-chats" role="tabpanel">
            <div class="d-flex flex-column h-100 position-relative">
              <div class="hide-scrollbar">

                <div class="container py-8">
                  <!-- Title -->
                  <div class="mb-8">
                    <h2 class="fw-bold m-0">Phòng Chat</h2>
                  </div>

                  <!-- Chats -->
                  <div class="card-list">

                    <!-- Rooms -->
                    <div v-for="room in rooms" :key="room.id" @click="selectRoom(room.id)">
                      <RoomBox :room="room" />
                    </div>

                  </div>
                  <!-- Chats -->
                </div>

              </div>
            </div>
          </div>

        </div>
      </aside>
      <!-- Sidebar -->

      <!-- Chat -->
      <main v-if="activeRoomId" class="main is-visible" data-dropzone-area="">
        <div class="container h-100">

          <div class="d-flex flex-column h-100 position-relative">
            <!-- Chat: Header -->
            <div class="chat-header border-bottom py-4 py-lg-7">
              <div class="row align-items-center">

                <!-- Mobile: close -->
                <div @click="selectRoom(null)" class="col-2 d-xl-none">
                  <a class="icon icon-lg text-muted" href="#" data-toggle-chat="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
                  </a>
                </div>
                <!-- Mobile: close -->

                <!-- Content -->
                <div class="col-8 col-xl-10">
                  <div class="row align-items-center text-center text-xl-start">

                    <!-- Title -->
                    <div class="col-12 col-xl-6">
                      <div class="row align-items-center gx-5">
                        <div class="col overflow-hidden">
                          <h5 class="text-truncate">{{ activeRoom.name }}</h5>
                          <p class="text-truncate">{{ activeRoom.guest_count }} người online</p>
                        </div>
                      </div>
                    </div>
                    <!-- Title -->


                  </div>
                </div>
                <!-- Content -->

                <!-- Setting -->
                <div @click="$refs.profileModal.showModal()" class="col-2 text-end">
                  <span class="text-muted cursor-pointer" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="icon icon-xl">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    </div>
                  </span>
                </div>

              </div>
            </div>
            <!-- Chat: Header -->

            <!-- Chat: Content -->
            <div v-on:scroll="onChatBodyScroll" ref="chatBody" class="chat-body hide-scrollbar flex-1 h-100">
              <div class="chat-body-inner" style="margin-bottom: 70px">
                <div class="py-6 py-lg-12">

                  <MessageBubble v-for="message in messages" :message="message" :guest="guest" />

                </div>
              </div>
            </div>
            <!-- Chat: Content -->

            <!-- Chat: Footer -->
            <div class="chat-footer pb-3 pb-lg-7 position-absolute bottom-0 start-0">

              <!-- Chat: Form -->
              <div class="chat-form rounded-pill bg-dark">
                <div class="row align-items-center gx-0">

                  <div class="col">
                    <div class="input-group">
                      <textarea ref="messageTextInput" v-model="messageText" v-on:focus="messageTextInputFocus" v-on:keyup.enter="sendMessage" class="form-control pl-5" placeholder="Type your message..." rows="1" data-emoji-input="" data-autosize="true"></textarea>
                    </div>
                  </div>

                  <div class="col-auto">
                    <div @click="sendMessage" :disabled="isSendingMessage" class="cursor-pointer btn btn-icon btn-primary rounded-circle ms-5">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Chat: Form -->
            </div>
            <!-- Chat: Footer -->
          </div>

        </div>
      </main>
      <!-- Chat -->

    </div>

    <!-- Profile modal -->
    <ProfileModal ref="profileModal" :guest="guest" @guest-key="receiveGuestKey" />

  </div>
</template>

<script>
import axios from 'axios'
import parseErrors from './support/parseErrors'
import Swal from 'sweetalert2'

import Loader from './components/Loader'
import RoomBox from './components/RoomBox'
import MessageBubble from './components/MessageBubble'
import ProfileModal from './components/ProfileModal'

export default {

  components: {ProfileModal, Loader, RoomBox, MessageBubble },

  data() {
    return {
      isConnected: false,

      rooms: [],
      activeRoomId: null,
      messages: [],
      appLoading: true,
      guest: null,
      errors: [],

      messageText: '',
      isSendingMessage: false,

      autoScroll: true
    }
  },

  /**
   * Handle created hook
   */
  async created() {
    await this.loadGuest()
    await this.loadRooms()

    this.appLoading = false

    const selectRoom = () => {
      if (this.guest && this.guest.room_id) {
        this.selectRoom(parseInt(this.guest.room_id))
      } else {
        for (let room of this.rooms) {
          if (room.guest_count < room.guest_limit) {
            this.selectRoom(room.id)
            break
          }
        }
      }
    }
    selectRoom()

    this.echo.connector.pusher.connection.bind('connected', () => {
      this.isConnected = true
    })

    this.echo.connector.pusher.connection.bind('disconnected', () => {
      this.isConnected = false
    })

    setInterval(() => {
      if (this.isConnected) {
        return
      }
      console.log('Disconnected! Trying to reconnect...')
      selectRoom()
    }, 5000)
  },

  /**
   * Handle mounted hook
   */
  mounted() {

    // Touch self every 3 mins
    setInterval(() => {
      this.loadGuest()
    }, 3 * 60 * 1000)

    // On window resize, re-scroll
    let autoScroller = null
    window.addEventListener('resize', () => {
      if (autoScroller) {
        clearTimeout(autoScroller)
      }

      autoScroller = setTimeout(() => {
        this.autoScrollChatBody()
      }, 200)
    })
  },

  /**
   * App methods
   */
  methods: {

    /**
     * Get rooms
     *
     * @returns {Promise<void>}
     */
    async loadRooms() {
      try {
        const response = await axios.get('/api/rooms')
        this.rooms = response.data

        // Listen to room update
        this.echo
          .channel('rooms')
          .listen('.updated', data => {
            this.rooms = data
          })

      } catch (error) {
        this.errors = parseErrors(error)
      }
    },

    /**
     * Get current guest information if present
     *
     * @returns {Promise<void>}
     */
    async loadGuest() {
      const guestKey = this.storage.getItem('guest-key')
      if (!guestKey) {
        return
      }

      try {
        const response = await axios.post('/api/guests:me', {
          key: guestKey,
          room_id: this.activeRoomId
        })
        this.guest = response.data
      } catch (error) {
        if (error.response.status === 404) {
          return
        }
        this.errors = parseErrors(error)
      }
    },

    /**
     * Select room
     *
     * @param id
     * @returns {Promise<void>}
     */
    async selectRoom(id) {

      if (!id) {
        this.activeRoomId = null
        return
      }

      // Ignore if select current
      if (id === this.activeRoomId) {
        return
      }

      // Disconnect from current room
      if (this.activeRoomId) {
        this.echo.leave('chat.' + this.activeRoomId)
      }

      try {
        this.appLoading = true

        const response = await axios.get('/api/rooms/' + id)
        this.messages = response.data.messages
        this.activeRoomId = id

        // Listen to active room
        const maxMessagesLength = this.activeRoom.message_limit
        this.echo
          .channel('room.' + this.activeRoomId)
          .listen('.message', e => {
            if (!this.messages.find(m => m.id == e.message.id)) {
              this.messages.push(e.message)
            }

            this.autoScrollChatBody(() => {

              // Trim messages
              const numberOfMessagesToRemove = maxMessagesLength - this.messages.length
              if (numberOfMessagesToRemove < 0) {
                this.messages.splice(0, Math.abs(numberOfMessagesToRemove))
              }

            })
          })

        this.appLoading = false
        this.autoScrollChatBody()
      } catch (error) {
        this.errors = parseErrors(error)
      }

      // Update guest
      this.loadGuest()
    },

    /**
     * Send message
     */
    async sendMessage() {

      // If guest object is null
      if (!this.guest) {
        this.$refs.messageTextInput.blur()
        this.$refs.profileModal.showModal()
        return
      }

      // Focus back to input
      this.$refs.messageTextInput.focus()

      const text = this.messageText
      this.messageText = ''
      this.isSendingMessage = true

      if (!text) {
        return
      }

      try {
        const response = await axios.post('/api/messages', {
          key: this.storage.getItem('guest-key'),
          room_id: this.activeRoomId,
          text
        })
      } catch (error) {
        this.errors = parseErrors(error)
        this.messageText = text
      }

      this.isSendingMessage = false
    },

    /**
     * Receive guest key
     */
    async receiveGuestKey(key) {
      this.storage.setItem('guest-key', key)

      this.appLoading = true
      await this.loadGuest()
      this.appLoading = false
    },

    /**
     * Handle scroll
     */
    onChatBodyScroll(e) {
      const chatBody = e.target
      this.autoScroll = !(chatBody.scrollTop < chatBody.scrollHeight - chatBody.clientHeight - 350)
    },

    /**
     * Auto scroll chat body to bottom
     */
    autoScrollChatBody(callback) {
      setTimeout(() => {
        const chatBody = this.$refs.chatBody
        if (!chatBody || !this.autoScroll) {
          return
        }

        const scrollTop = chatBody.scrollHeight - chatBody.clientHeight
        $(chatBody).animate({scrollTop}, 500)
        setTimeout(() => {
          if (callback) {
            callback()
          }
        }, 500)
      }, 100)
    },

    /**
     * Handle message text input focus
     */
    messageTextInputFocus() {

    }
  },

  /**
   * Computed properties
   */
  computed: {

    /**
     * Laravel Echo
     *
     * @returns {Echo}
     */
    echo: function () {
      return window.Echo
    },

    /**
     * Shortcut to window local storage
     *
     * @returns {Storage}
     */
    storage: function () {
      return window.localStorage
    },

    /**
     * Shortcut to active room
     *
     * @returns {*}
     */
    activeRoom: function () {
      return this.rooms.find(r => r.id === this.activeRoomId)
    }
  },

  /**
   * Watchers
   */
  watch: {

    /**
     * Watch for input text msg change
     */
    messageText: function () {
      this.messageText = this.messageText.replace(/(\r\n|\n|\r)/gm, "")
    },

    /**
     * Handle on messages changed
     */
    messages: function () {
      this.autoScrollChatBody()
    },

    /**
     * App loaded -> auto scroll
     *
     * @param is
     */
    appLoading: function (is) {
      if (is) {
        this.autoScrollChatBody()
      }
    },

    /**
     * Handle errors
     */
    errors: function (errors) {
      if (errors.length) {
        Swal.fire({
          title: 'Lỗi',
          text: errors.join("\n"),
          icon: 'error',
          confirmButtonText: 'Ok, Biết rồi!'
        })
        this.errors = []
      }
    },

    /**
     * Handle guest change
     */
    guest: function (guest) {
      if (!guest) {
        return
      }

      this.$refs.profileModal.setGuestData(guest)
    }
  }
}
</script>

<style>
#app {
  height: 100vh;
  width: 100%;
  top: 0px;
  left: 0px;
  position: fixed;
}
</style>
