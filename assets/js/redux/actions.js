import axios from 'axios';

export const notify = notification => ({
    type: 'NOTIFY',
    notification: notification
});

export const notifyError = notification => ({
    type: 'NOTIFY_ERROR',
    notification: notification
});

export const notifyInfo = notification => ({
    type: 'NOTIFY_INFO',
    notification: notification
});

export const notifySuccess = notification => ({
    type: 'NOTIFY_SUCCESS',
    notification: notification
});

export const notifyWarning = notification => ({
    type: 'NOTIFY_WARNING',
    notification: notification
});

export const removeNotification = key => ({
    type: 'REMOVE_NOTIFICATION',
    key: key
});

export const selectSearchAddress = address => ({
    type: 'SELECT_SEARCH_ADDRESS',
    address: address
});

export const searchRestaurantRequest = () => ({
    type: 'SEARCH_RESTAURANT_REQUEST'
});

export const searchRestaurantFailure = () => ({
    type: 'SEARCH_RESTAURANT_FAILURE'
});

export const searchRestaurantSuccess = restaurant => ({
    type: 'SEARCH_RESTAURANT_SUCCESS',
    restaurant: restaurant
});

export const searchRestaurant = request => (dispatch => {
    if (!request.hasOwnProperty('address') || request.address === '') {
        dispatch(notifyWarning('You must provide either an address or coordinates (latitude, longitude)'));

        return;
    }

    dispatch(searchRestaurantRequest());

    axios.interceptors.response.use(
        response => response,
        error => {
            if (error.response) {
                dispatch(notifyError(error.response.data.message || 'Something went wrong'));
                dispatch(searchRestaurantFailure());
            }
        }
    );

    return axios.post('/api/games/roulette', request).then(response => console.log(response));
});