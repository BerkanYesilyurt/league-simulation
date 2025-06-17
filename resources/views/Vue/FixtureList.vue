<template>
    <div class="container py-5">
        <div v-if="store.fixture?.length" class="d-flex flex-wrap justify-content-center gap-3">
            <div
                v-for="(weekFixtures, week) in groupedFixtures"
                :key="week"
                class="fixture-card"
            >
                <Table
                    :title="`WEEK ${week}`"
                    :headers="['Home', 'Home Score', 'Opponent Score', 'Opponent', 'Status']"
                    :rows="formatRows(weekFixtures)"
                />
            </div>
        </div>

        <div class="text-center">
        <Button
            :handle-click="() => router.push('/simulation')"
            button-text="Start Simulation"
            button-class="w-25"
        />
        </div>
    </div>
</template>

<script setup>
import {useRouter} from 'vue-router';
import {useFixtureStore} from '@/Store/fixture.js'
import Table from '@/Components/Table.vue';
import Button from "@/Components/Button.vue";
import {computed, onMounted} from "vue";

const router = useRouter()
const store = useFixtureStore()

const formatRows = (fixtures) => {
    return fixtures.map(f => [
        f.home_team.name,
        f.home_team_score ?? '-',
        f.opponent_team_score ?? '-',
        f.opponent_team.name,
        f.status === 0 ? 'PLANNED' : 'PLAYED',
    ]);
}

const groupedFixtures = computed(() => {
    return store.fixture?.reduce((acc, f) => {
        if (!acc[f.week]) acc[f.week] = [];
        acc[f.week].push(f);
        return acc;
    }, {});
})

onMounted(() => {
    if(!store.fixture?.length){
        store.getFixture()
    }
})
</script>
