import { defineStore } from "pinia";

export const adminStore = defineStore("admin", {

    state : () => {
        return {
            loggedin : "",
            details : "",
            clearance : ""
        }
    }
})