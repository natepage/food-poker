import React from 'react';
import { createStore, combineReducers } from 'redux';
import reducers from './reducers';

export const store = createStore(
    combineReducers({state: reducers}),
    window.__REDUX__DEVTOOLS_EXTENSION__ && window.__REDUX__DEVTOOLS_EXTENSION__()
);