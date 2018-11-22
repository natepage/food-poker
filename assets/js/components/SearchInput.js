import React from 'react';
import PropTypes from 'prop-types';
import CircularProgress from '@material-ui/core/CircularProgress';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import PlacesAutocomplete from 'react-places-autocomplete';
import compose from 'recompose/compose';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { selectSearchAddress } from './../redux/actions';
import { withStyles } from '@material-ui/core/styles';

class SearchInput extends React.Component
{
    constructor(props) {
        super(props);

        this.handleChange = this.handleChange.bind(this);
        this.handleSelect = this.handleSelect.bind(this);
    }

    handleChange(address) {
        this.props.selectSearchAddress({address: address});
    };
    handleSelect(address, placeId) {
        this.props.selectSearchAddress({address: address, placeId: placeId});
    };

    render() {
        const { address, classes } = this.props;
        const inputProps = {
            placeholder: 'Search Places ...',
            className: classes.input
        };

        return (
            <div className={classes.root}>
                <PlacesAutocomplete value={address} onChange={this.handleChange} onSelect={this.handleSelect}>
                    {({ getInputProps, suggestions, getSuggestionItemProps, loading }) => (
                        <div>
                            <input {...getInputProps(inputProps)} />
                            <div className={classes.suggestionsContainer} hidden={!loading && suggestions.length <= 0}>
                                {loading && suggestions.length <= 0 &&
                                    <div className={classes.loaderContainer}>
                                        <CircularProgress/>
                                    </div>
                                }
                                <List>
                                    {suggestions.map(suggestion => {
                                        return (
                                            <ListItem button {...getSuggestionItemProps(suggestion)}>
                                                <ListItemText primary={suggestion.description}/>
                                            </ListItem>
                                        );
                                    })}
                                </List>
                            </div>
                        </div>
                    )}
                </PlacesAutocomplete>
            </div>
        )
    }
}

const mapStateToProps = (store) => {
    return {
        address: store.state.address,
        placeId: store.state.placeId
    }
};

const mapDispatchToProps = (dispatch) => {
    return bindActionCreators({ selectSearchAddress }, dispatch);
};

const styles = theme => ({
    input: {
        border: 'none',
        borderRadius: 2,
        boxShadow: theme.shadows[2],
        fontSize: 16,
        outline: 'none',
        padding: 16,
        width: '100%'
    },
    loaderContainer: {
        display: 'flex',
        justifyContent: 'center'
    },
    root: {
        flexGrow: 1,
        fontFamily: theme.typography.fontFamily,
        marginBottom: 16,
        position: 'relative'
    },
    suggestionsContainer: {
        backgroundColor: theme.palette.background.paper,
        boxShadow: theme.shadows[1],
        padding: 16,
        position: 'absolute',
        width: '100%',
        top: 55,
        zIndex: 1600
    }
});

SearchInput.propTypes = {
    address: PropTypes.string.isRequired,
    classes: PropTypes.object.isRequired,
    placeId: PropTypes.string
};

export default compose(withStyles(styles), connect(mapStateToProps, mapDispatchToProps))(SearchInput);