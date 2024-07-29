export default {
    setContacts(state, contacts) {
        state.contacts = contacts;
    },
    addContact(state, contact) {
        state.contacts.push(contact);
    },
    clearContacts(state) {
        state.contacts = [];
    },
}   