import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { SnackbarProvider } from 'notistack';
import { store } from "./redux/store";
import App from './components/App';

ReactDOM.render(
    <Provider store={store}>
        <SnackbarProvider>
            <App/>
        </SnackbarProvider>
    </Provider>, document.getElementById('app'));
