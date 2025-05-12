export function formatTime(item) {
    var d = new Date(item); // for now
    let hours = `${d.getHours()}`.length > 1 ?`${d.getHours()}` : `0${d.getHours()}`;
    let minutes =`${d.getMinutes()}`.length > 1 ?`${d.getMinutes()}` : `0${d.getMinutes()}`;
    let seconds = `${d.getSeconds()}`.length > 1 ?`${d.getSeconds()}` : `0${d.getSeconds()}`;
    return `${hours}:${minutes}:${seconds}`;
}

export function formatDateTime(item) {
    var d = new Date(item); // for
    let year = `${d.getFullYear()}`;
    let month =`${d.getMonth() + 1}`.length > 1 ?`${d.getMonth() + 1}` : `0${d.getMonth() + 1}`;
    let days = `${d.getDate()}`.length > 1 ?`${d.getDate()}` : `0${d.getDate()}`;
    let hours = `${d.getHours()}`.length > 1 ?`${d.getHours()}` : `0${d.getHours()}`;
    let minutes =`${d.getMinutes()}`.length > 1 ?`${d.getMinutes()}` : `0${d.getMinutes()}`;
    let seconds = `${d.getSeconds()}`.length > 1 ?`${d.getSeconds()}` : `0${d.getSeconds()}`;
    return `${year}-${month}-${days} ${hours}:${minutes}:${seconds}`;
}

export function formatDate(item) {
    var d = new Date(item); // for
    let year = `${d.getFullYear()}`;
    let month =`${d.getMonth() + 1}`.length > 1 ?`${d.getMonth() + 1}` : `0${d.getMonth() + 1}`;
    let days = `${d.getDate()}`.length > 1 ?`${d.getDate()}` : `0${d.getDate()}`;
    return `${year}-${month}-${days}`;
}
