import { randomKey } from "../utils/common";
import { validateIn, validateNumberBetween } from "../utils/validation";

let defaultState = {
    address: '',
    isSearching: false,
    isSettingsOpened: false,
    latitude: null,
    longitude: null,
    notifications: [],
    placeId: null,
    settings: {
        isValid: true,
        form: {
            avoid: {
                label: 'Avoid',
                value: '',
                type: 'select',
                options: [
                    { label: '', value: '' },
                    { label: 'Ferries', value: 'ferries' },
                    { label: 'Highways', value: 'highways' },
                    { label: 'Indoor', value: 'indoor' },
                    { label: 'Tolls', value: 'tolls' }
                ]
            },
            minPrice: {
                label: 'Min. Price',
                value: 0,
                type: 'text'
            },
            maxPrice: {
                label: 'Max. Price',
                value: 4,
                type: 'text'
            },
            openNow: {
                label: 'Open Now',
                value: '',
                type: 'select',
                options: [
                    { label: '', value: '' },
                    { label: 'True', value: 'true' },
                    { label: 'False', value: 'false' }
                ]
            },
            query: {
                label: 'Keyword',
                value: '',
                type: 'text'
            },
            radius: {
                label: 'Radius',
                value: 500,
                type: 'text'
            },
            mode: {
                label: 'Mode',
                value: 'driving',
                type: 'select',
                options: [
                    { label: 'Bicycling', value: 'bicycling' },
                    { label: 'Driving', value: 'driving' },
                    { label: 'Transit', value: 'transit' },
                    { label: 'Walking', value: 'walking' }
                ]
            },
            units: {
                label: 'Units',
                value: 'metric',
                type: 'select',
                options: [
                    { label: 'Metric', value: 'metric' },
                    { label: 'Imperial', value: 'imperial' }
                ]
            },
        }
    }
};

let notificationFactory = (notification, options = {}) => {
    if (typeof notification === 'string') {
        notification = { message: notification };
    }

    return {
        key: randomKey(),
        ...notification,
        options: {
            ...notification.options,
            ...options
        }
    };
};

let validateSettings = settings => {
    settings.isValid = true;

    Object.keys(settings.form).forEach(name => {
         let field = settings.form[name];
         let value = field.value;

         switch (name) {
             case 'avoid':
                 field.error = validateIn(value, ['', 'ferries', 'highways', 'indoor', 'tolls']);
                 field.errorText = field.error && 'Invalid value';
                 break;
             case 'minPrice':
             case 'maxPrice':
                 field.error = validateNumberBetween(value, 0, 4);
                 field.errorText = field.error &&  field.label + ' must be number between 0, 4';
                 break;
             case 'radius':
                 field.error = validateNumberBetween(value, 50, 50000);
                 field.errorText = field.error && 'Radius must be number between 50, 50000';
                 break;
             case 'mode':
                 field.error = validateIn(value, ['bicycling', 'driving', 'transit', 'walking']);
                 field.errorText = field.error && 'Invalid value';
                 break;
             case 'openNow':
                 field.error = validateIn(value, ['', 'true', 'false']);
                 field.errorText = field.error && 'Invalid value';
                 break;
             case 'units':
                 field.error = validateIn(value, ['metric', 'imperial']);
                 field.errorText = field.error && 'Invalid value';
                 break;
         }

         // Form invalid if at least one field is invalid
         if (field.error) {
            settings.isValid = false;
         }

         return field;
    });

    return settings;
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
                notifications: [notificationFactory(action.notification, { variant: 'error' }), ...state.notifications]
            };

        case 'NOTIFY_INFO':
            return {
                ...state,
                notifications: [notificationFactory(action.notification, { variant: 'info' }), ...state.notifications]
            };

        case 'NOTIFY_SUCCESS':
            return {
                ...state,
                notifications: [notificationFactory(action.notification, { variant: 'success' }), ...state.notifications]
            };

        case 'NOTIFY_WARNING':
            return {
                ...state,
                notifications: [notificationFactory(action.notification, { variant: 'warning' }), ...state.notifications]
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
                address: action.address.address,
                placeId: action.address.placeId
            };

        case 'SEARCH_RESTAURANT_REQUEST':
            return { ...state, isSearching: true };

        case 'SEARCH_RESTAURANT_FAILURE':
            return { ...state, isSearching: false };

        case 'TOGGLE_SETTINGS':
            return { ...state, isSettingsOpened: !state.isSettingsOpened };

        case 'UPDATE_SETTINGS_VALUE':
            return {
                ...state,
                settings: validateSettings({
                    form: {
                        ...state.settings.form,
                        [action.name]: {
                            ...state.settings.form[action.name],
                            value: action.value
                        }
                    }
                })
            };

        case 'UPDATE_SETTINGS_VALID':
            return { ...state, settings: { ...state.settings, isValid: action.valid } };

        default:
            return state;
    }
};

export default reducers;