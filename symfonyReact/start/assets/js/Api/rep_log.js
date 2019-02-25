function fetchJson(url, options) {
    return fetch(url, Object.assign({
        credentials: 'same-origin',
    }, options))
        .then(response => {
            return response.json();
        });
}

/**
 * Return a promise with api call result
 *
 * @returns {Promise<any | never>}
 */
export function getRepLogs() {
    return fetchJson('/reps')
        .then((data) => data.items);
}

/**
 * Return a promise with api call result
 *
 * @returns {Promise<any | never>}
 */
export function deleteRepLog(id) {
    return fetchJson(`/reps/${id}`, {
        method: 'DELETE'
    });
}

/**
 *
 * @param repLog
 *
 * @returns {*}
 */
export function createRepLog(repLog) {
    return fetchJson('/reps', {
        method: 'POST',
        body: JSON.stringify(repLog),
        headers: {
            'Content-Type': 'application/json'
        }
    });
}