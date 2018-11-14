let defaultState = {
    isSearching: false,
    nextNotification: -1,
    notifications: [],
    searchAddress: '',
    searchPlaceId: null
};

const reducers = (state = defaultState, action) => {
    switch (action.type) {
        case 'ADD_NOTIFICATION':
            let key = state.nextNotification + 1;

            return {
                ...state,
                nextNotification: key,
                notifications: [{...action.notification, key: key}, ...state.notifications]
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

        default: return state;
    }
};

export default reducers;