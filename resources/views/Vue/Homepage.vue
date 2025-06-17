<template>
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="w-100 px-3" style="max-width: 768px; text-align: center;">
            <Table
                title="Teams"
                :headers="['ID', 'Team']"
                :rows="teams"
            />

            <Button
                :handle-click="handleCreateFixture"
                button-text="Generate Fixtures"
                button-class="w-100"
            />
        </div>
    </div>
</template>

<script setup>
import {useRouter} from 'vue-router';
import {useFixtureStore} from '../../js/Store/fixture'
import Table from '../../js/Components/Table.vue';
import Button from '../../js/Components/Button.vue';
import apiService from '../../js/services/apiServices';
import {onMounted, ref} from "vue";

const teams = ref([])
const store = useFixtureStore()
const router = useRouter()

const handleCreateFixture = async () => {
    const data = await store.getFixture()
    if(data){
        await router.push('/fixture')
    }
}

onMounted(() => {
    apiService.fetchTeams()
        .then(res => {
            teams.value = res.data.map(t => [t.id, t.name]);
        })
        .catch(console.error);
})
</script>
