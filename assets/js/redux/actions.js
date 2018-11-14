import axios from 'axios';

export const addNotification = (notification) => ({
    type: 'ADD_NOTIFICATION',
    notification: notification
});

export const removeNotification = (key) => ({
    type: 'REMOVE_NOTIFICATION',
    key: key
});

export const selectSearchAddress = (address) => ({
    type: 'SELECT_SEARCH_ADDRESS',
    address: address
});

export const searchRestaurantRequest = () => ({
    type: 'SEARCH_RESTAURANT_REQUEST'
});

export const searchRestaurantFailure = () => ({
    type: 'SEARCH_RESTAURANT_FAILURE'
});

export const searchRestaurantSuccess = (restaurant) => ({
    type: 'SEARCH_RESTAURANT_SUCCESS',
    restaurant: restaurant
});

export const searchRestaurant = (request) => (
    dispatch => {
        if (!request.hasOwnProperty('address') || request.address === '') {
            dispatch(addNotification({
                message: 'You must provide either an address or coordinates (latitude, longitude)',
                type: 'error'
            }));

            return;
        }

        dispatch(searchRestaurantRequest());

        axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response) {
                    dispatch(addNotification({
                        message: error.response.data.message || 'Something went wrong',
                        type: 'error'
                    }));
                    dispatch(searchRestaurantFailure());
                }
            }
        );

        return axios.post('/api/games/roulette', request).then(response => console.log(response));
    }
);