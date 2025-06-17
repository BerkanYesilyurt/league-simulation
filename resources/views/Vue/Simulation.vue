<template>
     <div class="d-flex gap-4 justify-content-center py-5">
            <Table
            title="LEAGUE TABLE"
            :headers="['Team Name', 'P', 'W', 'D', 'L', 'GD']"
            :rows="teamStats"
            />

            <Table
                :title="`WEEK ${currentWeek}`"
                :headers="['Home', 'Home Score', 'Opponent Score', 'Opponent', 'Status']"
                :rows="fixtureWeek"
            />

            <Table
                title="CHAMPIONSHIP PREDICTIONS"
                :headers="['Team Name', '%']"
                :rows="championshipPrediction"
            />
        </div>



    <div v-if="currentWeek < 4 && !isAllPlayed" class="text-center fw-bold alert alert-dark w-25 mx-auto">
        Championship predictions will be displayed with the 4th week!
    </div>


        <div class="d-flex justify-content-center gap-5">
            <Button
                :handle-click="playAll"
                :button-text="isAllPlayed ? 'Show Next Week' : 'Play All Weeks'"
                :button-disabled="isMatchPlayed || (currentWeek + 1 >= latestWeek)"
            />

            <Button
                :handle-click="playGame"
                :button-text="!isFixtureCompleted ? (isWeekCompleted ? 'Next Week' : 'Play This Week') : 'FINISHED'"
                :button-disabled="isFixtureCompleted"
            />

            <Button
                :handle-click="resetData"
                button-text="Reset Data"
            />
        </div>
</template>

<script setup>
import {useFixtureStore} from '@/Store/fixture'
import {computed, onMounted, ref} from "vue";
import Button from "@/Components/Button.vue";
import Table from "@/Components/Table.vue";
import apiService from "@/Services/apiServices.js";

const isWeekCompleted = ref(false)
const currentWeek = ref(1)
const teamStats = ref([])
const fixtureWeek = ref([])
const championshipPrediction = ref([])
const isMatchPlayed = ref(false)
const isAllPlayed = ref(false)
const store = useFixtureStore()
const latestWeek = computed(() =>
    store.fixture?.length ? Math.max(...store.fixture.map(fixture => fixture.week)) + 1 : 0
)
const nextWeek = () => {
    if(isFixtureCompleted.value && !isAllPlayed.value) return
    currentWeek.value++
    fetchFixtureWeek()
    fetchPrediction()
}
const isFixtureCompleted = computed(() => (currentWeek.value + 1 >= latestWeek.value && isWeekCompleted.value) || isAllPlayed.value)

const playAll = () => {
    if(isMatchPlayed.value) return
    if(!isAllPlayed.value){
        isAllPlayed.value = true
        return fetchPlayGame(true, true)
    }

    if(currentWeek.value + 1 < latestWeek.value)
        nextWeek()
}

const resetData = () => {
    apiService.resetStats()
        .then(() => {
            currentWeek.value = 1
            isWeekCompleted.value = false
            isMatchPlayed.value = false
            isAllPlayed.value = false

            fetchTeamStats()
            fetchFixtureWeek()
            fetchPrediction()
        })
        .catch(console.error)
}

function fetchTeamStats() {
    apiService.fetchTeamStats()
        .then(res => {
            teamStats.value = res.data
                .sort((a, b) => b.stats.points - a.stats.points)
                .map(t => [
                    t.name,
                    t.stats.points,
                    t.stats.wins,
                    t.stats.draws,
                    t.stats.losses,
                    t.stats.goal_difference
                ])
        })
        .catch(console.error)
}

function playGame() {
    isMatchPlayed.value = true
    if(!isWeekCompleted.value){
        fetchPlayGame()
    }else{
        isWeekCompleted.value = false
        nextWeek()
    }
}

function fetchPlayGame(all, syncPrediction){
    apiService.playGame(currentWeek.value, all)
        .then(res => {
            fetchTeamStats()
            fixtureWeek.value = res.data.map(t => [
                t.home_team.name,
                t.home_team_score ?? '-',
                t.opponent_team_score ?? '-',
                t.opponent_team.name,
                t.status === 0 ? 'PLANNED' : 'PLAYED',
            ])
            isWeekCompleted.value = true

            if(syncPrediction){
                fetchPrediction()
            }
        })
        .catch(console.error)
}

function fetchFixtureWeek() {
    apiService.fetchFixtureWeek(currentWeek.value)
        .then(res => {
            fixtureWeek.value = res.data.map(t => [
                t.home_team.name,
                t.home_team_score ?? '-',
                t.opponent_team_score ?? '-',
                t.opponent_team.name,
                t.status === 0 ? 'PLANNED' : 'PLAYED',
            ])
        })
        .catch(console.error)
}

function fetchPrediction() {
    apiService.fetchPrediction()
        .then(res => {
            championshipPrediction.value = res.data
            .sort((a, b) => b.chance - a.chance)
            .map(t => [
                t.name,
                t.chance
            ])
        })
        .catch(console.error)
}

onMounted(() => {
    if(!store.fixture?.length){
        store.getFixture()
    }
    fetchTeamStats()
    fetchFixtureWeek()
    fetchPrediction()
})
</script>
