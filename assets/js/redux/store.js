import { applyMiddleware, createStore, combineReducers } from 'redux';
import thunkMiddleware from 'redux-thunk'
import { createLogger } from 'redux-logger'
import reducers from './reducers';

const loggerMiddleware = createLogger();

export const store = createStore(
    combineReducers({state: reducers}),
    applyMiddleware(thunkMiddleware, loggerMiddleware),
    window.__REDUX__DEVTOOLS_EXTENSION__ && window.__REDUX__DEVTOOLS_EXTENSION__()
);