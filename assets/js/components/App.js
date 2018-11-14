import React from 'react';
import CssBaseline from '@material-ui/core/CssBaseline';
import Header from './Header';
import SearchPage from "./SearchPage";
import Notifier from "./Notifier";

export default class App extends React.Component {
    render() {
        return (
            <React.Fragment>
                <CssBaseline/>
                <Notifier/>
                <Header/>
                <SearchPage/>
            </React.Fragment>
        );
    }
}