<template>
  <div>
    <div class="pagination">
      <!-- <button
        @click="changePage(meta.prev_page_url)"
        :disabled="!meta.prev_page_url"
      >
        voltar
      </button>
      <button
        @click="changePage(meta.next_page_url)"
        :disabled="!meta.next_page_url"
      >
        Proxímo
      </button> -->
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  props: {
    current_page: "current_page",
    last_page: 1,
    next_page_url: null,
    prev_page_url: null,
  },
  computed: {
    ...mapGetters("funnels", ["getPagination"]),
  },
  methods: {},
};
</script>
<style>
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 1rem;
}
</style>
