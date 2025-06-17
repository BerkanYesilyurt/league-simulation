import {defineStore} from "pinia";
import apiService from "../Services/apiServices";

export const useFixtureStore = defineStore('fixture', {
    state: () => ({fixture:null}),
    actions: {
        async getFixture(){
            try {
                const response = await apiService.createFixture();
                this.fixture = response.data;
                return response.data;
            }catch (err){
                console.error(err)
                return null
            }
        },
        getMatchesByWeek(week){
            return this.fixture ? this.fixture.filter(fixture => fixture.week === week) : []
        }
    }
})
