import React from 'react';
import Grid from '@material-ui/core/Grid';
import { withStyles } from '@material-ui/core/styles';

const styles = theme => ({
    content: {
        flexGrow: 1
    },
    root: {
        [theme.breakpoints.up("lg")]: {
            width: 1170
        }
    }
});

class ResponsiveContainer extends React.Component {
    render() {
        return (
            <Grid container justify={"center"}>
                <Grid container className={this.props.classes.root}>
                    <Grid className={this.props.classes.content} item>{this.props.children}</Grid>
                </Grid>
            </Grid>
        )
    }
}

export default withStyles(styles)(ResponsiveContainer);
