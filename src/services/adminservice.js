import axios from "axios"
let locationorigin = window.location.origin
let regexpatt = /\W?\d*$/
let windowobj = locationorigin.replace(regexpatt, "");

const apiClient = axios.create({
    baseURL: process.env.NODE_ENV == 'development' ? `${windowobj}/feedthemasses/src/apis` : `${windowobj}/apis`,
    headers: { Pragma: "no-cache", "Cache-Control": "no-store" },
});

export default {
    logger(adminObj){

        return apiClient.post("admin.class.php", {
            action : "login",
            adminObj
        })
    },
    getInfostats(){
        return apiClient.post("admin.class.php", {
            action : "get-info-stats"
        })
    },
    getCollections(){
        return apiClient.post("admin.class.php", {
            action : "get-collections"
        })
    },
    getVouchers(){
        return apiClient.post("admin.class.php", {
            action : "get-vouchers"
        })
    },
    getUsers(){
        return apiClient.post("admin.class.php", {
            action : "get-users"
        })
    },
    generateVoucher(vouchers_count){
        return apiClient.post("admin.class.php", {
            action : "generate-vouchers",
            vouchers_count
        })
    },
    approveRequest(rid){
        return apiClient.post("admin.class.php", {
            action : "approve-request",
            rid
        })
    },
    disapproveRequest(rid){
        return apiClient.post("admin.class.php", {
            action : "disapprove-request",
            rid
        })
    }

}