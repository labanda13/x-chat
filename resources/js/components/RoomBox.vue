<template>
  <span class="card border-0 text-reset cursor-pointer">
    <div class="card-body">
      <div class="row gx-5">
        <div class="col-auto">
          <div class="avatar">
            <span class="avatar-text">{{ room.name.charAt(0) }}</span>
          </div>
        </div>

        <div class="col">
          <div class="d-flex align-items-center mb-1">
            <h5 class="me-auto mb-0">{{ room.name }}</h5>
          </div>

          <div class="d-flex align-items-center">
            <div class="line-clamp me-auto">
              {{ room.guest_count }}/{{ room.guest_limit }} người online.
            </div>
          </div>
        </div>
      </div>
    </div><!-- .card-body -->
  </span>
  <div class="mb-2"></div>
</template>

<script>
export default {
  props: ['room']
}
</script>
