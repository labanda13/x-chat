<template>

  <div v-if="!guest || guest.id != message.guest_id" class="message">
    <div class="message-inner">
      <div class="message-body">
        <div class="message-content">
          <div class="message-text">
            <strong>{{ message.guest.nickname }}</strong>
            <small style="font-size: 10px; display: block">{{ renderGender(message.guest.gender) }} - {{ message.guest.age }} tuổi</small>
            <p><small>{{ message.text }}</small></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div v-else class="message message-out">
    <div class="message-inner">
      <div class="message-body">
        <div class="message-content">
          <div class="message-text">
            <p>{{ message.text }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
export default {
  props: ['message', 'guest'],

  methods: {

    renderGender(gender) {
      switch (gender) {
        case 'male':
          return 'Nam'

        case 'female':
          return 'Nữ'

        default:
          return gender.charAt(0).toUpperCase() + gender.slice(1)
      }
    }
  }
}
</script>
