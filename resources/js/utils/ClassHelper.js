export function isIsset(obj, key) {
    return handleIsset(obj, key);
}

export function get(obj, key, def) {
    if (!def) {
        def = null;
    }
    return handleIsset(obj, key) ? obj[key] : def
}

function handleIsset(obj, key) {
    return Object.keys(obj).length !== 0 && obj[key] !== undefined && obj[key] !== null;
}
