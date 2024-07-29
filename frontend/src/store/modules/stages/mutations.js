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
    clearStages(state) {
        state.stages = [];
    },
}