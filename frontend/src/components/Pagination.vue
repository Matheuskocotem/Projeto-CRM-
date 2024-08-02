<template>
  <div>
    <div class="pagination">
<<<<<<< HEAD
      <!-- <button @click="changePage(meta.prev_page_url)" :disabled="!meta.prev_page_url">voltar</button>
      <button @click="changePage(meta.next_page_url)" :disabled="!meta.next_page_url">Proxímo</button> -->
    </div>
  </div>
</template>

=======
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
>>>>>>> origin/main
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  props: {
<<<<<<< HEAD
        current_page: 'current_page',
        last_page: 1,
        next_page_url: null,
        prev_page_url: null,
=======
    current_page: "current_page",
    last_page: 1,
    next_page_url: null,
    prev_page_url: null,
>>>>>>> origin/main
  },
  computed: {
    ...mapGetters("funnels", ["getPagination"]),
  },
<<<<<<< HEAD
  methods: {
  },


};
</script>

=======
  methods: {},
};
</script>
>>>>>>> origin/main
<style>
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 1rem;
}
</style>
