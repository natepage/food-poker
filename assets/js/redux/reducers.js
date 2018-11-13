let defaultState = {
    searchAddress: '',
    searchPlaceId: null
};

const reducers = (state = defaultState, action) => {
    switch (action.type) {
        case 'SELECT_SEARCH_ADDRESS':
            // Store last address and placeId
            localStorage.setItem('lastSearchAddress', action.payload.address);
            localStorage.setItem('lastSearchPlaceId', action.payload.placeId);

            return {
                ...state,
                searchAddress: action.payload.address,
                searchPlaceId: action.payload.placeId
            };

        default: return state;
    }
};

export default reducers;