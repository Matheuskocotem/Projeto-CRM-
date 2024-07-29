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
    changePosition(state, payload) {
        state.contacts[payload.index].position = payload.newPosition;
    },
    changeStage(state, payload) {
        state.contacts[payload.index].stage_id = payload.newStageId;
    },
    moveContactsInStage(state, { oldIndex, newIndex }) {
        const movedContact = state.contacts.splice(oldIndex, 1)[0];
        state.contacts.splice(newIndex, 0, movedContact);
    },
    moveContactsToAnotherStage(state, { oldIndex, newStageId, newPosition }) {
        const movedContact = state.contacts.find(contact => contact.id === oldIndex);
        if (movedContact) {
            movedContact.stage_id = newStageId;
            contact.position = newPosition;
        }
    },
    updatePositions(state, {stage_id}) {
        const stageContacts = state.contacts.filter(contact => contact.stage.id === stage_id);
        stageContacts.sort((a, b) => a.position - b.position);
        stageContacts.forEach((contact, index) => {
            contact.position = index + 1;
        })
    }
}   