import axios from "axios"
let locationorigin = window.location.origin
let regexpatt = /\W?\d*$/
let windowobj = locationorigin.replace(regexpatt, "");

const apiClient = axios.create({
    baseURL: process.env.NODE_ENV == 'development' ? `${windowobj}/feedthemasses/src/apis` : `${windowobj}/apis`,
    headers: { Pragma: "no-cache", "Cache-Control": "no-store" },
});

export default {
    logger(userObj){

        return apiClient.post("user.class.php", {
            action : "login",
            userObj
        })
    },
    register(userObj){
        return apiClient.post("user.class.php", {
            action : "signup",
            userObj
        })
    },
    retrieveDownlines(track_id){
        return apiClient.post("user.class.php", {
            action : "get-downlines",
            track_id
        })
    },
    updateuser(userObj){
        return apiClient.post("user.class.php", {
            action : "update-user",
            userObj
        })
    },
    upgradeUserNow(upgradeObj){
        return apiClient.post("user.class.php", {
            action : "upgrade-user",
            upgradeObj
        })
    },
    collectReward(stage, track_id){
        return apiClient.post("user.class.php", {
            action : "collect-reward",
            stage,
            track_id
        })
    },
    getCollections(track_id){
        return apiClient.post("user.class.php", {
            action : "get-collection",
            track_id
        })
    }
}