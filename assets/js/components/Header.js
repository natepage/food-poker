import React, { Component } from 'react';
import PropTypes from 'prop-types';
import AppBar from "@material-ui/core/AppBar";
import IconButton from "@material-ui/core/IconButton/IconButton";
import Toolbar from "@material-ui/core/Toolbar";
import Typography from '@material-ui/core/Typography';
import ResponseContainer from './ResponsiveContainer';
import Settings from '@material-ui/icons/Settings';
import compose from 'recompose/compose';
import { connect } from 'react-redux';
import { bindActionCreators } from "redux";
import { toggleSettings } from './../redux/actions';
import { withStyles } from '@material-ui/core/styles';

class Header extends Component {
    handleClickSettings = () => {
        this.props.toggleSettings();
    };

    render () {
        const { classes } = this.props;

        return (
            <AppBar className={classes.grow} position={"static"}>
                <ResponseContainer>
                    <Toolbar disableGutters>
                        <Typography className={classes.grow} variant={"h6"} color={"inherit"}>
                            Foolette
                        </Typography>
                        <div>
                            <IconButton color={"inherit"} onClick={this.handleClickSettings}>
                                <Settings/>
                            </IconButton>
                        </div>
                    </Toolbar>
                </ResponseContainer>
            </AppBar>
        );
    }
}

const mapDispatchToProps = dispatch => bindActionCreators({ toggleSettings }, dispatch);

const style = {
    grow: {
        flexGrow: 1
    }
};

Header.propTypes = {
    classes: PropTypes.object.isRequired,
    toggleSettings: PropTypes.func.isRequired
};

export default compose(connect(null, mapDispatchToProps), withStyles(style))(Header);
