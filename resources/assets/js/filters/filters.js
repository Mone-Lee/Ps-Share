
/**
 *
 * 以数组下标的方式从对象中取数据
 *
 * @param object
 * @param index
 * @returns {*}
 */
exports.getItemFromObject = (object, index) => {
    let arr = Array.from(namesSet);
    return arr[index];
};

exports.getAssets = (url) => {
    return window.assets+url;
};

exports.timeFilter = (time) => {
    let date= new Date(Date.parse(time.replace(/-/g,   "/")));
    return date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
};

// exports.showDetail = (value, id) => {
//     console.log(id);
//     if(value.length == 0){
//         return false;
//     }else {
//         for(let el of value){
//             if(el.id == id){
//                 return true;
//             }
//         }
//         return false;
//     }
// };


