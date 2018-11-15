let defaultState = {
    isSearching: false,
    notifications: [],
    searchAddress: '',
    searchPlaceId: null
};

let notificationFactory = (notification, options = {}) => {
    let key = new Date().getTime() + Math.random();

    if (typeof notification === 'string') {
        notification = {message: notification};
    }

    return {
        key: key,
        ...notification,
        options: {
            ...notification.options,
            ...options
        }
    };
};

const reducers = (state = defaultState, action) => {
    switch (action.type) {
        case 'NOTIFY':
            return {
                ...state,
                notifications: [notificationFactory(action.notification), ...state.notifications]
            };

        case 'NOTIFY_ERROR':
            return {
                ...state,
                notifications: [notificationFactory(action.notification, {variant: 'error'}), ...state.notifications]
            };

        case 'NOTIFY_INFO':
            return {
                ...state,
                notifications: [notificationFactory(action.notification, {variant: 'info'}), ...state.notifications]
            };

        case 'NOTIFY_SUCCESS':
            return {
                ...state,
                notifications: [notificationFactory(action.notification, {variant: 'success'}), ...state.notifications]
            };

        case 'NOTIFY_WARNING':
            return {
                ...state,
                notifications: [notificationFactory(action.notification, {variant: 'warning'}), ...state.notifications]
            };

        case 'REMOVE_NOTIFICATION':
            return {
                ...state,
                notifications: state.notifications.filter(notification => notification.key !== action.key)
            };

        case 'SELECT_SEARCH_ADDRESS':
            // Store last address and placeId
            localStorage.setItem('lastSearchAddress', action.address.address);
            localStorage.setItem('lastSearchPlaceId', action.address.placeId);

            return {
                ...state,
                searchAddress: action.address.address,
                searchPlaceId: action.address.placeId
            };

        case 'SEARCH_RESTAURANT_REQUEST':
            return {...state, isSearching: true};

        case 'SEARCH_RESTAURANT_FAILURE':
            return {...state, isSearching: false};

        default:
            return state;
    }
};

export default reducers;