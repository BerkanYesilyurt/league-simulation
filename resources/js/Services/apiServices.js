import axios from 'axios';

const apiClient = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
    },
});

export default {
    fetchTeams() {
        return apiClient.get('/teams');
    },
    fetchTeamStats() {
        return apiClient.get('/teams/stats');
    },
    createFixture() {
        return apiClient.post('/fixture/create');
    },
    fetchFixtureWeek(week) {
        return apiClient.get('/fixture/', {
            params: {
                week
            }
        });
    },
    fetchPrediction() {
        return apiClient.get('/prediction');
    },
    playGame(week, all = false) {
        return apiClient.post('/play-match', {week, all});
    },
    resetStats() {
        return apiClient.delete('/reset');
    },
};
