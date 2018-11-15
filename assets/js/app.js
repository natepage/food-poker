import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { SnackbarProvider } from 'notistack';
import { store } from "./redux/store";
import App from './components/App';

window.__MUI_USE_NEXT_TYPOGRAPHY_VARIANTS__ = true;

ReactDOM.render(
    <Provider store={store}>
        <SnackbarProvider>
            <App/>
        </SnackbarProvider>
    </Provider>,
    document.getElementById('app')
);
