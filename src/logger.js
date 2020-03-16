export default class Logger {
    static get CSS_TYPE() {
        return 'color:red;';
    }
    static get CSS_HEADER() {
        return 'color:orange;';
    }
    static get CSS_BODY() {
        return 'color:blue;';
    }

    constructor() {}

    static debug(action, payload) {
        if (process.env.NODE_ENV === 'development') {
            if (payload !== null && payload !== undefined)
                console.log(action, payload);
            else console.log(action);
        }
    }
    static error(action, payload) {
        // if (process.env.NODE_ENV === 'development') {
        if (payload !== null && payload !== undefined)
            console.error(action, payload);
        else console.error(action);
        //}
    }
}
