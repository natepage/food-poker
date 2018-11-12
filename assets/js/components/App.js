import React from 'react';
import CssBaseline from '@material-ui/core/CssBaseline';
import Header from './Header';
import SearchPage from "./SearchPage";

export default class App extends React.Component {
    render() {
        return (
            <React.Fragment>
                <CssBaseline/>
                <Header/>
                <SearchPage/>
            </React.Fragment>
        );
    }
}