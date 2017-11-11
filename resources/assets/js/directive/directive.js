
exports.focus = () => {
    return {
        inserted:(el, binding, vnode) => {
            el.focus();
        }
    };
};