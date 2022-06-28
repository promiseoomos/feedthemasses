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

        apiClient.post("user.class.php", {
            userObj
        })
    }
}