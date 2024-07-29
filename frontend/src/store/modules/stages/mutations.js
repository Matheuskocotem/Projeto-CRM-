export default {
    addStage(state, stage) {
        state.stages.push(stage);
    },
    setStages(state, stages) {
        state.stages = stages;
    },
    deleteStage(state, stage) {
        state.stages = state.stages.filter(s => s.id !== stage.id);
    },
    updateStage(state, stage) {
        const index = state.stages.findIndex(s => s.id === stage.id);
        state.stages.splice(index, 1, stage);
    },
    clearStages(state) {
        state.stages = [];
    },
    changePosition(state, payload) {
        const { stage, position } = payload;
        const index = state.stages.findIndex(s => s.id === stage.id);
        state.stages.splice(index, 1);
        state.stages.splice(position, 0, stage);
    },
    updateStagePositions(state) {
        state.stages.forEach((stage, index) => {
            stage.position = index;
        })
    }
}