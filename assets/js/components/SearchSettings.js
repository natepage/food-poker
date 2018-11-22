import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Divider from '@material-ui/core/Divider';
import MenuItem from '@material-ui/core/MenuItem';
import TextField from '@material-ui/core/TextField';
import Typography from '@material-ui/core/Typography';
import compose from 'recompose/compose';
import { connect } from 'react-redux';
import { bindActionCreators } from "redux";
import { updateSettingsValid, updateSettingsValue } from "./../redux/actions";
import { withStyles } from '@material-ui/core/styles';

class SearchSettings extends Component
{
    handleChange = event => {
        this.props.updateSettingsValue(event.target.name, event.target.value);
    };

    render() {
        const { classes, settings } = this.props;

        return (
            <div className={classes.root}>
                <div className={classes.header}>
                    <Typography variant={"h6"}>Settings</Typography>
                </div>
                <Divider/>
                <div className={classes.content}>
                    {Object.keys(settings.form).map(setting => {
                        const field = settings.form[setting];

                        return (
                            <div key={'container' + setting} className={classes.fieldContainer}>
                                <TextField
                                    key={'field' + setting}
                                    inputProps={{name: setting}}
                                    error={ field.error || false }
                                    fullWidth
                                    helperText={ field.errorText || '' }
                                    label={ field.label }
                                    onChange={ this.handleChange }
                                    select={field.type === 'select'}
                                    variant={'outlined'}
                                    value={ field.value }
                                >
                                    {field.options && field.options.map(option => (
                                        <MenuItem key={option.value} value={option.value}>
                                            {option.label}
                                        </MenuItem>
                                    ))}
                                </TextField>
                            </div>
                        );
                    })}
                </div>
            </div>
        )
    };
}

const mapStateToProps = store => ({
    settings: store.state.settings
});

const mapDispatchToProps = dispatch => bindActionCreators({
    updateSettingsValid,
    updateSettingsValue
}, dispatch);

const style = theme => ({
    root: {
        flexGrow: 1,
        maxWidth: 400
    },
    header: {
        padding: theme.spacing.unit
    },
    content: {
        maxHeight: 400,
        overflowX: 'hidden',
        overflowY: 'auto',
        padding: theme.spacing.unit
    },
    fieldContainer: {
        padding: theme.spacing.unit
    }
});

SearchSettings.propTypes = {
    classes: PropTypes.object.isRequired,
    settings: PropTypes.object.isRequired
};

export default compose(connect(mapStateToProps, mapDispatchToProps), withStyles(style))(SearchSettings);
