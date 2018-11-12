import React from 'react';
import AppBar from "@material-ui/core/AppBar";
import Toolbar from "@material-ui/core/Toolbar";
import Typography from '@material-ui/core/Typography';
import ResponseContainer from './ResponsiveContainer';

export default class Header extends React.Component {
    render() {
        return (
            <AppBar position={"static"}>
                <ResponseContainer>
                    <Toolbar disableGutters>
                        <Typography variant={"h6"} color={"inherit"}>Foolette</Typography>
                    </Toolbar>
                </ResponseContainer>
            </AppBar>
        );
    }
}
