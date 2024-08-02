export default {
  getContacts(state) {
    return state.contacts;
  },
<<<<<<< HEAD
=======
  getContactsByStage: (state) => (stage_id) => {
    return state.contacts.filter((contact) => contact.stage_id === stage_id);
  }
>>>>>>> origin/main
};
