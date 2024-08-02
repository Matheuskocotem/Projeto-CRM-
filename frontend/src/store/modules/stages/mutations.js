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
<<<<<<< HEAD
=======
    changeStage(state, stage_id) {
        state.stage_id = stage_id;
    },
>>>>>>> origin/main
    clearStages(state) {
        state.stages = [];
    },
}