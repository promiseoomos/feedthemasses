import { ref } from "vue"

export default function capitalize(str){
    let capitalizedstr = str.charAt(0).toUpperCase() + str.slice(1)

    return capitalizedstr
}